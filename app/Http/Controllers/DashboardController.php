<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\TravelAuthorization;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'employee') {
            $leaveApplications = LeaveApplication::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
            $travelAuthorizations = TravelAuthorization::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }else{
            $leaveApplications = LeaveApplication::with('user')->limit(3)->orderBy('created_at', 'desc')->get();
            $travelAuthorizations = TravelAuthorization::with('user')->limit(3)->orderBy('created_at', 'desc')->get();
        }
        return view('dashboard.index', [
            'leaveApplications' => $leaveApplications,
            'travelAuthorizations' => $travelAuthorizations
        ]);
    }
}
