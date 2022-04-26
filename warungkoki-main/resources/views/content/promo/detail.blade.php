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

    .container-home {
      text-align: center;
      color: white;
    }

    .photos{
        border-radius: 1rem;
    }

    #customers {
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 12px 8px 12px 8px;
      font-size: 12px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #1d8ee5;
      color: white;
    }

  </style>
</head>
<body class="">
  
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-detail-promo pt-4 pt-md-8" style="padding-bottom: 8rem;">
      <div class="container-fluid">
        <div class="header-body">
          
          <table width="100%">
            <tr>
              <td width="10%">
                <a href="/promo?wilayah={{ $loc }}"><i style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-chevron-left"></i></a>
              </td>
              <td align="right">
                <div>
                  <i onclick="onShare()" style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-share"></i>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" height="3%">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <img class="photos" src="/assets/img_banners/{{ $promo->banner }}" width="90%">
              </td>
            </tr>
          </table>

        </div>
      </div>
    </div>
    
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col-12" style="padding-top: 20px;">
            
        </div>
        <br>
        <div class="col-xl-4 order-xl-2 mb-xl-0" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;">
          <div class="card" style="border-radius: 2rem;border: 0px;">
            <div class="card-body" style="padding: 1rem; height: 100%">
              <div style="font-size: 13px;padding-top: 12px;">Promo :</div>
              <div style="font-size: 16px;font-weight: bold;padding-top: 5px;">{{ $promo->judul }}</div>
              <br>
              <div class="row">
                <div class="col-12" style="padding-bottom: 0px;">
                  <div style="font-size: 13px;">
                    {!! $promo->desc !!}
                  </div>
                  @if($promo->post_id != NULL)
                  <hr>
                  <a href="/users/detail/{{ $promo->post_id }}"><button class="btn btn-info btn-block"> BELI SEKARANG</button></a>
                  @endif
                </div>
              </div>

              <br>
              
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

  async function onShare() {
    const title = document.title;
    const url = document.querySelector("link[rel=canonical]")
      ? document.querySelector("link[rel=canonical]").href
      : document.location.href;
    const text = "Promo Menarik Lainnya di tomxperience.id yuk!";
    try {
        await navigator
        .share({
          title,
          url,
          text
        })
        
          /*
            Show a message if the user shares something
          */
          alert('Thanks for Sharing!');
      } catch (err) {
         /*
            This error will appear if the user cancels the action of sharing.
          */
         // alert('Couldnt share');
      }
  }
</script>
</body>

</html>