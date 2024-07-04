<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyEmailApproval extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->setData($data);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->data['status'] == "approve") {
            return $this->view('email.reply_email_approval_approve',[
                'body' => $this->setMessage($this->data),
                'data' => $this->data
            ])->subject($this->setSubject("approve"));
        }else if($this->data['status'] == "decline"){
            return $this->view('email.reply_email_approval_decline',[
                'body' => $this->setMessage($this->data),
                'data' => $this->data
            ]);
        }
    }

    public function setData($data)
    {
        $this->data = [
            "name" => $data['name'] ?? '',
            "role" => $data['role'] ?? '',
            "role_penyetuju" => $data['role_penyetuju'] ?? '',
            "penyetuju" => $data['penyetuju'] ?? '',
            "kategori_pengajuan" => $data['kategori_pengajuan'] ?? '',
            "status_approval" => $data['status_approval'] ?? '',
            "tanggal_mulai" => $data['tanggal_mulai'] ?? '',
            "tanggal_selesai" => $data['tanggal_selesai'] ?? '',
            "status"    => $data['status'] ?? '',
            "url_link" => $data['url_link'] ?? '',
            "catatan" => $data['catatan'] ?? ''
        ];
    }

    public function setMessage($data)
    {
        $body = "Terkait pengajuan " . " " . $data['kategori_pengajuan'] . " " . " anda pada tanggal " . date("d F Y", strtotime($data['tanggal_mulai'])) . " " . "sampai dengan tanggal " . date("d F Y", strtotime($data['tanggal_selesai']));

        switch($data['status']){
            case "approve":
                $body .= " telah <b>disetujui</b> oleh " . $data['penyetuju'] . " selaku <b>" . $data['role_penyetuju'] . "</b>";
                break;
            case "decline":
                $body .= " telah <b>ditolak</b> oleh ". $data['penyetuju'] . " selaku <b>" . $data['role_penyetuju'] . "</b>";
                break;
            default:
                $body .= " telah disetujui oleh ". $data['penyetuju'] . " selaku <b>" . $data['role_penyetuju'] . "</b>";
                break;
        }

        // Check if catatan is not empty
        if ($data['catatan'] != "-" || $data['catatan'] != "" || $data['catatan'] != null) {
            $body .= " dengan catatan : <b>" . $data['catatan'] . "</b>";
        }
        return $body;
    }

    public function setSubject($status)
    {
        switch($status){
            case "approve":
                $subject = "Pengajuan Anda disetujui";
                break;
            case "decline":
                $subject = "Pengajuan Anda ditolak";
                break;
            default:
                $subject = "Pengajuan Anda disetujui";
                break;
        }
    }
}
