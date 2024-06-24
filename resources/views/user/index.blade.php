@php
    function badgeColor($role){
        switch ($role) {
            case 'officer':
                # code...
                return 'bg-primary';
                break;
            case 'hr':
                # code...
                return 'bg-success';
                break;
            case 'finance':
                # code...
                return 'bg-warning';
                break;
            case 'employee':
                # code...
                return 'bg-info';
                break;
            default:
                # code...
                return 'bg-primary';
                break;
        }
    }
@endphp

@extends('layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h3>List User</h3>
    </div>
    @if (session('success'))
        <div class="row">
            <div class="col-lg-8">
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
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-uppercase"> <span class="badge {{badgeColor($user->role)}}">{{$user->role}}</span> </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection