<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <title>Cube Work + | Working Space</title>
  <!-- Favicon -->
  <link href="{{ asset ('assets/icon/72x72.png') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icons -->
  <link href="{{ asset ('assets/content/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
  <link href="{{ asset ('assets/content/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />

  <link href="{{ asset ('assets/content/css/nav-footer.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="{{ asset ('assets/content/css/loading.css') }}">
  <!-- CSS Files -->
  <link href="{{ asset ('assets/content/css/argon-dashboard.css?v=1.1.0') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

  <link rel="manifest" href="../manifest.json">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <!-- ios support -->
  <link rel="apple-touch-icon" href="{{ asset ('assets/icon/96x96.png') }}">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
  <style type="text/css">
    .navbar-toggler .circlepesan{
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

    a.disabled {
      pointer-events: none;
      cursor: default;
    }
  </style>
</head>
<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-shell" id="sidenav-main">
    <div class="container-fluid" align="center">
      <!-- Toggler -->
      {{ csrf_field() }}
      <a class="navbar-brand pt-0" href="/working-space/home">
        <img src="{{ asset ('assets/content/img/theme/cowork.png') }}" class="navbar-brand-img">
      </a>
      @if(Auth::user() != null)
        <input type="hidden" class="form-control" id="role" value="{{ Auth::user()->role_id }}">
      @else
        <input type="hidden" class="form-control" id="role" value="0">
      @endif
      <div align="right" id="usermenu" style="display: none;">

        <!-- <a href="#" class="menusxx">
          <button class="navbar-toggler" type="button" >
            <div style="padding-left: 10px;">
            <span class="circlepesan"><b id="pesan">0</b></span></div>
            <span style="color: white;" class="ni ni-bell-55"></span>
            
          </button>
        </a> -->
      </div>
      <div class="loading" style="display: none;">Loading&#8230;</div>
    </div>
  </nav>