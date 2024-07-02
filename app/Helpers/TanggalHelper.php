<?php

use Illuminate\Support\Carbon;

  function formatTanggal($time = null,$format = 'd F Y'){
    // carbon id
    $time = $time ? $time : strtotime(date('Y-m-d'));
    $date = Carbon::createFromTimestamp($time)->locale('id');
    $date->settings(['formatFunction' => 'translatedFormat']);
    return $date->format($format);
  }