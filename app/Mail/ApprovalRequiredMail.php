<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalRequiredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }

    public function setData(array $data)
    {
        $this->data = [
            "nama" => $data['nama'] ?? '',
            "role" => $data['role'] ?? '',
            "role_penerima" => $data['role_penerima'] ?? '',
            "kategori_pengajuan" => $data['kategori_pengajuan'] ?? '',
            "tanggal_mulai"  => $data['tanggal_mulai'] ?? '',
            "tanggal_selesai" => $data['tanggal_selesai'] ?? '',
            "alasan" => $data['alasan'] ?? '',
            "link_persetujuan" => $data['link_persetujuan'] ?? ''
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ferdinandanggris@gmail.com')->subject('Dibutuhkan Persetujuan')->view('email.approval_required_mail', [
            'data' => $this->data
        ]);
    }
}
