<?php

namespace App\Http\Controllers;

use App\Exports\LeaveApplicationExport;
use App\Models\LeaveApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LeaveApplicationController extends Controller
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
            $leaveApplications = LeaveApplication::when($search, function ($query, $search) {
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
            $leaveApplications = LeaveApplication::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })->with('user')->get();
        }
        return view('leave_application.index', [
            'leaveApplications' => $leaveApplications,
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
        return view('leave_application.create', ['users' => $users]);
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
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required',
        ]);

        $payload = $request->only('user_id', 'start_date', 'end_date', 'reason');
        $payload['status'] = 'Pending with Approval Officer';

        $leaveApplication = LeaveApplication::create($payload);
        if ($leaveApplication) {
            return redirect()->route('leave_application.index')->with('success', 'Leave application created successfully');
        } else {
            return redirect()->route('leave_application.index')->with('error', 'Failed to create leave application');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaveApplication = LeaveApplication::find($id);
        $users = User::get();
        return view('leave_application.edit', [
            'leaveApplication' => $leaveApplication,
            'users' => $users
        ]);
    }

    /**
     * Show the detail specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leaveApplication = LeaveApplication::find($id);
        return view('leave_application.detail', [
            'leaveApplication' => $leaveApplication
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
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required',
        ]);

        $payload = $request->only('user_id', 'start_date', 'end_date', 'reason', 'status');

        $leaveApplication = LeaveApplication::find($id);
        $leaveApplication->update($payload);

        return redirect()->route('leave_application.index')->with('success', 'Leave application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leaveApplication = LeaveApplication::find($id);
        $leaveApplication->delete();

        return redirect()->route('leave_application.index')->with('success', 'Leave application deleted successfully');
    }

    public function approve(Request $request,$id)
    {
        $status = $this->setStatus('approve', $id, $request->reason);
        if ($status == '') {
            return redirect()->route('leave_application.index')->with('error', 'You are not authorized to perform this action');
        }


        return redirect()->route('leave_application.index')->with('success', 'Leave application status updated successfully');
    }

    public function reject(Request $request,$id)
    {
        $leaveApplication = LeaveApplication::find($id);
        $status = $this->setStatus('reject', $id, $request->reason);
        if ($status['status'] == true) {
            return redirect()->route('leave_application.index')->with('success', 'Leave application status updated successfully');
        } else {
            return redirect()->route('leave_application.index')->with('error', 'You are not authorized to perform this action');
        }
    }

    public function setStatus($status, $id, $reason = ''){
        $user = auth()->user();
        $role = $user->role;
        $user_id = $user->id;
        $leaveApplication = LeaveApplication::find($id);
        $text = "";
        switch ($role) {
            case 'officer':
                $text = "by Officer";
                if ($status == 'approve') {
                    $leaveApplication->is_approve_officer = 1;
                    $leaveApplication->officer_id = $user_id;
                    $leaveApplication->officer_reason = $reason;
                } else {
                    $leaveApplication->is_approve_officer = 2;
                    $leaveApplication->officer_id = $user_id;
                    $leaveApplication->officer_reason = $reason;
                }
                break;
            case 'hr': 
                #code 
                $text = "by HR Manager";
                if ($status == 'approve') {
                    $leaveApplication->is_approve_hr = 1;
                    $leaveApplication->hr_id = $user_id;
                    $leaveApplication->hr_reason = $reason;
                } else {
                    $leaveApplication->is_approve_hr = 2;
                    $leaveApplication->hr_id = $user_id;
                    $leaveApplication->hr_reason = $reason;
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
                    $leaveApplication->is_approve_finance = 1;
                    $leaveApplication->reason = $reason;
                } else {
                    $leaveApplication->is_approve_finance = 2;
                    $leaveApplication->reason = $reason;
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
            $leaveApplication->status = $text;
            $leaveApplication->save();
            return [
                'status' => true,
                'text' => $text
            ];
    }

    public function excel(Request $request)
    {
        $search = $request->search ?? '';
        if (auth()->user()->role == 'employee') {
            $leaveApplications = LeaveApplication::when($search, function ($query, $search) {
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
            $leaveApplications = LeaveApplication::when($search, function ($query, $search) {
                return $query->where('status', 'like', "%$search%")
                ->orWhere('start_date', 'like', "%$search%")
                ->orWhere('end_date', 'like', "%$search%")
                ->orWhere('reason', 'like', "%$search%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })->with('user')->get();
        }
        return Excel::download(new LeaveApplicationExport($leaveApplications), 'leave-applications.xlsx');
    }
}
