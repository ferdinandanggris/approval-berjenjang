<?php
  namespace App\Helpers;

use App\Mail\ApprovalRequiredMail;
use App\Models\LeaveApplication;
use App\Models\TravelAuthorization;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

  class ApprovalMailHelper{
    private $data;
    private $userModel;
    public function __construct($kategori_pengajuan, $id)
    {
      $this->setData($kategori_pengajuan, $id);
      $this->userModel = new User();
    }

    public function setData($kategori_pengajuan, $id){
      switch ($kategori_pengajuan) {
        case 'leave_application':
          $data = LeaveApplication::with(['user'])->where('id', $id)->first();
          $data = $this->setPenerimaEmail($data);
          $data->kategori_pengajuan = "Leave Application";
          $data->url = config('app.url') . "/leave_application/$id/show";
          $this->formatData($data);
          break;
        case 'travel_authorization':
          $data = TravelAuthorization::with('user')->where('id', $id)->first();
          $data = $this->setPenerimaEmail($data);
          $data->kategori_pengajuan = "Travel Authorization";
          $data->url = config('app.url') . "/travel_authorization/$id/show";
          $this->formatData($data);
          break;
      }
    }

    public function setPenerimaEmail($data){
      if($data->is_approve_hr == 1 && $data->is_approve_officer == 1 && $data->is_approve_finance == 0){
        $data->email_penerima_arr = User::where('role', 'finance')->get();
        $data->role_penerima = "Finance";
      }else if ($data->is_approve_officer == 1 && $data->is_approve_hr == 0) {
        $data->email_penerima_arr = User::where('role', 'hr')->get();
        $data->role_penerima = "HR";
      }else if($data->is_approve_officer == 0){
        $data->email_penerima_arr = User::where('role', 'officer')->get();
        $data->role_penerima = "Officer";
      }else{
        $data->email_penerima_arr = [];
        $data->role_penerima = "test";
      }
      return $data;
    }

    public function formatData($data){
      $dataFormat = [
        "nama" => $data['user']['name'],
        "role" => $data['user']['role'],
        "kategori_pengajuan" => $data['kategori_pengajuan'],
        "tanggal_mulai" => $data['start_date'],
        "tanggal_selesai" => $data['end_date'],
        "alasan" => $data['reason'],
        "link_persetujuan" => $data['url'],
        "email" => $data['user']['email'],
        "email_penerima_arr" => $data['email_penerima_arr'],
        "role_penerima" => $data['role_penerima']
      ];
      $this->data = $dataFormat;
    }

    public function sendEmail(){
      foreach ($this->data['email_penerima_arr'] as $key => $email_penerima) {
        Mail::to($email_penerima)->send(new ApprovalRequiredMail($this->data));
      }
    }
  }