<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
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
          <td width="10%"><a href="/home" class="menusxx"><i style="font-size: 20px;" class="fa fa-arrow-circle-left"></i></a></td>
          <td style="font-size: 18px;"><b>PILIH TOKO</b></td>
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
            <div class="col">
              <input type="search" id="search" class="form-control form-control-rounded form-control-alternative" placeholder="Search" aria-label="Search">
              <hr>
              <div class="accordion" id="accordionExample" style="border-radius: 1rem;">

                @foreach($provinces as $prov)
                <div class="card shadow-sm">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{ $prov->id }}" aria-expanded="true" aria-controls="collapseOne" style="padding-left:0px;padding-bottom:0px;">
                        <b>{{ $prov->name }}</b>
                      </button>
                      <div style="font-size:11px;padding-bottom: 12px;"><i>Toko Warungkoki di Wilayah {{ $prov->name }}</b></i></div>
                    </h2>
                  </div>

                  <div id="collapse_{{ $prov->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body" style="padding: 0.8rem;">
                      <div class="col-12 dets" style="padding-bottom:0px;" id="detailnya_2">
                        <div class="row">

                          @php

                          $wilayahs = DB::table('wilayah')
                          ->select("wilayah.*","company.photo","regencies.name as regency_name")
                          ->join("company", "wilayah.company_id", "=", "company.id")
                          ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
                          ->join("provinces", "regencies.province_id", "=", "provinces.id")
                          ->where("active", "Y")
                          ->where("temporary", NULL)
                          ->where("provinces.id", $prov->id)
                          ->get();

                          @endphp

                          @foreach($wilayahs as $wilayah)
                            <div class="card" style="border-radius: 1rem;">
                              <div onclick="PilihToko({{ $wilayah->id }});" class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;border-radius: 1rem;">
                                <div class="row">
                                    <div class="col-3" style="padding-right: 0px;">
                                        <a href="#" class="avatar rounded-circle mr-3">
                                      <img src="/assets/icon/144x144.png">
                                    </a>
                                    </div>
                                    <div class="col-9" style="padding-bottom: 0px;padding-left: 0px;">
                                      <div class="text-warning" style="font-size: 13px;"><b>{{ $wilayah->name }}</b></div>
                                      <div style="font-size: 11px; padding-bottom: 8px;">
                                        {{ $wilayah->alamat }} - {{ $wilayah->regency_name }}
                                      </div>
                                      <span class="badge badge-success">
                                      <i class="fa fa-clock"></i>  Buka : {{ $wilayah->jam_masuk }} - {{ $wilayah->jam_tutup }}
                                    </span>
                                    </div>
                                </div> 
                              </div>
                            </div>
                            <br>
                          @endforeach

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div id="hasiltoko">
                
              </div>
              <!-- <hr> -->

              <!-- <div id="hasilproduk"></div> -->
            </div>
          </div>

        </div>
      </div>    
    </div>

 <!-- Footer -->
</div>
</div>

<!-- =======PILIH TOKO ====== -->
<div class="modal fade" id="pilihtoko" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
        
        <div class="modal-header">
            <h3 class="modal-title" id="modal-title-default">Konfirmasi Pilih Toko</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <input type="hidden" id="toko_id" >
        </div>
        <div class="modal-body" id="pilih" align="center" style="padding-bottom: 0px;">
            
        </div>
        
        
        <div align="center" style="padding-bottom: 1rem;">
            <button type="button" onclick="Pilih()" class="btn btn-iolo menusxx">Pilih Toko</button>
        </div>
        <br>
    </div>
  </div>
</div>
<!-- ======= SELESAI PILIH DAERAH ======= -->

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

  $.ajax({
    type: 'GET',
    url: "{{ route('validasikadaluarsa') }}",

    

  });
  
  var role = $('#role').val();

  if (role == '4'){
    $('#usermenu').attr("style","display: block;");

    $.ajax({
      type: 'GET',
      url: "{{ route('GetCountMessages') }}",

      success: function (data) {
        $('#messagescount').html(data);
      }

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('GetCountKeranjang') }}",

      success: function (data) {
        $('#keranjangcount').html(data);

      }

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('GetCountKeranjangReedem') }}",

      success: function (data) {
        $('#keranjangreedemcount').html(data);

      }

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('countpesanusers') }}",

      success: function (data) {
        $('#komentarcountusers').html(data);
      }

    });

  } else if(role == '0'){

    $('#belumlogin').attr("style","display: block;");

  } else if(role == '3'){

      $('#userpetugas').attr("style","display: block;");

      $.ajax({
        type: 'GET',
        url: "{{ route('countreedem') }}",

        success: function (data) {
          $('#notifreedem').html(data.length);
        }

      });
      
  } else {

    $('#selainusermenu').attr("style","display: block;");

    $.ajax({
      type: 'GET',
      url: "{{ route('countdelivery') }}",

      success: function (data) {
        $('#delivery').html(data.length);
      }

    });
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
<script type="text/javascript">

  $('#search').on('keyup', function () {

    $('#searchss').attr("style", "display: none;");

    var ids = $(this).val();

    $.ajax({
        url: "{{ route('caritoko') }}",
        type: "POST",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $(this).val(),
        },
        success:function(data) {

            var no = -1;
            var content_data ="";

            if(ids != ''){

              if(data.length != 0){

                $.each(data, function() {

                    no++;
                    var name = data[no]['name'];
                    var id = data[no]['id'];
                    var uuid = data[no]['uuid'];
                    var photo = data[no]['photo'];
                    var alamat = data[no]['alamat'];
                    var masuk = data[no]['jam_masuk'];
                    var tutup = data[no]['jam_tutup'];
                    var regency_name = data[no]['regency_name'];

                    content_data += "<div class='card' style='border-radius: 1rem;'>";
                    content_data += "<div  onclick='PilihToko("+id+")' class='card-body shadow-ss' style='padding-right: 1rem;padding-left: 1rem;'>";
                    content_data += "<div class='row'>";
                    content_data += "<div class='col-3' style='padding-right: 0px;'>";
                    content_data += "<a href='#' class='avatar rounded-circle mr-3'>";
                    content_data += "<img src='/assets/icon/144x144.png'>";
                    content_data += "</a>";
                    content_data += "</div>";
                    content_data += "<div class='col-9' style='padding-bottom: 0px;padding-left: 0px;'>";
                    content_data += "<div class='text-warning' style='font-size: 13px;'><b>"+name+"</b></div>";
                    content_data += "<div style='font-size: 11px; padding-bottom: 8px;'>"+alamat+" - "+regency_name+"</div>";
                    content_data += "<span class='badge badge-success'>";
                    content_data += "<i class='fa fa-clock'></i>  Buka : "+masuk+" - "+tutup+"</span>";
                    content_data += "</div></div></div></div><br>";

                });

              } else {

                content_data += "";

              }

            } else {

              content_data += "";

            }

            $('#hasiltoko').html(content_data);
        }
    });

    // $.ajax({
    //     url: "{{ route('cariproduk') }}",
    //     type: "POST",
    //     data: {
    //         '_token': $('input[name=_token]').val(),
    //         'id': $(this).val(),
    //     },
    //     success:function(data) {

    //         var no = -1;
    //         var content_data ="";

    //         if(ids != ''){

    //           if(data.length != 0){

    //             content_data += "<div class='ct-page-title'><h3 class='ct-title' id='content'><b>Produk</b></h3></div>";

    //             $.each(data, function() {

    //                 no++;
    //                 var name = data[no]['name'];
    //                 var id = data[no]['id'];
    //                 var imgname = data[no]['imgname'];
    //                 var hargaact = data[no]['harga_act'];
    //                 var type = data[no]['type'];
    //                 var wilayah_name = data[no]['wilayah_name'];

    //                 content_data += "<a href='/users/detail/"+id+"'><div class='card shadow-ss'>";
    //                 content_data += "<div class='card-body' style='padding-top: 0.8rem;padding-bottom: 0.8rem;'>";
    //                 content_data += "<table width='100%' border='0'>";
    //                 content_data += "<tr>";
    //                 content_data += "<td width='18%' rowspan='2'>";
    //                 content_data += "<img class='card-img-top' src='/assets/img_post/"+imgname+"' alt='Card image cap'>";
    //                 content_data += "</td>";
    //                 content_data += "<td width='4%'></td>";
    //                 content_data += "<td style='padding-bottom: 0px;'><b><div style='font-size: 14px; color: #525f7f; padding-bottom: 5px;'>"+name+"</div></b></td>";
    //                 content_data += "</tr>";
    //                 content_data += "<tr>";
    //                 content_data += "<td></td>";
    //                 content_data += "<td style='padding-top: 0px;'><div style='font-size: 10px;  color: #525f7f;'>Harga Rp. "+hargaact+" Berlokasi di Outlet/Site <b>"+wilayah_name+"</b></div></td>";
    //                 content_data += "</tr>";
    //                 content_data += "</table> ";
    //                 content_data += "</div>";
    //                 content_data += "</div></a><br>";

    //             });

    //           } else {

    //             content_data += "";

    //           }

    //         } else {

    //           content_data += "";

    //         }

    //         $('#hasilproduk').html(content_data);
    //     }
    // });

  });

  function PilihToko(id){

    $('#pilihtoko').modal('show');

    $('#toko_id').val(id);

    $.ajax({
      url: "{{ route('pilihtoko') }}",
      type: "POST",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
      },
      success:function(data) {

        var content_data ="";

        content_data += "<div align='left' class='card-body shadow-ss' style='padding-right: 1rem;padding-left: 1rem;'>";
        content_data += "<div class='row'>";
        content_data += "<div class='col-3' style='padding-right: 0px;'>";
        content_data += "<a href='#' class='avatar rounded-circle mr-3'>";
        content_data += "<img src='/assets/icon/144x144.png'>";
        content_data += "</a>";
        content_data += "</div>";
        content_data += "<div class='col-9' style='padding-bottom: 0px;padding-left: 0px;'>";
        content_data += "<div class='text-warning' style='font-size: 13px;'><b>"+data.name+"</b></div>";
        content_data += "<div style='font-size: 11px; padding-bottom: 8px;'>"+data.alamat+" - "+data.regency_name+"</div>";
        content_data += "<span class='badge badge-success'>";
        content_data += "<i class='fa fa-clock'></i>  Buka : "+data.jam_masuk+" - "+data.jam_tutup+"</span>";
        content_data += "</div></div></div><br>";


        $('#pilih').html(content_data);
      }

    });

  }

  function Pilih(){

    var id = $('#toko_id').val();

    $('#pilihtoko').modal('hide');

    $.ajax({
      url: "{{ route('pilihtoko.store') }}",
      type: "POST",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
      },
      success:function(data) {

        swal("Berhasil Memilih Toko!", {
           icon: "success",
           buttons: false,
           timer: 2000,
        });
        setTimeout(function(){ window.location.href = '/reedem_point/product'; }, 1500);

      }

    });

  }

</script>
</body>
</html>