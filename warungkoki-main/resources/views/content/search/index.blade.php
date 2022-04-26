<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <title>IOLOSMART Mobile System</title>
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

    <link rel="manifest" href="/manifest.json">
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
    
    .swal-overlay {
      background-color: rgba(1, 73, 127, 0.7);
    }

    #customers {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #003168;
      color: white;
    }

  </style>
</head>
<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      {{ csrf_field() }}
      
      @if(Auth::user() != null)
        <input type="hidden" class="form-control" id="role" value="{{ Auth::user()->role_id }}">
      @else
        <input type="hidden" class="form-control" id="role" value="0">
      @endif

      <table width="100%" border="0">
        <tr>
          <td width="10%"><a href="/home" class="menusxx"><i style="font-size: 20px; color: #8a5d3b;" class="fa fa-arrow-circle-left"></i></a></td>
          <td style="font-size: 18px;"><b>Pencarian</b></td>
        </tr>
      </table>
      <div class="loading" style="display: none;">Loading&#8230;</div>
    </div>
  </nav>

  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-4 pt-md-8">
          <!-- Card stats -->
          
          <div class="row">
            <div class="col-10">
              <input type="search" id="cari" class="form-control form-control-rounded form-control-alternative" placeholder="Cari Produk" value="{{ $val }}" aria-label="Search">
            </div>
            <div class="col-2" style="padding-left: 0px;">
              <button onclick="Cari();" id="myBtn" class="btn btn-info btn-block menusxx" style="padding-right: 1rem;padding-left: 1rem;">
                <i class="fa fa-search"></i>
              </button>
            </div>
           </div>

          <hr>

          <div class="row">
              <div class="col-12">
                <div style="font-size: 14px;">
                  Hasil Pencarian Produk : <b>{{ $val }}</b>
                </div>
              </div>
              @php $no=0; @endphp
              @foreach($products as $produk)
              @php
                $no++;

                if($no%2==0){
                  $paddings = 'padding-left: 7.5px;';
                } else {
                  $paddings = 'padding-right: 7.5px;';
                }

                $post = DB::table('posts')
                ->select("posts.*","product.name as prod_name","wilayah.name as wilayah_name","regencies.name as regency_name","product.img as prod_img","wilayah.uuid")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where([
                    ["wilayah.id", $wilayahid],
                    ["posts.active", "Y"],
                    ['wilayah.active', '=', "Y"],
                    ['posts.type', '=', 'Products'],
                    ['posts.deleted_at', '=', null],
                    ['posts.product_id', '=', $produk->product_id],
                ])
                ->first();

              @endphp

              <div class="col-6" style="{{ $paddings }}">
                <a href="/users/detail/{{ $post->id }}" class="post">
                <div class="card shadow-sm">
                  
                  <div class="gambar">
                    <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap">
                    @php
                    $ada = DB::table('favorite')
                    ->where([
                        ['post_id', '=', $post->id],
                        ['user_id', '=', $iduser],
                    ])
                    ->first();

                    @endphp

                    @if(!$ada)
                    <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                    @else
                    <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #f5365c"></i></div>
                    @endif
                  </div>
                  <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <h5> <b>{{ $post->prod_name }}</b></h5>
                    <a href="/company/profile?id={{ $post->uuid }}">
                      <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $post->wilayah_name }}</span>
                    </a><br>
                    <div style="font-size: 8px;padding-top: 12px;">
                      Barang ini tersedia di daerah <b>{{ $post->regency_name }}</b>
                    </div>
                    <div style="padding-top: 8px;">
                      @if($post->deliver == 'yes')
                      <span class="badge badge-pill badge-warning" style="font-size: 8px;"><i class="fa fa-truck"></i> Delivery</span>
                      @endif

                      @if($post->po == 'yes')
                      <span class="badge badge-pill badge-info" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
                      @endif
                    </div>
                    <hr>
                    @if($post->type == 'Deals')
                    <h6 style="text-decoration:line-through;">{{ rupiah($post->harga_crt) }}</h6>
                    @endif
                    <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act) }}</b></h3>
                  </div>
                </div>
                </a>
              </div> 
              @endforeach 
              </div>
          </div>

        </div>
      </div>    
    </div>

 <!-- Footer -->
</div>
</div>



<!--   Core   -->
<script src="/assets/content/js/plugins/jquery/dist/jquery.min.js"></script>
<script src="/assets/content/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--   Argon JS   -->
<script src="/js/app.js"></script>
<script src="/assets/content/js/argon-dashboard.min.js?v=1.1.0"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script src="/js/app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-messaging.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.2.3/firebase-analytics.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}">
</script>
  

<script>
  window.TrackJS &&
    TrackJS.install({
      token: "ee6fab19c5a04ac1a32a645abde4613a",
      application: "argon-dashboard-free"
    });
</script>

<script type="text/javascript">
  function angka(e) {
    if (!/^[0-9]+$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
    }
  }
</script>

<script type="text/javascript">

  $('.menusxx').on('click', function () {

    $('.loading').attr('style','display: block');

  });

  var input = document.getElementById("cari");

  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     event.preventDefault();
     document.getElementById("myBtn").click();
    }
  });

  function Cari(){

    var cari = $('#cari').val();

    setTimeout(function(){ window.location.href='/cari?value='+cari+''; }, 1000);
  }
  
</script>

<script type="text/javascript">

  var config = {
    apiKey: "AIzaSyBXPLEpZkP6lH8gPpBWYa2Z835ZHiUZS8w",
    authDomain: "iolosmart.firebaseapp.com",
    databaseURL: "https://iolosmart.firebaseio.com",
    projectId: "iolosmart",
    storageBucket: "iolosmart.appspot.com",
    messagingSenderId: "952156759200",
    appId: "1:952156759200:web:34521ba5714245f59895c5",
    measurementId: "G-N6XT2RHV8D"
  };

  firebase.initializeApp(config);

  const messaging = firebase.messaging();
  messaging.requestPermission()
  .then(function() {
    console.log('Have Permission');
    return messaging.getToken();
  })
  .then(function(token){
    console.log(token);

    if (role != '0'){

      $.ajax({
        type: 'POST',
        url: "{{ route('TokenFCM') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'fcmtoken': token
        },

        success: function (data) {

        }

      });

    }


  })
  .catch(function(err){
    console.log('Error Ocured');
  })

  messaging.onMessage(function(payload){
    console.log('onMessage: ', payload);

  });

</script>

</body>
</html>