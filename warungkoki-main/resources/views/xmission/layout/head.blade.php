<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <meta name="google-site-verification" content="QQlFHuHFdZ-Lo_AjAaYiJCElYinurhfwQiBVsEG5Xjc" />
  <title>TomXperience Mobile System</title>
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
      background: #1d8ee5;
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
      background-color: #1d8ee5;
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
      background: #8965e0;

    }

    #saldomenu .circlesaldo{
      position: absolute;
      
      width: 20px;
      height: 20px;
      border-radius: 50%;
      font-size: 12px;
      color: #fff;
      line-height: 19px;
      text-align: center;
      background: #8965e0;

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
      background: #33B5E5;
    }

  </style>
</head>
<body class="">
  <nav style="position: fixed;top: 0;width: 100%;z-index: 100;" class="navbar navbar-vertical navbar-expand-md navbar-light bg-gardient-purple" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      {{ csrf_field() }}
      <a class="navbar-brand pt-0" href="/promo?wilayah=all" style="color: white; font-size: 18px;">
        <img src="/assets/splash/images/newtom2.png" class="navbar-brand-img" style="max-height: 2rem;"> &nbsp;&nbsp;| X-Mission
      </a>
      @if(Auth::user() != null)
        <input type="hidden" class="form-control" id="role" value="{{ Auth::user()->role_id }}">
      @else
        <input type="hidden" class="form-control" id="role" value="0">
      @endif
      <div align="right" id="usermenu" style="display: none;">

        <button class="navbar-toggler " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span style="color: white;" class="fa fa-ellipsis-v"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
          <a class="dropdown-item menusxx" href="/favorite">Favorite</a>
          <a class="dropdown-item menusxx" href="#">Alamat Anda</a>
        </div>
      </div> 
      <div class="loading" style="display: none;">Loading&#8230;</div>
    </div>
  </nav>