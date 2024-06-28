@extends('layouts.main')
@section('container')
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title">Create Travel Authorization</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <form action="{{ route('travel_authorization.store') }}" method="post">
                        @csrf
                        <div class="mb-3 form-group row">
                            <label for="name" class="col-form-label col-sm-2">Name</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="user_id" required disabled>
                                    <option selected>Choose User</option>
                                    @foreach ($users as $user)
                                        @if ($user->id == auth()->user()->id)
                                            <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="harga" class="col-form-label col-sm-2">Reason</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="reason" placeholder="Leave a reason here" required id="floatingTextarea"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="kelas" class="col-form-label col-sm-2">Start Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="kelas" class="col-form-label col-sm-2">End Date</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-end gap-2">
                            <div class="mr-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            <div class="">
                                <a href="{{ route('travel_authorization.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
