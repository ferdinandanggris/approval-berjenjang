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
        <h3>Dashboard</h3>
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
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Leave Application Latest</h5>
                <a href="/leave_application" class="btn btn-primary">Selengkapnya</a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover table-sm">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Reason</th>
                              <th scope="col" class="text-center">Date</th>
                              <th scope="col">Status</th>
                              @if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer')
                                  <th scope="col" data-toggle="tooltip" title="{{ textTooltip() }}">Approval</th>
                              @endif
                              <th scope="col">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($leaveApplications as $leaveApplication)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $leaveApplication->user->name ?? '' }}</td>
                                  <td>{{ $leaveApplication->reason }}</td>
                                  <td class="text-center">{{date('d-m-Y',strtotime($leaveApplication->start_date))}} - {{date('d-m-Y',strtotime($leaveApplication->end_date))}}</td>
                                  <td>
                                      <span
                                          class="badge {{ statusClass($leaveApplication->is_approve_officer) }}">{{ statusText($leaveApplication->is_approve_officer) }}
                                          Officer</span><br>
                                      <span
                                          class="badge {{ statusClass($leaveApplication->is_approve_hr) }}">{{ statusText($leaveApplication->is_approve_hr) }}
                                          Human Resources Manager</span><br>
                                  </td>
                                  @if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer')
                                      <td>
                                          <div class="btn-group btn-sm mb-1" role="group" aria-label="Basic example">
                                              <form action="/leave_application/{{ $leaveApplication->id }}/approve"
                                                  class="btn-group m-0 p-0" method="post">
                                                  @csrf
                                                  <button id="btn-reject" type="submit" id="approve" name="submit"
                                                      @php
  if (($leaveApplication->is_approve_officer == 0 || $leaveApplication->is_approve_officer == 2) ){
                                              if (auth()->user()->role == 'officer'){
                                              }else{
                                                echo 'disabled';
                                              }
                                              } @endphp
                                                      onclick="return confirm('Are you sure?')"
                                                      class="btn btn-sm btn-success rounded-start"><i class="bi bi-check-lg"></i></button>
                                              </form>
                                              <form action="/leave_application/{{ $leaveApplication->id }}/reject"
                                                  method="post" class="btn-group m-0 p-0">
                                                  @csrf
                                                  <button name="submit" onclick="return confirm('Are you sure?')"
                                                      @php
  if (($leaveApplication->is_approve_officer == 0 || $leaveApplication->is_approve_officer == 2) ){
                                              if (auth()->user()->role == 'officer'){
                                              }else{
                                                echo 'disabled';
                                              }
                                              } @endphp
                                                      type="submit" class="btn btn-sm btn-danger rounded-end"><i
                                                          class="bi bi-x"></i></button>
                                              </form>
                                          </div>
                                      </td>
                                  @endif
                                  <td>
                                      <a href="/leave_application/{{ $leaveApplication->id }}/edit"
                                          class="badge bg-warning mb-1"><i class="bi bi-pencil-square"></i></a>
                                      <form action="/leave_application/{{ $leaveApplication->id }}/delete" method="post">
                                          @method('delete')
                                          @csrf
                                          <button class="d-inline border-0 badge bg-danger mb-1"
                                              onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
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


    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
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
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                  Travel Authorization Latest
                </h5>
                <a href="/travel_authorization" class="btn btn-primary">Selengkapnya</a>
              </div>
            </div>
              <div class="card-body">
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
                                      <th scope="col" data-toggle="tooltip" title="{{ textTooltipTravel() }}">Approval</th>
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
                                      <td class="text-center">{{date('d-m-Y',strtotime($travelAuthorization->start_date))}} - {{date('d-m-Y',strtotime($travelAuthorization->end_date))}}</td>
                                      <td>
                                          <span
                                              class="badge {{ statusClassTravel($travelAuthorization->is_approve_officer) }}">{{ statusText($travelAuthorization->is_approve_officer) }}
                                              Officer</span><br>
                                          <span
                                              class="badge {{ statusClassTravel($travelAuthorization->is_approve_hr) }}">{{ statusText($travelAuthorization->is_approve_hr) }}
                                              Human Resources Manager</span><br>
                                          <span
                                              class="badge {{ statusClassTravel($travelAuthorization->is_approve_finance) }}">{{ statusText($travelAuthorization->is_approve_finance) }}
                                              Finance Manager</span><br>
                                      </td>
                                      @if (auth()->user()->role == 'hr' || auth()->user()->role == 'officer' || auth()->user()->role == 'finance')
                                          <td>
                                              <div class="btn-group btn-sm mb-1" role="group" aria-label="Basic example">
                                                  <form action="/travel_authorization/{{ $travelAuthorization->id }}/approve"
                                                      class="btn-group m-0 p-0" method="post">
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
                                                          class="btn btn-sm btn-success rounded-start"><i class="bi bi-check-lg"></i></button>
                                                  </form>
                                                  <form action="/travel_authorization/{{ $travelAuthorization->id }}/reject"
                                                      method="post" class="btn-group m-0 p-0">
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
                                                          type="submit" class="btn btn-sm btn-danger rounded-end    "><i
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
                                                  onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
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


{{-- Travel Authorization --}}
@php
    function statusTextTravel($status)
    {
        if ($status == 0) {
            return 'Pending with ';
        } elseif ($status == 1) {
            return 'Approved by ';
        } elseif ($status == 2) {
            return 'Rejected by ';
        }
    }

    function statusClassTravel($status)
    {
        if ($status == 0) {
            return 'badge bg-warning';
        } elseif ($status == 1) {
            return 'badge bg-success';
        } elseif ($status == 2) {
            return 'badge bg-danger';
        }
    }

    function textTooltipTravel()
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
