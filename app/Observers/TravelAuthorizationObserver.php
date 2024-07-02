<?php

namespace App\Observers;

use App\Helpers\ApprovalMailHelper;
use App\Helpers\ReplyApprovalMailHelper;
use App\Jobs\sendEmailJob;
use App\Models\TravelAuthorization;

class TravelAuthorizationObserver
{
    /**
     * Handle the TravelAuthorization "created" event.
     *
     * @param  \App\Models\TravelAuthorization  $travelAuthorization
     * @return void
     */
    public function created(TravelAuthorization $travelAuthorization)
    {
        //kirim email ke approval
        $approvalHelper = new ApprovalMailHelper('travel_authorization', $travelAuthorization->id);
        //   $approvalHelper->sendEmail();
        dispatch(new sendEmailJob($approvalHelper))->onQueue('send-email');
    }

    /**
     * Handle the TravelAuthorization "updated" event.
     *
     * @param  \App\Models\TravelAuthorization  $travelAuthorization
     * @return void
     */
    public function updated(TravelAuthorization $travelAuthorization)
    {
        //cek apakah yang berubah is_approve_hr && is_approve_officer
        $attributChange = $travelAuthorization->getChanges();
        $keyChange = array_keys($attributChange);
        if (in_array("is_approve_hr", $keyChange) || in_array("is_approve_officer", $keyChange) || in_array("is_approve_finance", $keyChange)) {
            //kirim email ke approval
            $approvalHelper = new ApprovalMailHelper('travel_authorization', $travelAuthorization->id);
            //    $approvalHelper->sendEmail();
            dispatch(new sendEmailJob($approvalHelper))->onQueue('send-email');
            if (in_array("is_approve_hr", $keyChange) && $travelAuthorization->is_approve_hr == 1) {
                //kirim email ke user
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->hr, 'approve');
                //    $replyApproval->sendEmail();
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            } else if (in_array("is_approve_hr", $keyChange) && $travelAuthorization->is_approve_hr == 2) {
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->hr, 'decline');
                //    $replyApproval->sendEmail();
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            }

            if (in_array("is_approve_officer", $keyChange) && $travelAuthorization->is_approve_officer == 1) {
                // kirim email ke user
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->officer, 'approve');
                //    $replyApproval->sendEmail();    
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            } else if (in_array("is_approve_officer", $keyChange) && $travelAuthorization->is_approve_officer == 2) {
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->officer, 'decline');
                //    $replyApproval->sendEmail();
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            }

            if (in_array("is_approve_finance", $keyChange) && $travelAuthorization->is_approve_finance == 1) {
                // kirim email ke user
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->finance, 'approve');
                // $replyApproval->sendEmail();
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            } else if (in_array("is_approve_finance", $keyChange) && $travelAuthorization->is_approve_finance == 2) {
                $replyApproval = new ReplyApprovalMailHelper('travel_authorization', $travelAuthorization->id, $travelAuthorization->finance, 'decline');
                // $replyApproval->sendEmail();
                dispatch(new sendEmailJob($replyApproval))->onQueue('send-email');
            }
        }
    }

    /**
     * Handle the TravelAuthorization "deleted" event.
     *
     * @param  \App\Models\TravelAuthorization  $travelAuthorization
     * @return void
     */
    public function deleted(TravelAuthorization $travelAuthorization)
    {
        //
    }

    /**
     * Handle the TravelAuthorization "restored" event.
     *
     * @param  \App\Models\TravelAuthorization  $travelAuthorization
     * @return void
     */
    public function restored(TravelAuthorization $travelAuthorization)
    {
        //
    }

    /**
     * Handle the TravelAuthorization "force deleted" event.
     *
     * @param  \App\Models\TravelAuthorization  $travelAuthorization
     * @return void
     */
    public function forceDeleted(TravelAuthorization $travelAuthorization)
    {
        //
    }
}
