<?php

namespace App\Http\Controllers;

use App\Exports\TravelAuthorizationExport;
use App\Models\LeaveApplication;
use App\Models\TravelAuthorization;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TravelAuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        if (auth()->user()->role == 'employee') {
            $travelAuthorizations = TravelAuthorization::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->where('user_id', auth()->user()->id)->get();
        }else{
            $travelAuthorizations = TravelAuthorization::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%"); 
                });
            })
            ->with('user')->get();
        }
        return view('travel_authorization.index', [
            'travelAuthorizations' => $travelAuthorizations,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        return view('travel_authorization.create',[
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required',
        ]);

        $payload = $request->only('user_id', 'start_date', 'end_date', 'reason');
        $payload['user_id'] = auth()->user()->id;
        $payload['status'] = 'Pending with Approval Officer';

        $travelAuthorization = TravelAuthorization::create($payload);
        if ($travelAuthorization) {
            return redirect()->route('travel_authorization.index')->with('success', 'Travel authorization created successfully');
        } else {
            return redirect()->route('travel_authorization.index')->with('error', 'Failed to create travel authorization');
        }
    }

    /**
     * Show the detail specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $travelAuthorization = TravelAuthorization::find($id);
        return view('travel_authorization.detail', [
            'travelAuthorization' => $travelAuthorization
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $travelAuthorization = TravelAuthorization::find($id);
        $users = User::get();
        return view('travel_authorization.edit', [
            'travelAuthorization' => $travelAuthorization,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required',
        ]);

        $payload = $request->only('user_id', 'start_date', 'end_date', 'reason', 'status');
        $payload['user_id'] = auth()->user()->id;
        $travelAuthorization = TravelAuthorization::find($id);
        $travelAuthorization->update($payload);

        return redirect()->route('travel_authorization.index')->with('success', 'Travel authorization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TravelAuthorization::destroy($id);
        return redirect()->route('travel_authorization.index')->with('success', 'Travel authorization deleted successfully');
    }

    public function approve(Request $request,$id)
    {
        $status = $this->setStatus('approve', $id, $request->reason);
        if ($status == '') {
            return redirect()->route('travel_authorization.index')->with('error', 'You are not authorized to perform this action');
        }


        return redirect()->route('travel_authorization.index')->with('success', 'Leave application status updated successfully');
    }

    public function reject(Request $request,$id)
    {
        $status = $this->setStatus('reject', $id, $request->reason);
        if ($status['status'] == true) {
            return redirect()->route('travel_authorization.index')->with('success', 'Leave application status updated successfully');
        } else {
            return redirect()->route('travel_authorization.index')->with('error', 'You are not authorized to perform this action');
        }
    }

    public function setStatus($status, $id, $reason = ''){
        $user = auth()->user();
        $role = $user->role;
        $user_id = $user->id;
        $travelAuthorization = TravelAuthorization::find($id);
        $text = "";
        switch ($role) {
            case 'officer':
                $text = "by Officer";
                if ($status == 'approve') {
                    $travelAuthorization->is_approve_officer = 1;
                    $travelAuthorization->officer_id = $user_id;
                    $travelAuthorization->officer_reason = $reason;
                } else {
                    $travelAuthorization->is_approve_officer = 2;
                    $travelAuthorization->officer_id = $user_id;
                    $travelAuthorization->officer_reason = $reason;
                }
                break;
            case 'hr': 
                #code 
                $text = "by HR Manager";
                if ($status == 'approve') {
                    $travelAuthorization->is_approve_hr = 1;
                    $travelAuthorization->hr_id = $user_id;
                    $travelAuthorization->hr_reason = $reason;
                } else {
                    $travelAuthorization->is_approve_hr = 2;
                    $travelAuthorization->hr_id = $user_id;
                    $travelAuthorization->hr_reason = $reason;
                }
                break;
            case 'employee':
                #code
                return ['status' => false];
                break;
            case 'finance':
                #code
                $text = "by Finance Manager";
                if ($status == 'approve') {
                    $travelAuthorization->is_approve_finance = 1;
                    $travelAuthorization->finance_id = $user_id;
                    $travelAuthorization->finance_reason = $reason;
                } else {
                    $travelAuthorization->is_approve_finance = 2;
                    $travelAuthorization->finance_id = $user_id;
                    $travelAuthorization->finance_reason = $reason;
                }
                break;
            default:
                return ['status' => false];
                break;
                
            }
            
            if ($status == 'approve') {
                $text = "Approved $text";
            } else {
                $text = "Rejected $text";
            }
            $travelAuthorization->status = $text;
            $travelAuthorization->save();
            return [
                'status' => true,
                'text' => $text
            ];
    }

    public function excel(Request $request){
        $search = $request->search ?? '';
        if (auth()->user()->role == 'employee') {
            $travelAuthorizations = TravelAuthorization::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->where('user_id', auth()->user()->id)->get();
        }else{
            $travelAuthorizations = TravelAuthorization::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->with('user')->get();
        }

        return Excel::download(new TravelAuthorizationExport($travelAuthorizations), 'travel_authorizations.xlsx');
    }
}
