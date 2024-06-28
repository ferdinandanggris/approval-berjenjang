@extends('layouts.main')
@section('container')
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title">Create User</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mt-3">
                  <form action="{{ route('user.update', ['id' => $user->id]) }}" method="post">
                    @method('put')
                    @csrf
                        <div class="mb-3 form-group row">
                          <label for="name" class="col-form-label col-sm-2">Name</label>
                          <div class="col-sm-10">
                            <input type="name" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                          </div>
                      </div>
                        <div class="mb-3 form-group row">
                            <label for="role" class="col-form-label col-sm-2">Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="role" required>
                                    <option selected>Choose Role</option>
                                    @foreach ($roles as $role)
                                        @if ($role['id'] == $user->role)
                                            <option selected value="{{ $role['id'] }}" selected>{{ $role['name'] }}</option>
                                        @else
                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                          <label for="email" class="col-form-label col-sm-2">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" required value="{{$user->email}}">
                          </div>
                        </div>
                      </div>
                        <div class="form-group d-flex justify-content-end gap-2">
                            <div class="mr-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            <div class="">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
