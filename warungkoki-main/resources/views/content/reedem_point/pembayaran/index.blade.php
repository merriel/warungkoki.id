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
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 9rem;">
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
                        Saldo Poin Anda sebesar : <b>{{ $saldopoin ? ($saldopoin->sisa) : '0' }} <img width="25px" src="/assets/content/img/icons/padi.png"></b>
                    </div>
                  </td>
                  <td>
                  @if(Auth::user())
                    <button onclick="PaySaldoPoint()" class="btn btn-kuning btn-sm">Bayar</button>
                    @endif
                  </td>
                </tr>
              </table>        
              
            </div>
          </div>
        </div>
        @endif
      @endif

    </div>
@include('content.reedem_point.pembayaran.modal')
@if(Auth::user())
@include('layout.footer')
@else
@include('layout.footer2')
@endif 
<script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

    BayarSaldoPointNow();

    $.ajax({
      type: 'GET',
      url: "{{ route('reedem_point.keranjang.count') }}",

      success: function (data) {
       
        if(data == '0'){
            $('.loading').attr('style','display: block');
            setTimeout(function(){ window.location.href = '/reedem_point/produk'; }, 1500);
        } 

      }

    });

  });

  

  function PaySaldoPoint(){

    $('#paysaldopointmodal').modal('show');

  }


  function BayarSaldoPointNow(){

    $.ajax({
      type: 'GET',
      url: "{{ route('validasiwilayahbayar') }}",

      success: function(data) {

        if(data.saldo == 1) {

          $('#konfirm_paysaldopoint').modal('show');
          $('#paysaldopointmodal').modal('hide');

        } else {

          swal({
            title: "Perhatikan",
            text: "Saldo Poin Anda Tidak Mencukupi",
            icon: "error",
            buttons: false,
            timer: 2000,
          });

        }

      }

    });

  }

  function YakinBayarSaldoPoint(){

    $('#konfirm2').modal('hide');
    $('#tokenSaldoPoin').modal('show');

  }

  $('#reedemtokensaldopoin').on('click', function () {

    $('.loading').attr('style','display: block');
    $('#token2').modal('hide');

    var tokens = $('#tokenuserssaldopoin').val();

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
            url: "{{ route('bayar.saldo.point') }}",
            data: {
                '_token': $('input[name=_token]').val(),
            },
            success: function(data) {

              if(data.status === 'error'){
                swal("penukaran Anda telah Gagal, "+data.message, {
                  icon: "error",
                  buttons: false,
                  timer: 2000,
                });

                setTimeout(function(){ window.location.href = '/reedem_point/produk'; }, 1500);
              }

              swal("penukaran Anda telah Berhasil!", {
                icon: "success",
                buttons: false,
                timer: 2000,
              });

              setTimeout(function(){ window.location.href = '/reedem_point/transaksi?uuid='+data.uuid; }, 1500);

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

          $('#paysaldopointmodal').modal('show');

          $('.loading').attr('style','display: none');
          

        } else {

          swal({
              title: "Belum Ada Token",
              text: "Update Token di Menu Profile!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          $('#paysaldopointmodal').modal('show');

          $('.loading').attr('style','display: none');

        }

      }

    });
  });


</script>

</body>

</html>