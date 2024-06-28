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
  <p style="margin-bottom: 1rem"><b>Yth. Bapak/Ibu {{$data['name']}}</b></p>

  <p style="margin-bottom: .6rem">{!!$body!!}</p>
  <a href="{{$data['url_link']}}" class="btn" target="_blank" rel="noopener noreferrer">Lihat Detail</a>
  <p style="margin-top: .3rem"> Demikian pesan yang kami dapat sampaikan.</p>
  <p> Terimakasih</p>

    <p style="margin-top: 2rem"><b>Sistem Informasi Manajemen</b></p>
@endsection