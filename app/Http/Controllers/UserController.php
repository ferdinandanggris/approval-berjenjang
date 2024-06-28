<?php

namespace App\Http\Controllers;

use App\Helpers\ApprovalMailHelper;
use App\Helpers\ReplyApprovalMailHelper;
use App\Mail\ApprovalRequiredMail;
use App\Mail\ReplyEmailApproval;
use App\Models\LeaveApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = User::get();
         return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = User::ROLES;
        return view('user.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $payload = $request->only('name', 'email', 'password', 'role');
        $payload['password'] = bcrypt($payload['password']);
        User::create($payload);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = User::ROLES;
        $user = User::find($id);
        return view('user.edit', compact('user', 'roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required'
        ]);

        $payload = $request->only('name', 'email', 'role');
        $user = User::find($id);
        $user->update($payload);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function email()
    {
        $data = LeaveApplication::with(['user', 'hr', 'officer'])->first();
        $helperReplyEmail = new ReplyApprovalMailHelper('leave_application', $data->id, $data->officer, 'approve');
        $helperReplyEmail->sendEmail();
        dd('email sent');
    }
}
