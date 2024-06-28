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
                                <a class="btn btn-primary mb-2 mx-2" href="/user/create">Create User</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-uppercase"> <span class="badge {{badgeColor($user->role)}}">{{$user->role}}</span> </td>
                                        <td>
                                            <a href="/user/{{ $user->id }}/edit"
                                                class="badge bg-warning mb-1"><i class="bi bi-pencil-square"></i></a>
                                            <form action="/user/{{ $user->id }}/delete"
                                                method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="d-inline border-0 badge bg-danger mb-1"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection