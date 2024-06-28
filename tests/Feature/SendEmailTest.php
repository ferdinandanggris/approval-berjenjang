<?php

namespace Tests\Feature;

use App\Mail\ApprovalRequiredMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_email()
    {
        $response = $this->get('/');
        Mail::to('ferdinandanggris@gmail.com')->send(new ApprovalRequiredMail());
        $response->assertStatus(302);
    }
}
