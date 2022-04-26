<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <meta name="google-site-verification" content="QQlFHuHFdZ-Lo_AjAaYiJCElYinurhfwQiBVsEG5Xjc" />
  <title>Tom Xperience Mobile System</title>
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
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <!-- ios support -->
  <link rel="apple-touch-icon" href="/assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
<div class="loading" style="display: none;">Loading&#8230;</div>
  <style type="text/css" media="screen">

    .photosx{
        border-radius: 1.2rem;
        width: 100%;
        background-size: auto;
        opacity: 0.9;

    }

    .container-photo {
      position: relative;
      text-align: center;
      color: white;
    }

    .bottom-left {

      position: absolute;
      bottom: 30px;
      left: 16px;
      font-size: 24px;
      font-weight: bold;
      text-align: left;
      color: white;
    }

  </style>
</head>
<body class="">
  
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-babantos pt-5 pt-md-8" style="padding-bottom: 9rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="javascript: window.history.go(-1)"><button type="button" id="back" class='btn btn-sm btn-success'>Kembali</button></a> -->
        </div>
      </div>
    </div>
    <div class="container-fluid" style="margin-top: -10.5rem;">
      <div class="row">
        <div class="col-12" style="padding-bottom: 25px;">
          <table width="100%">
            <tr>
              <td align="center">
                <a class="menusxx" href="/promo?wilayah={{ $loc }}">
                <img width="45%" src="/assets/splash/images/newtom2.png">
                </a>
              </td>
            </tr>
          </table>
        </div>
        <br>
        <div class="col-xl-4 order-xl-2 mb-xl-0" style="padding-right: 0px;padding-left: 0px;">
          <div class="card" style="border-radius: 2rem;border: 0px;">
            <div class="card-body" style="padding: 1rem; height: 100%">
              <table width="100%">
                <tr>
                  <td align="left">
                    <div style="font-size: 16px;font-weight: bold;">PROMO {{ strtoupper($category->name) }}</div>
                  </td>
                  
                </tr>
              </table>
              
              <div style="font-size: 12px;padding-top: 7px;">
                {{ $category->desc }}.
              </div>
              <br>
                @foreach($promos as $promo)
                <br>
                <div class="row">
                  <div class="col-12" style="padding-bottom: 0px;">
                    <a class="menusxx" href="/promo/detail?id={{ $promo->id }}&loc={{ $loc }}" style="color: #525f7f;">
                    <div class="card shadow-ss" style="border-radius: 1rem;">
                      <div class="gambar">
                        <img class="card-img-top" style="border-top-left-radius: calc(1rem - 1px);border-top-right-radius: calc(1rem - 1px);" width="50px" src="{{ asset ('assets/img_banners/'.$promo->banner) }}" alt="Card image cap">
                      </div>
                      <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                        <div style="font-size: 13px;font-weight: bold;padding-bottom: 9px;">
                          {{ $promo->judul }}
                        </div>
                        <div style="font-size: 11px;">
                          {{ $promo->short_desc }}
                        </div>
                        
                      </div>
                    </div>
                    </a>
                  </div>
                </div>
                @endforeach
                      
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
<script src="/assets/content/js/plugins/jquery/dist/jquery.min.js"></script>
<script src="/assets/content/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--   Argon JS   -->
<script src="/js/app.js"></script>
<script src="/assets/content/js/argon-dashboard.min.js?v=1.1.0"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
</script>

<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

  

<script>

  $('.menusxx').on('click', function () {

    $('.loading').attr('style','display: block');

  });
</script>
</body>

</html>