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

    function roleBadgeColor($role){
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
                            <span class="badge {{roleBadgeColor($travelAuthorization->user->role)}} text-uppercase">{{ $travelAuthorization->user->role }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Start Date</p> 
                        <p class="my-1">{{date('d F Y', strtotime($travelAuthorization->start_date))}}</p> 
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">End Date</p> 
                        <p class="my-1">{{date('d F Y', strtotime($travelAuthorization->end_date))}}</p> 
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="my-1">Reason</p> 
                        <p class="my-1">{{$travelAuthorization->reason}}</p> 
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
                            <p class="fw-bold my-0" style="font-size: 1.2rem">{{ $travelAuthorization->officer->name ?? 'Officer Name' }} <span class="my-0 fw-normal" style="font-size: .8rem">({{ $travelAuthorization->officer->email ?? 'Officer Email' }})</span></p>
                            <span class="badge {{roleBadgeColor($travelAuthorization->officer->role ?? 'officer')}} text-uppercase">{{ $travelAuthorization->officer->role ?? 'officer' }}</span>
                        </div>
                        <div class="">
                          <span class="{{statusClass($travelAuthorization->is_approve_officer)}} text-white text-uppercase">{{$travelAuthorization->is_approve_officer == 0 ? 'Pending' : ($travelAuthorization->is_approve_officer == 1 ? 'Approved' : 'Rejected')}}</span>
                        </div>
                    </div>
                </div>
            </div>
              <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <p class="fw-bold my-0" style="font-size: 1.2rem">{{ $travelAuthorization->hr->name ?? 'HR Name' }} <span class="my-0 fw-normal" style="font-size: .8rem">({{ $travelAuthorization->hr->email ?? 'HR Email' }})</span></p>
                            <span class="badge {{roleBadgeColor($travelAuthorization->hr->role ?? 'hr')}} text-uppercase">{{ $travelAuthorization->hr->role ?? 'hr' }}</span>
                        </div>
                        <div class="">
                          <span class="{{statusClass($travelAuthorization->is_approve_hr)}} text-white text-uppercase">{{$travelAuthorization->is_approve_hr == 0 ? 'Pending' : ($travelAuthorization->is_approve_hr == 1 ? 'Approved' : 'Rejected')}}</span>
                        </div>
                    </div>
                </div>
            </div>
              <div class="card mt-3 border" style="box-shadow: 0 0 0 0;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <p class="fw-bold my-0" style="font-size: 1.2rem">{{ $travelAuthorization->finance->name ?? 'Finance Name' }} <span class="my-0 fw-normal" style="font-size: .8rem">({{ $travelAuthorization->finance->email ?? 'Finance Email' }})</span></p>
                            <span class="badge {{roleBadgeColor($travelAuthorization->finance->role ?? 'finance')}} text-uppercase">{{ $travelAuthorization->finance->role ?? 'finance' }}</span>
                        </div>
                        <div class="">
                          <span class="{{statusClass($travelAuthorization->is_approve_finance)}} text-white text-uppercase">{{$travelAuthorization->is_approve_finance == 0 ? 'Pending' : ($travelAuthorization->is_approve_finance == 1 ? 'Approved' : 'Rejected')}}</span>
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
      <form
      action="/travel_authorization/{{ $travelAuthorization->id }}/approve"
      class="mx-1 my-0 p-0" method="post">
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
          class="btn btn-success rounded-start">Approve</i></button>
  </form>
  <form
                                                        action="/travel_authorization/{{ $travelAuthorization->id }}/reject"
                                                        method="post" class=" m-0 p-0">
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
                                                            type="submit" class="btn btn-danger rounded-end">Decline</button>
                                                    </form>
    </div>
@endsection
