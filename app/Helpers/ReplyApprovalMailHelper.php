<?php

namespace App\Helpers;

use App\Mail\ReplyEmailApproval;
use App\Models\LeaveApplication;
use App\Models\TravelAuthorization;
use Illuminate\Support\Facades\Mail;

class ReplyApprovalMailHelper{
  private $data,$penyetuju, $status;
  public function __construct($kategori_pengajuan, $id, $penyetuju, $status)
  {
    $this->penyetuju = $penyetuju;
    $this->status = $status;
    $this->setData($kategori_pengajuan, $id);
  }

  public function setData($kategori_pengajuan, $id){
    switch ($kategori_pengajuan) {
      case 'leave_application':
        $data = LeaveApplication::with(['user'])->where('id', $id)->first();
        $data->kategori_pengajuan = "Leave Application";
        $data->url = config('app.url') . "/leave_application/$id/show";
        $this->formatData($data);
        break;
      case 'travel_authorization':
        $data = TravelAuthorization::with('user')->where('id', $id)->first();
        $data->kategori_pengajuan = "Travel Authorization";
        $data->url = config('app.url') . "/travel_authorization/$id/show";
        $this->formatData($data);
        break;
    }
  }

  public function formatData($data){
    $data = [
        "name" => $data['user']['name'],
        "role" => $data['user']['role'],
        "email" => $data['user']['email'],  
        'penyetuju' => $this->penyetuju['name'],
        "role_penyetuju" => $this->penyetuju['role'],
        "kategori_pengajuan" => $data['kategori_pengajuan'],
        "tanggal_mulai" => $data['start_date'],
        "tanggal_selesai" => $data['end_date'],
        "status_approval" => $this->status,
        "status" => $this->status,
        "url_link" => $data['url']
    ];
    $this->data = $data;
  }

  public function sendEmail(){
    Mail::to($this->data['email'])->send(new ReplyEmailApproval($this->data));
  }
}