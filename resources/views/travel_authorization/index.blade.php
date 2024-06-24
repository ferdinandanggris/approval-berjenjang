@php
    function statusText($status)
    {
        if ($status == 0) {
            return 'Pending with ';
        } elseif ($status == 1) {
            return 'Approved by ';
        } elseif ($status == 2) {
            return 'Rejected by ';
        }
    }

    function statusClass($status)
    {
        if ($status == 0) {
            return 'badge bg-warning';
        } elseif ($status == 1) {
            return 'badge bg-success';
        } elseif ($status == 2) {
            return 'badge bg-danger';
        }
    }

    function textTooltip()
    {
        switch (auth()->user()->role) {
            case 'finance':
                return 'Anda Dapat Melakukan Approval apabila Human Resource & Officer sudah Menyetujui';
                break;
            case 'hr':
                return 'Anda Dapat Melakukan Approval apabila Officer sudah Menyetujui';
                break;
            default:
                return '';
                break;
        }
    }
@endphp

@extends('layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h3>List Travel Authorization</h3>
    </div>
    @if (session('success'))
        <div class="row">
            <div class="col-lg-10">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-start">
                            <div class="">
                                <a class="btn btn-primary mb-2 mx-2" href="/travel_authorization/create">Create Travel
                                    Authorization</a>
                            </div>
                            <div class="">
                                <a href="/travel_authorization/excel" class="btn btn-success" target="_blank"
                                    rel="noopener noreferrer">Export Excel</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <form action="/travel_authorization" class="mx-2" method="get">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search..." name="search"
                                        value="{{ $search }}" id="search">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                                            class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col" class="text-center">Date</th>
                                    <th scope="col">Status</th>
                                    @if (auth()->user()->role == 'hr' || auth()->user()->role == 'finance')
                                        <th scope="col" data-toggle="tooltip" title="{{ textTooltip() }}">Approval</th>
                                    @endif
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($travelAuthorizations as $travelAuthorization)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $travelAuthorization->user->name }}</td>
                                        <td>{{ $travelAuthorization->reason }}</td>
                                        <td class="text-center">
                                            {{ date('d-m-Y', strtotime($travelAuthorization->start_date)) }} -
                                            {{ date('d-m-Y', strtotime($travelAuthorization->end_date)) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ statusClass($travelAuthorization->is_approve_officer) }}">{{ statusText($travelAuthorization->is_approve_officer) }}
                                                Officer</span><br>
                                            <span
                                                class="badge {{ statusClass($travelAuthorization->is_approve_hr) }}">{{ statusText($travelAuthorization->is_approve_hr) }}
                                                Human Resources Manager</span><br>
                                            <span
                                                class="badge {{ statusClass($travelAuthorization->is_approve_finance) }}">{{ statusText($travelAuthorization->is_approve_finance) }}
                                                Finance Manager</span><br>
                                        </td>
                                        @if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer' || auth()->user()->role == 'finance')
                                            <td>
                                                <div class="btn-group btn-sm mb-1" role="group"
                                                    aria-label="Basic example">
                                                    <form
                                                        action="/travel_authorization/{{ $travelAuthorization->id }}/approve"
                                                        class="btn-group" method="post">
                                                        @csrf
                                                        <button id="btn-reject" type="submit" id="approve" name="submit"
                                                            @php
if (($travelAuthorization->is_approve_officer == 0 || $travelAuthorization->is_approve_officer == 2)){
                                                if (auth()->user()->role == 'officer'){
                                                    
                                                }else{
                                                  echo 'disabled';
                                                }
                                                }else if($travelAuthorization->is_approve_hr == 0 || $travelAuthorization->is_approve_hr == 2){
                                                if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer'){
        
                                                }else{
                                                    echo 'disabled';
                                                }
                                                } @endphp
                                                            onclick="return confirm('Are you sure?')"
                                                            class="btn btn-sm btn-success"><i
                                                                class="bi bi-check-lg"></i></button>
                                                    </form>
                                                    <form
                                                        action="/travel_authorization/{{ $travelAuthorization->id }}/reject"
                                                        method="post" class="btn-group">
                                                        @csrf
                                                        <button name="submit" onclick="return confirm('Are you sure?')"
                                                            @php
if (($travelAuthorization->is_approve_officer == 0 || $travelAuthorization->is_approve_officer == 2)){
                                                if (auth()->user()->role == 'officer'){
                                                    
                                                }else{
                                                  echo 'disabled';
                                                }
                                                }else if($travelAuthorization->is_approve_hr == 0 || $travelAuthorization->is_approve_hr == 2){
                                                if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer'){
                                                    
                                                }else{
                                                    echo 'disabled';
                                                }
                                                } @endphp
                                                            type="submit" class="btn btn-sm btn-danger"><i
                                                                class="bi bi-x"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="/travel_authorization/{{ $travelAuthorization->id }}/edit"
                                                class="badge bg-warning mb-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/travel_authorization/{{ $travelAuthorization->id }}/delete"
                                                method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="d-inline border-0 badge bg-danger mb-1"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
