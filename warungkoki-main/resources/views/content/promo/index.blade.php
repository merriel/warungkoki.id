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
    .swiper-container {
      width: 100%;
      height: 420px;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      width: 80%;

      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }

    .swiper-slide:nth-child(2n) {
      width: 45%;
    }

    .container-home {
      text-align: center;
      color: white;
    }

    .photos{
      height: 340px;
    }

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

    .bottom-left2 {

      position: absolute;
      bottom: 5px;
      left: 30px;
      font-size: 19px;
      font-weight: bold;
      text-align: left;
      color: white;
    }

    .nav{

      margin-bottom: 30px;
      border-radius: 3rem;
      box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
      height: 95px;
      margin-left: 5%;
      width: 90%;

    }

    .nav__link{

      padding-top: 12px;
      padding-bottom: 12px;

    }

    .content .close {
      position: absolute;
      top: -2%;
      right: -2%;
      transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      background-color: #555;
      color: white;
      padding: 5px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      z-index: 10;

    }

  </style>
</head>
<body class="">
  
<div class="main-content">
  <!-- Header -->
  <div class="header bg-gradient-babantos pt-2 pt-md-8" style="padding-bottom: 9rem;">
    <div class="container-fluid">
      <div class="header-body">
        <!-- Card stats -->
        <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
      </div>
    </div>
  </div>
  <br>
  <div class="container-fluid" style="margin-top: -9rem;">      
    <div class="row">
      <div class="col-12" style="padding-bottom: 25px;">
        <table width="100%">
          <tr>
            <td align="center">
              <a class="menusxx" href="#">
                <img width="45%" src="/assets/splash/images/newtom2.png">
              </a>
            </td>
          </tr>
        </table>
      </div>
      <br>
      <div class="col-xl-4 order-xl-2 mb-xl-0" style="padding-right: 0px;padding-left: 0px;">
        <div class="card" style="border-radius: 2rem;border: 0px;">
          <div class="card-body" style="padding: 0px 1rem 1rem 1rem; height: 100%">
            <br>
            <div style="padding-bottom: 12px;">Lokasi anda saat ini : </div>
            <select class="form-control" id="wilayah">
              <option value="all" {{ $loc == 'all' ? 'selected' : '' }}>All</option>
              @foreach($wilayahs as $wil)
                <option value="{{ $wil->id }}" {{ $loc == $wil->id ? 'selected' : '' }}>{{ $wil->name }}</option>
              @endforeach
            </select>
            <hr>
            <table width="100%">
              <tr>
                <td align="left">
                  <div style="font-size: 16px;font-weight: bold;">HOT PROMO</div>
                  <input type="hidden" id="location" value="{{ $loc }}">
                </td>
              </tr>
            </table>
            <div style="font-size: 12px;padding-top: 7px;">
              Berikut adalah HOT PROMO dari kami, dapatkan berbagai keuntungan dan kebaikan dalam setiap transaksi nya.
            </div>
            
            <div class="row">
              <div class="swiper-container" id="ka-swiper1">
                <div class="swiper-wrapper">

                  @foreach($promos as $promo)
                  <div class="swiper-slide">
                    <a class="menusxx" href="/promo/detail?id={{ $promo->id }}&loc={{ $loc }}">
                      <div class="container-home">
                        <div class="card shadow"> 
                          <img class="photos" src="/assets/img_promo/{{ $promo->img }}" height="260">
                        </div>
                      </div>
                    </a>
                    <!-- <hr> -->
                    <!-- @if($promo->post_id != NULL)
                    <a href="/users/detail/{{ $promo->post_id }}"><button class="btn btn-block btn-info">Beli Sekarang</button></a>
                    @else
                    <a href="/promo/detail?id={{ $promo->id }}"><button class="btn btn-block btn-info">Lihat Promo</button></a>
                    @endif -->
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            @foreach($categories as $cat)
            
            <!-- <div class="card shadow-sm" style="border-radius: 1.2rem;">
              <div class="card-body" style="padding: 0;">
                <div class="container-photo">
                  <img class="photosx" src="{{ asset ('assets/content/img/theme/'.$cat->img) }}"> 
                  <div class="bottom-left">
                    {{ $cat->name }}
                    <div style="font-size: 11px;padding-right: 10px;">
                      {{ $cat->desc }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <br> -->

            
            <table width="100%">
              <tr>
                <td>
                  <div style="font-size: 16px;font-weight: bold;padding-top: 12px;">
                    {{ strtoupper($cat->name) }} PROMO
                  </div>
                </td>
                
              </tr>
            </table>
            <br>
            <div class="row">
              <div class="col-12" style="padding-bottom: 0px;">
                <a class="menusxx" href="/promo/category?id={{ $cat->id }}&loc={{ $loc }}" style="color: #525f7f;">
                <div class="card shadow-ss" style="border-radius: 1rem;">
                  <div class="gambar">
                    <img class="card-img-top" style="border-top-left-radius: calc(1rem - 1px);border-top-right-radius: calc(1rem - 1px);" width="50px" src="{{ asset ('assets/content/img/theme/'.$cat->img) }}" alt="Card image cap">
                  </div>
                  <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <div style="font-size: 13px;font-weight: bold;padding-bottom: 9px;">
                      {{ $cat->short_desc }}
                    </div>
                    <div style="font-size: 11px;">
                      {{ $cat->desc }}
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
@if($iklans->count() != 0)
@include('content.promo.modal')
@endif
<div class="nav" style="z-index: 999;">
  <div class="nav__link menusxx">
    <a href="/home"><button class="btn btn-info" style="border-radius: 2rem; padding: 0.7rem;margin-right: 0px;">
      <i class="fa fa-shopping-basket" style="font-size: 18px;color: #fff;"></i>
    </button></a>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>X-Shop</b></div>
    </span>
  </div>

  <div class="nav__link menusxx">
    <a href="#"><button class="btn btn-success" style="border-radius: 2rem; padding: 0.7rem;margin-right: 0px;">
      <i class="fa fa-truck" style="font-size: 18px;color: #fff;"></i>
    </button></a>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>X-Deliver</b></div>
    </span>
  </div>

  <div class="nav__link menusxx">
    <a href="#"><button class="btn btn-warning" onclick="ComingSoon()" style="border-radius: 2rem; padding: 0.7rem;margin-right: 0px;">
      <i class="fa fa-laptop" style="font-size: 18px;color: #fff;"></i>
    </button></a>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>X-Cube</b></div>
    </span>
  </div>
  
  <div class="nav__link menusxx">
   <a href="/xmission"><button class="btn btn-ungu" style="border-radius: 2rem; padding: 0.7rem;margin-right: 0px;">
      <i class="fa fa-rocket" style="font-size: 18px;color: #fff;"></i>
    </button></a>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>X-Mission</b></div>
    </span>
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

<script type="text/javascript">
  
$('#wilayah').on('change', function () {

  var wil = $(this).val();

  setTimeout(function(){ window.location.href = '/promo?wilayah='+wil; }, 400);
});

</script>

<script>
  window.TrackJS &&
    TrackJS.install({
      token: "ee6fab19c5a04ac1a32a645abde4613a",
      application: "argon-dashboard-free"
    });

  // var kaSwiper1 = new Swiper ('#ka-swiper1', {
  //   // loop: true,
  //   pagination: '.swiper-pagination',
  //   paginationClickable: true,
  //   centeredSlides: false,
  //   slidesPerView: 2,
  //   spaceBetween : 30,
  //   autoHeight: true,
  //   breakpoints :{
  //     768:{
  //       spaceBetweenSlides: 10
  //     }
  //   }
  // });

  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });

  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('promo.iklan') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'loc': $('#location').val()
      },
      success: function (data) {

        if(data != '0'){

          $('#gambar').attr('src','/assets/img_iklan/'+data.img);

           $('#iklan').modal('show'); 

        } 
      }
    });

  });

  function ComingSoon(){

    $('#comingsoon').modal('show'); 

  }

  $('.menusxx').on('click', function () {
      
      $('.loading').attr('style','display: block');

      setTimeout(function(){ $('.loading').attr('style','display: none'); }, 950);

    });

</script>
</body>

</html>