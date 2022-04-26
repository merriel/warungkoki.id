<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <meta name="google-site-verification" content="QQlFHuHFdZ-Lo_AjAaYiJCElYinurhfwQiBVsEG5Xjc" />
  <title>Warung Koki Mobile System</title>
  <!-- Favicon -->
  <link href="/assets/icon/72x72.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icons -->
  <link href="/assets/content/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="/assets/content/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="/assets/content/css/loading.css">
  <!-- CSS Files -->
  <link href="/assets/content/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <link href="{{ asset ('assets/content/css/nav-footer.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

  <link rel="manifest" href="/manifest.json">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <!-- ios support -->
  <link rel="apple-touch-icon" href="/assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">

  <style type="text/css" media="screen">
    .drawingBuffer {
      position: absolute;
      top: 0;
      left: 0;
    }

    .swal-text {    
      text-align: center;
    }

    .swal-footer {
      text-align: center;
    }
    
    .swal-overlay {
      background-color: rgba(1, 73, 127, 0.7);
    }

    #footer {
      bottom: 0;
      width: 100%;
      height: 2.5rem;
    }

    .notif {
      position: absolute;
      top: 30%;
      left: 69%;
      width: 16%;
    }

    .notif2 {
      position: absolute;
      top: 30%;
      left: 56%;
      width: 16%;
    }

    .notif3 {
      position: absolute;
      top: 30%;
      left: 41%;
      width: 16%;
    }

    .notif .circle1 {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 18px;
      text-align: center;
      background: #ffcb45
    }

    .notif2 .circle2 {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 17px;
      text-align: center;
      background: #ffcb45
    }

    .notif3 .circle3 {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 17px;
      text-align: center;
      background: #ffcb45
    }

    .love {
      position: absolute;
      top: 26%;
      left: 77%;
      width: 16%;
    }

    .love2 {
      position: absolute;
      top: 32%;
      left: 74%;
      width: 16%;
    }

    .type {
      position: absolute;
      top: 2%;
      left: 2%;
      width: 16%;
    }

    .circle3 {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      font-size: 16px;
      color: #000;
      line-height: 48px;
      text-align: center;
      background: #1d8ee5;
    }

    .love2 .circle4 {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      font-size: 16px;
      color: #000;
      line-height: 40px;
      text-align: center;
      background: #feac3b;
    }

    #customers {
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers th {
      padding-top: 8px;
      padding-bottom: 8px;
      text-align: left;
      background-color: #feac3b;
      color: white;
    }

    #reedemmenu .circlereedem{
      position: absolute;
      
      width: 20px;
      height: 20px;
      /*width: 16%;*/
      border-radius: 50%;
      font-size: 12px;
      color: #fff;
      line-height: 19px;
      text-align: center;
      background: #1d8ee5;

    }

    #keranjangmenu .circlekeranjang{
      position: absolute;
      
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      color: #fff;
      line-height: 19px;
      text-align: center;
      background: #f5365c;

    }

    #pesanmenu .circlepesan{
      position: absolute;
      
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      color: #fff;
      line-height: 19px;
      text-align: center;
      background: #f5365c;

    }

    #transaksimenu .circletransaksi{
      position: absolute;
      
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      color: #fff;
      line-height: 19px;
      text-align: center;
      background: #feac3b;

    }

    .navbar-toggler .circlenotif{
      position: absolute;
      
      width: 20px;
      height: 20px;
      /*width: 16%;*/
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 19px;
      text-align: center;
      background: #ffcb45

    }
    .navbar-toggler .circledeliver{
      position: absolute;
      
      width: 20px;
      height: 20px;
      /*width: 16%;*/
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 19px;
      text-align: center;
      background: #ffcb45

    }
    .navbar-toggler .circleprinciplepesan{
      position: absolute;
      
      width: 20px;
      height: 20px;
      /*width: 16%;*/
      border-radius: 50%;
      font-size: 12px;
      color: #000;
      line-height: 19px;
      text-align: center;
      background: #ffcb45

    }

    .gambar .circle3 {
      position: absolute;

      right: 7%;
      top: 30%;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      font-size: 25px;
      color: #000;
      line-height: 70px;
      text-align: center;
      background: #33B5E5
    }

    .gambar .circle4 {
      position: absolute;

      right: 7%;
      top: 36%;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      font-size: 16px;
      color: #000;
      line-height: 40px;
      text-align: center;
      background: #feac3b;
    }

    .nav9 {
      position: fixed;
      bottom: 0;
      left: 0px;
      background-color: #BAF713;
      display: flex;
      overflow-x: auto;

      margin-bottom: 70px;
      height: 10px;
      width: 100%;
    }

    .nav11 {
      position: fixed;
      bottom: 0;
      left: 40%;
      background-color: #feac3b;
      display: flex;
      overflow-x: auto;

      margin-bottom: 40px;
      border-radius: 3rem;
      box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
      height: 70px;
      width: 70px;
      border-color: whitesmoke;
      z-index: 100;
    }

    .nav12 {
      position: fixed;
      bottom: 0;
      left: 40%;
      display: flex;
      overflow-x: auto;
      margin-bottom: 15px;
      font-family: sans-serif;
      font-size: 13px;

      border-color: whitesmoke;
      z-index: 100;
    }

  </style>
</head>
<body class="">
  <nav style="position: fixed;top: 0;width: 100%;z-index: 100;padding: 0.5rem 0rem 0rem 0rem;" class="navbar navbar-vertical navbar-expand-md navbar-light bg-warung" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      {{ csrf_field() }}
      <table width="100%">
        <tr>
          <td align="center">
            <img src="/assets/splash/images/koki3.jpg" width="70%">
          </td>
          <td width="20%" align="center">
            
            <a href="/login" class="menusxx"><button class="btn btn-sm btn-secondary">
              Login
            </button></a>
          </td>
        </tr>
        <tr>
          <td style="font-size: 5px;">&nbsp;</td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td bgcolor="#BAF713" style="font-size: 1.5px;">
             &nbsp;
          </td>
        </tr>
        <tr>
          <td bgcolor="#15BE77" style="font-size: 1.5px;">
             &nbsp;
          </td>
        </tr>
      </table>
      
      <div align="right" id="usermenu" style="display: none;">

      </div>

      <div align="right" id="belumlogin" style="display: none;">
        <a href="/login">
          <button class="btn btn-secondary" style="font-size: 15px" type="button">
            Masuk
          </button>
        </a>
      </div>

      <div align="right" id="userpetugas" style="display: none;">
      
      @php
        $services = DB::table('services')
        ->first();

        $urgent = DB::table('inboxes')
        ->select('id')
        ->where("sampai",'>=', date('Y-m-d'))
        ->where("type", "superurgent")
        ->first();

      @endphp
      <input type="hidden" id="serv" value="{{ $services->biaya }}">
      <input type="hidden" id="urgent" value="{{ $urgent ? $urgent->id : '' }}">
    </div>
    <div class="loading" style="display: none;">Loading&#8230;</div>
  </nav>