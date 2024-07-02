@php
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

@endphp
@extends('layouts.main')
@section('container')
    <h5 class="text-title">Detail Leave Application</h5>
    <div class="row jutify-content-center">
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <p class="fw-bold my-0" style="font-size: 1.2rem">{{ $leaveApplication->user->name }}</p>
                            <p class="mt-0" style="font-size: .8rem">{{ $leaveApplication->user->email }}</p>
                        </div>
                        <div class="">
                            <span
                                class="badge {{ roleBadgeColor($leaveApplication->user->role) }} text-uppercase">{{ $leaveApplication->user->role }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Start Date</p>
                        <p class="my-1">{{ formatTanggal(strtotime($leaveApplication->start_date)) }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">End Date</p>
                        <p class="my-1">{{ formatTanggal(strtotime($leaveApplication->end_date)) }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Reason</p>
                        <p class="my-1">{{ $leaveApplication->reason }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Approval</h5>
                    <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="fw-bold my-0" style="font-size: 1.2rem">
                                        {{ $leaveApplication->officer->name ?? 'Officer Name' }} <span
                                            class="my-0 fw-normal"
                                            style="font-size: .8rem">({{ $leaveApplication->officer->email ?? 'Officer Email' }})</span>
                                    </p>
                                    <span
                                        class="badge {{ roleBadgeColor($leaveApplication->officer->role ?? 'officer') }} text-uppercase">{{ $leaveApplication->officer->role ?? 'officer' }}</span>
                                </div>
                                <div class="">
                                    <span
                                        class="{{ statusClass($leaveApplication->is_approve_officer) }} text-white text-uppercase">{{ $leaveApplication->is_approve_officer == 0 ? 'Pending' : ($leaveApplication->is_approve_officer == 1 ? 'Approved' : 'Rejected') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="fw-bold my-0" style="font-size: 1.2rem">
                                        {{ $leaveApplication->hr->name ?? 'HR Name' }} <span class="my-0 fw-normal"
                                            style="font-size: .8rem">({{ $leaveApplication->hr->email ?? 'HR Email' }})</span>
                                    </p>
                                    <span
                                        class="badge {{ roleBadgeColor($leaveApplication->hr->role ?? 'hr') }} text-uppercase">{{ $leaveApplication->hr->role ?? 'hr' }}</span>
                                </div>
                                <div class="">
                                    <span
                                        class="{{ statusClass($leaveApplication->is_approve_hr) }} text-white text-uppercase">{{ $leaveApplication->is_approve_hr == 0 ? 'Pending' : ($leaveApplication->is_approve_hr == 1 ? 'Approved' : 'Rejected') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-2">
        <a href="/leave_application" class="btn btn-secondary">Back</a>
        @if (checkRole(auth(),'hr') || checkRole(auth(),'officer'))
            <form action="/leave_application/{{ $leaveApplication->id }}/approve" class="m-0 p-0" method="post">
                @csrf
                <button id="btn-reject" type="submit" id="approve" name="submit"
                    <?= checkIsHaveAccess(auth(), $leaveApplication) ? '' : 'disabled' ?>
                    onclick="return confirm('Are you sure?')" class="btn btn-success rounded-start mx-1"> Approve
                </button>
            </form>
            <form action="/leave_application/{{ $leaveApplication->id }}/reject" method="post" class="m-0 p-0">
                @csrf
                <button name="submit" onclick="return confirm('Are you sure?')"
                    <?= checkIsHaveAccess(auth(), $leaveApplication) ? '' : 'disabled' ?> type="submit"
                    class="btn btn-danger rounded-end">Decline</button>
            </form>
        @endif
    </div>
@endsection
