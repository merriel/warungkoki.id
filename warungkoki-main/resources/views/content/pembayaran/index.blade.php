@if(Auth::user())
@include('layout.head')
@else
@include('layout.head2')
@endif
<style type="text/css">
  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 11px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: #feac3b;
    color: white;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Pembayaran</h1>
      </div>
      @if(Auth::user())
        @if($wilayah->toko != "N")
        <div class="row">
          <div class="col">
            <div class="card-body shadow-ss bg-success" style="border-radius: 2rem;">
              <table width="100%">
                <tr>
                  <td>
                    <div style="font-size: 11px;" class="text-white">
                        Saldo WarungKoki Anda sebesar : <b>{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
                    </div>
                  </td>
                  <td>
                    <!-- <button onclick="IsiSaldo()" class="btn btn-success btn-sm">Isi Saldo</button> -->
                  </td>
                </tr>
              </table>        
              
            </div>
          </div>
        </div>
        @endif
      @endif


      <!-- Card stats -->
      @if(Auth::user())
        @if($wilayah->toko != "N")
        <div class="row">
          <div class="col-12" onclick="Cash(1)">
            <div class="card shadow-ss" style="border-radius:1rem;">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="20%" align="left"><i class="fa fa-handshake" style="font-size: 30px; color: #01497f"></i></td>
                    <td align="right">
                      <h6 style="margin-bottom: 0px;"><b>Pembayaran Melalui Kasir</b></h6>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        @endif
      @endif

        @if(!$promo)
          @if(Auth::user())
          <div class="col-12" onclick="Cash(3)">
          @else
          <div class="col-12" onclick="Cash(3)" style="padding-right:0px;padding-left:0px;">
          @endif
            <div class="card shadow-ss" style="border-radius:1rem;">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td align="left" height="30" width="30%">
                      <img width="90%" src="/assets/content/img/theme/gopay.png">
                    </td>
                    <td align="right"><h6 style="margin-bottom: 0px;"><b>GO-PAY</b></h6></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        @endif
       
        <!-- @if(Auth::user())
          @if($wilayah->toko != "N")
            <div class="col-12" onclick="Cash(4)">
              <div class="card shadow-ss" style="border-radius:1rem;">
                <div class="card-body">
                  <table width="100%" border="0">
                    <tr>
                      <td align="left" height="30" width="20%">
                        <img width="120%" src="/assets/content/img/theme/ovo.png">
                      </td>
                      <td align="right"><h6 style="margin-bottom: 0px;"><b>OVO</b></h6></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          @endif
        @endif -->
        
        @if(Auth::user())
          @if($wilayah->toko != "N")
          <div class="col-12" onclick="Cash(2)">
          <!-- <div class="col-12" onclick="Maintenance()"> -->
            <div class="card shadow-ss" style="border-radius:1rem;">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td align="left" height="30" width="20%">
                      <img width="180%" src="/assets/splash/images/warung.png">
                    </td>
                    <td align="right"><h6 style="margin-bottom: 0px;"><b>Saldo Warungkoki</b></h6></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          @endif
        @endif

    </div>
@include('content.pembayaran.modal')
@if(Auth::user())
@include('layout.footer')
@else
@include('layout.footer2')
@endif 
<script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

    $.ajax({
      type: 'GET',
      url: "{{ route('GetCountKeranjang') }}",

      success: function (data) {
       
        if(data == '0'){
            $('.loading').attr('style','display: block');
            setTimeout(function(){ window.location.href = '/users/transaksi'; }, 1500);
        } 

      }

    });

  });

  function Maintenance(){

    $('#maintenances').modal('show');
  }
  
  function Cash(id){

    $('#idnya').val(id);

    if(id == 1){

      $('#tombolnya').html('<button type="button" onclick="BayarNow()" class="btn btn-success">Bayar Sekarang</button>');

    } else if(id == 2){

      $('#tombolnya').html('<button type="button" onclick="BayarSaldoNow()" class="btn btn-success">Bayar Sekarang</button>');

    } else if(id == 3){

      $('#tombolnya').html('<button type="button" onclick="BayarOnline()" class="btn btn-success">Bayar Sekarang</button>');

    } else {

       $('#tombolnya').html('<button type="button" onclick="Doku(1)" class="btn btn-success">Bayar Sekarang</button>');
    }

    $('#cashmodal').modal('show');

  }

  function Cash2(id){

    $('#cashmodal2').modal('show');

  }

  function Online(){

    $('#onlinemodal2').modal('show');

  }

  function BayarOnline(){

    $('#onlinemodal2').modal('hide');

    $('.loading').attr('style','display: block');

    setTimeout(function(){ window.location.href = '/users/bayar/konfirm'; }, 100);


  }

  function BayarNow(){

    $.ajax({
      type: 'GET',
      url: "{{ route('validasiwilayahbayar') }}",

      success: function(data) {

        if(data.wilayah == 1){

          $('#konfirm').modal('show');
          $('#cashmodal').modal('hide');

        } else {

          swal({
            title: "Perhatikan",
            text: "Pembelian Diharuskan pada satu Outlet saja!",
            icon: "error",
            buttons: false,
            timer: 2000,
          });

        }

      }

    });

    

  }

  function YakinBayar(){

    $('#konfirm').modal('hide');
    $('#token').modal('show');

  }


$('#reedemtoken').on('click', function () {

  $('.loading').attr('style','display: block');
  $('#token').modal('hide');

  var tokens = $('#tokenusers').val();

  $.ajax({
    type: 'POST',
    url: "{{ route('validasitoken') }}",
    data: {
        '_token': $('input[name=_token]').val(),
        'token': $('#tokenusers').val(),  
    },
    success: function(data) {

      if(data == '1'){

        $.ajax({
          type: 'POST',
          url: "{{ route('bayar.cash') }}",
          data: {
              '_token': $('input[name=_token]').val(),
          },
          success: function(data) {

            swal("Pembelian Anda telah Berhasil!", {
               icon: "success",
               buttons: false,
               timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/home'; }, 1500);

          }

        });

      } else if(data == '2'){

        swal({
          title: "Token Anda Salah",
          text: "Anda dapat Lihat di Menu Profile!",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

          $('.loading').attr('style','display: none');
        

      } else {

        swal({
          title: "Belum Ada Token",
          text: "Update Token di Menu Profile!",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

          $('.loading').attr('style','display: none');

      }

    }

  });
});

function BayarSaldoNow(){

  $.ajax({
    type: 'GET',
    url: "{{ route('validasiwilayahbayar') }}",

    success: function(data) {

      if(data.saldo == 1) {

        $('#konfirm2').modal('show');
        $('#cashmodal').modal('hide');

      } else {

        swal({
          title: "Perhatikan",
          text: "Saldo Warungkoki Anda Tidak Mencukupi",
          icon: "error",
          buttons: false,
          timer: 2000,
        });

      }

    }

  });

}

function YakinBayar2(){

  $('#konfirm2').modal('hide');
  $('#token2').modal('show');

}

$('#reedemtoken2').on('click', function () {

  $('.loading').attr('style','display: block');
  $('#token2').modal('hide');

  var tokens = $('#tokenusers2').val();

  $.ajax({
    type: 'POST',
    url: "{{ route('validasitoken') }}",
    data: {
        '_token': $('input[name=_token]').val(),
        'token': $('#tokenusers2').val(),  
    },
    success: function(data) {

      if(data == '1'){

        $.ajax({
          type: 'POST',
          url: "{{ route('bayar.saldo') }}",
          data: {
              '_token': $('input[name=_token]').val(),
          },
          success: function(data) {

            swal("Pembelian Anda telah Berhasil!", {
               icon: "success",
               buttons: false,
               timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/home'; }, 1500);

          }

        });

      } else if(data == '2'){

        swal({
            title: "Token Anda Salah",
            text: "Anda dapat Lihat di Menu Profile!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

        $('#cashmodal2').modal('show');

        $('.loading').attr('style','display: none');
        

      } else {

        swal({
            title: "Belum Ada Token",
            text: "Update Token di Menu Profile!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

        $('#cashmodal2').modal('show');

        $('.loading').attr('style','display: none');

      }

    }

  });
});

function Doku(id){

  $('#idz').val(id);

  if(id == 1){

    $('#ovomodal').modal('show');
    $('#cashmodal').modal('hide');

  } else {

    $('#dokumodal').modal('show');

  }

}


function OVO(){

  var empty = false;
  $('input.isian').each(function() {
      if ($(this).val() == '') {
          empty = true;
      }
  });
  if (empty) {

      swal({
          title: "Warning!!",
          text: "OVO ID Harap Diisi",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

  } else {

    $.ajax({
      type: 'POST',
      url: "{{ route('update.ovoid') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'ovo': $('#ovoid').val(),  
      },
      success: function(data) {

        $('#ovomodal').modal('hide');

        $('#ovoproses').modal({backdrop: 'static', keyboard: false}); 

        $.ajax({
          type: 'POST',
          url: "{{ route('bayar.doku') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': 1,  
          },
          success: function(data) {
        
            if(data.status == "FAILED"){

              swal({
                  title: "FAILED!!",
                  text: "Pembayaran Dibatalkan!",
                  icon: "error",
                  buttons: false,
                  timer: 2000,
              });

              $('#ovoproses').modal('hide');

              setTimeout(function(){ window.location.href = '/users/transaksi/detail?uuid='+data.transactionid; }, 1500);

            } else if(data.status == "TIMEOUT"){

              swal({
                  title: "FAILED!!",
                  text: "Waktu Pembayaran Habis!",
                  icon: "error",
                  buttons: false,
                  timer: 2000,
              });

              $('#ovoproses').modal('hide');

              setTimeout(function(){ window.location.href = '/users/transaksi/detail?uuid='+data.transactionid; }, 1500);

            } else {

              $.ajax({
                type: 'POST',
                url: "{{ route('bayar.doku.sukses') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'uuid': data.transactionid,  
                },
                success: function(data) {        

                  swal({
                      title: "Sukses!!",
                      text: "Pembayaran Anda Berhasil!",
                      icon: "error",
                      buttons: false,
                      timer: 2000,
                  });

                  setTimeout(function(){ window.location.href = '/home'; }, 1500);


                }

              });
            }
          }

        });

      }

    });
  }

}

</script>
</body>

</html>