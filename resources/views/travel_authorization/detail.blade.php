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
    <h5 class="text-title">Detail Travel Authorization</h5>
    <div class="row jutify-content-center">
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <p class="fw-bold my-0" style="font-size: 1.2rem">{{ $travelAuthorization->user->name }}</p>
                            <p class="mt-0" style="font-size: .8rem">{{ $travelAuthorization->user->email }}</p>
                        </div>
                        <div class="">
                            <span
                                class="badge {{ roleBadgeColor($travelAuthorization->user->role) }} text-uppercase">{{ $travelAuthorization->user->role }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Start Date</p>
                        <p class="my-1">{{ formatTanggal(strtotime($travelAuthorization->start_date)) }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">End Date</p>
                        <p class="my-1">{{ formatTanggal(strtotime($travelAuthorization->end_date)) }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Reason</p>
                        <p class="my-1">{{ $travelAuthorization->reason }}</p>
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
                                        {{ $travelAuthorization->officer->name ?? 'Officer Name' }} <span
                                            class="my-0 fw-normal"
                                            style="font-size: .8rem">({{ $travelAuthorization->officer->email ?? 'Officer Email' }})</span>
                                    </p>
                                    <span
                                        class="badge {{ roleBadgeColor($travelAuthorization->officer->role ?? 'officer') }} text-uppercase">{{ $travelAuthorization->officer->role ?? 'officer' }}</span>
                                    @if ($travelAuthorization->is_approve_officer > 0)
                                        <p class="my-0 text-muted">
                                            Catatan : {{ $travelAuthorization->officer_reason }}
                                        </p>
                                    @endif
                                </div>
                                <div class="">
                                    <span
                                        class="{{ statusClass($travelAuthorization->is_approve_officer) }} text-white text-uppercase">{{ $travelAuthorization->is_approve_officer == 0 ? 'Pending' : ($travelAuthorization->is_approve_officer == 1 ? 'Approved' : 'Rejected') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="fw-bold my-0" style="font-size: 1.2rem">
                                        {{ $travelAuthorization->hr->name ?? 'HR Name' }} <span class="my-0 fw-normal"
                                            style="font-size: .8rem">({{ $travelAuthorization->hr->email ?? 'HR Email' }})</span>
                                    </p>
                                    <span
                                        class="badge {{ roleBadgeColor($travelAuthorization->hr->role ?? 'hr') }} text-uppercase">{{ $travelAuthorization->hr->role ?? 'hr' }}</span>
                                    @if ($travelAuthorization->is_approve_hr > 0)
                                        <p class="my-0 text-muted">
                                            Catatan : {{ $travelAuthorization->hr_reason }}
                                        </p>
                                    @endif
                                </div>
                                <div class="">
                                    <span
                                        class="{{ statusClass($travelAuthorization->is_approve_hr) }} text-white text-uppercase">{{ $travelAuthorization->is_approve_hr == 0 ? 'Pending' : ($travelAuthorization->is_approve_hr == 1 ? 'Approved' : 'Rejected') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="fw-bold my-0" style="font-size: 1.2rem">
                                        {{ $travelAuthorization->finance->name ?? 'Finance Name' }} <span
                                            class="my-0 fw-normal"
                                            style="font-size: .8rem">({{ $travelAuthorization->finance->email ?? 'Finance Email' }})</span>
                                    </p>
                                    <span
                                        class="badge {{ roleBadgeColor($travelAuthorization->finance->role ?? 'finance') }} text-uppercase">{{ $travelAuthorization->finance->role ?? 'finance' }}</span>
                                    @if ($travelAuthorization->is_approve_finance > 0)
                                        <p class="my-0 text-muted">
                                            Catatan : {{ $travelAuthorization->finance_reason }}
                                        </p>
                                    @endif
                                </div>
                                <div class="">
                                    <span
                                        class="{{ statusClass($travelAuthorization->is_approve_finance) }} text-white text-uppercase">{{ $travelAuthorization->is_approve_finance == 0 ? 'Pending' : ($travelAuthorization->is_approve_finance == 1 ? 'Approved' : 'Rejected') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-2">
        <a href="/travel_authorization" class="btn btn-secondary">Kembali</a>
        @if (checkRole(auth(), 'hr') || checkRole(auth(), 'officer') || checkRole(auth(), 'finance'))
            <form action="/travel_authorization/{{ $travelAuthorization->id }}/approve" class="m-0 p-0" method="post">
                @csrf
                <button
                    onclick="sendLinkActionToModal('/travel_authorization/' +{{ $travelAuthorization->id }} +'/approve')"
                    type="button" class="mx-1 btn btn-success rounded-start" data-bs-toggle="modal"
                    data-bs-target="#approvalModal"
                    <?= checkIsHaveAccess(auth(), $travelAuthorization) ? '' : 'disabled' ?>>
                    Approve
                </button>
            </form>
            <form action="/travel_authorization/{{ $travelAuthorization->id }}/reject" method="post" class="m-0 p-0">
                @csrf
                <button
                    onclick="sendLinkActionToModal('/travel_authorization/' +{{ $travelAuthorization->id }} +'/reject')"
                    type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#approvalModal"
                    <?= checkIsHaveAccess(auth(), $travelAuthorization) ? '' : 'disabled' ?>>Decline</button>
            </form>
        @endif
    </div>
@endsection
