<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    IOLOSMART - Deals and Challange
  </title>
  <!-- Favicon -->
  <link href="../assets/content/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="../assets/content/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="../assets/content/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/content/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <link rel="manifest" href="./manifest.json">
  <!-- ios support -->
  <link rel="apple-touch-icon" href="./assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">

</head>
<style type="text/css" media="screen">
    .swal-text {    
      text-align: center;
    }
    
    .swal-overlay {
      background-color: rgba(1, 73, 127, 0.7);
    }

</style>

<body class="bg-kuning">
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="#">
          <img src="/assets/splash/images/iolo_logo.png" />
        </a>
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-iolo py-6 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Selamat Datang!</h1>
              <p class="text-lead text-light">Ada banyak bermacam Deals and Challange pasti Lebih murah dan banyak untungnya.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    @csrf
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-6">
              <div class="text-muted text-center mt-2 mb-5"><small>Pilih Untuk Masuk ke dalam Aplikasi</small></div>
              
              <div class="btn-wrapper text-center">
                <a href="/loginiolo" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="/assets/icon/512x512.png"></span>
                  <span class="btn-inner--text">iolosmart</span>
                </a>

                <a href="{{ url('auth/google') }}?page=1" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="/assets/content/img/icons/common/google.svg"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>

  </div>
  <!--   Core   -->
  <script src="../assets/content/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="../assets/content/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="./js/app.js"></script>
  <script src="../assets/content/js/argon-dashboard.min.js?v=1.1.0"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });

  </script>

  <!-- @include('script.login') -->
</body>

</html>