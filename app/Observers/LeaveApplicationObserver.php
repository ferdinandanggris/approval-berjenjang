<?php

namespace App\Observers;

use App\Helpers\ApprovalMailHelper;
use App\Helpers\ReplyApprovalMailHelper;
use App\Models\LeaveApplication;

class LeaveApplicationObserver
{
    /**
     * Handle the LeaveApplication "created" event.
     *
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return void
     */
    public function created(LeaveApplication $leaveApplication)
    {
        //kirim email ke approval
        $approvalHelper = new ApprovalMailHelper('leave_application', $leaveApplication->id);
        $approvalHelper->sendEmail();
    }

    /**
     * Handle the LeaveApplication "updated" event.
     *
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return void
     */
    public function updated(LeaveApplication $leaveApplication)
    {
        //cek apakah yang berubah is_approve_hr && is_approve_officer
        $attributChange = $leaveApplication->getChanges();
        $keyChange = array_keys($attributChange);
        if (in_array("is_approve_hr", $keyChange) || in_array("is_approve_officer", $keyChange)) {
            //kirim email ke approval
            $approvalHelper = new ApprovalMailHelper('leave_application', $leaveApplication->id);
            $approvalHelper->sendEmail();
            if (in_array("is_approve_hr", $keyChange) && $leaveApplication->is_approve_hr == 1) {
                //kirim email ke user
                $replyApproval = new ReplyApprovalMailHelper('leave_application', $leaveApplication->id, $leaveApplication->hr, 'approve');
                $replyApproval->sendEmail();
            }else if(in_array("is_approve_hr", $keyChange) && $leaveApplication->is_approve_hr == 2){
                $replyApproval = new ReplyApprovalMailHelper('leave_application', $leaveApplication->id, $leaveApplication->hr, 'decline');
                $replyApproval->sendEmail();
            }

            if (in_array("is_approve_officer", $keyChange) && $leaveApplication->is_approve_officer == 1) {
                // kirim email ke user
                $replyApproval = new ReplyApprovalMailHelper('leave_application', $leaveApplication->id, $leaveApplication->officer, 'approve');
                $replyApproval->sendEmail();    
            }else if(in_array("is_approve_officer", $keyChange) && $leaveApplication->is_approve_officer == 2){
                $replyApproval = new ReplyApprovalMailHelper('leave_application', $leaveApplication->id, $leaveApplication->officer, 'decline');
                $replyApproval->sendEmail();
            }
        }
    }

    /**
     * Handle the LeaveApplication "deleted" event.
     *
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return void
     */
    public function deleted(LeaveApplication $leaveApplication)
    {
        //
    }

    /**
     * Handle the LeaveApplication "restored" event.
     *
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return void
     */
    public function restored(LeaveApplication $leaveApplication)
    {
        //
    }

    /**
     * Handle the LeaveApplication "force deleted" event.
     *
     * @param  \App\Models\LeaveApplication  $leaveApplication
     * @return void
     */
    public function forceDeleted(LeaveApplication $leaveApplication)
    {
        //
    }
}
