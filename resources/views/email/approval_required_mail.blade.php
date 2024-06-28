@extends('email.layouts.main')
@section('container')
  <style>
    .btn{
      padding: .5rem 1rem;
      border-radius: 5px;
      text-decoration: none;
      color: white;
      background: #0c125e;
      display: inline-block;
      margin-top: .3rem;
    }
  </style>
  <p style="margin: 0; padding: .2rem;text-align: right">{{date("l, d F Y")}}</p>
  <p style="margin-bottom: 1rem"><b>Yth. Bapak/Ibu {{$data['role_penerima']}}</b></p>

  <p style="margin-bottom: .6rem">Terdapat pengajuan yang membutuhan persetujuan anda selaku <b>{{$data['role_penerima']}}</b>, berikut adalah data yang perlu disetujui :</p>

  <div style="padding: .5rem">
    <table >
      <tr>
        <td>Nama</td>
        <td>: {{$data['nama']}}</td>
      </tr>
      <tr>
        <td>Pengajuan</td>
        <td>: {{$data['kategori_pengajuan']}}</td>
      </tr>
      <tr>
        <td>Tanggal Mulai</td>
        <td>: {{date("d F Y", strtotime($data['tanggal_mulai']))}}</td>
      </tr>
      <tr>
        <td>Tanggal Selesai</td>
        <td>: {{date("d F Y", strtotime($data['tanggal_selesai']))}}</td>
      </tr>
      <tr>
        <td>Alasan</td>
        <td>: {{$data['alasan']}}</td>
      </tr>
    </table>

</div>
      <a href="{{$data['link_persetujuan']}}" class="btn">Persetujuan</a>
    <div class="">
      <a href="{{$data['link_persetujuan']}}" style="font-size: .6rem">{{$data['link_persetujuan']}}</a>
    </div>

    <p style="margin-top: .3rem"> Untuk melakukan persetujuan silakan klik tombol atau link di atas ini.</p>
    <p> Terimakasih</p>

    <p style="margin-top: 2rem"><b>Sistem Informasi Manajemen</b></p>
@endsection