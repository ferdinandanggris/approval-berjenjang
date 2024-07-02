<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $approvalHelper;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($approvalHelper)
    {
        $this->approvalHelper = $approvalHelper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->approvalHelper->sendEmail();
    }
}
