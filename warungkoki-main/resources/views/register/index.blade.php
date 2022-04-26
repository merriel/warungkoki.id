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

  <link rel="stylesheet" type="text/css" href="../assets/content/css/loading.css">
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
  <div class="loading" style="display: none;">Loading&#8230;</div>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="#">
          <img src="./assets/splash/images/iolo_logo.png" />
        </a>
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-iolo py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Registrasi Akun</h1>
              <p class="text-lead text-light">Isi Form yang Disediakan untuk membuat Akun Iolo-Smart.</p>
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
    {{ csrf_field() }}
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Pastikan Data yang Anda Masukan Benar</small>
              </div>
              <div role="form">
                <div id="valnama" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input class="form-control register" id="nama" placeholder="Nama Lengkap" type="text">
                  </div>
                </div>
                <div id="valemail" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control register" id="email" placeholder="Email" type="email">
                  </div>
                </div>
                <div id="valnohp" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                    </div>
                    <input class="form-control register" id="nohp" placeholder="No Handphone" type="email">
                  </div>
                </div>
                <div id="valpassword" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control register" id="password" placeholder="Password" type="password">
                  </div>
                </div>
                <div id="valpassword2" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control register" id="confirm-password" placeholder="Confirm Password" type="password">
                  </div>
                </div>
                <div id="valtoken" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-active-40"></i></span>
                    </div>
                    <input class="form-control register" id="token" placeholder="PIN Token (6 Karakter)" type="password">
                  </div>
                </div>

                <div id="valclubsmart" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-credit-card"></i></span>
                    </div>
                    <input class="form-control" id="clubsmart" placeholder="Nomor Kartu Clubsmart" type="text">
                  </div>
                </div>

                <div id="valprovinsi" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-building"></i></span>
                    </div>
                    <select class="form-control register select2" id="provinsi" >
                      <option value="">Pilih Provinsi</option>
                      @foreach($provinces as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div id="valkotakab" class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
                    </div>
                    <select class="form-control register" id="kotakab">
                      <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                  </div>
                </div>
                
                <div class="text-center">
                  <table width="100%">
                      <tr>
                        <td><button type="button" id="daftar" class="btn btn-iolo my-4">Daftar</button>
                        <a href="/login"><button type="button" class="btn btn-warning my-4">Back to Login</button></a></td>
                      </tr>
                  </table>

                  
                </div>
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

  @include('script.register')
</body>

</html>