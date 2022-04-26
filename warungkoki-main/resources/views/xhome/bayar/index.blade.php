@include('layout.head')
<style type="text/css">
  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 11px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: #1d8ee5;
    color: white;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Pembayaran</h1>
      </div>
      <input type="hidden" id="plan" value="{{ $plan }}">
      <div class="row">
        <div class="col">
          <div class="card-body shadow-ss bg-deliver" style="border-radius: 2rem;">
                      
            <div style="font-size: 11px; color: white">
                <i class="fa fa-money"></i>
                Anda memiliki saldo sebesar : <b>{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
            </div>
          </div>
        </div>
      </div>
      <!-- Card stats -->
      <div class="row">
        <!-- <div class="col-6" onclick="Cash()" style="padding-right: 7.5px;">
          <div class="card shadow-ss">
            <div class="card-body">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-handshake" style="font-size: 30px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="7px"></td>
                </tr>
                <tr>
                  <td align="center">
                    <h6 style="margin-bottom: 0px;"><b>Bayar Pakai Saldo Warungkoki</b></h6>
                  </td>
                </tr>
                
              </table>
            </div>
          </div>
        </div> -->

        <div class="col-12" onclick="Cash(1)">
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

        <div class="col-12" onclick="Cash(2)">
          <div class="card shadow-ss" style="border-radius:1rem;">
            <div class="card-body">
              <table width="100%" border="0">
                <tr>
                  <td align="left" height="30" width="20%">
                    <img width="140%" src="/assets/content/img/theme/gopay.png">
                  </td>
                  <td align="right"><h6 style="margin-bottom: 0px;"><b>GO-PAY</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

       <!--  <div class="col-6" onclick="Online()" style="padding-left: 7.5px;">
          <div class="card shadow-ss">
            <div class="card-body">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-credit-card" style="font-size: 30px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="7px"></td>
                </tr>
                <tr>
                  <td align="center"><h6 style="margin-bottom: 0px;"><b>Pembayaran Secara Online</b></h6></td>
                </tr>
                 
              </table>
            </div>
          </div>
        </div> -->
      </div>

    </div>
    @include('xhome.bayar.modal') 
    @include('layout.footer')  

    <script type="text/javascript">

      $(document).ready(function(){

        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.keranjang.count') }}",

          success: function (data) {
           
            if(data == '0'){
                $('.loading').attr('style','display: block');
                setTimeout(function(){ window.location.href = '/users/transaksi'; }, 1500);
            } 

          }

        });

      });
      
      function Cash(id){

        $('#idnya').val(id);

        if(id == 1){

          $('#tombolnya').html('<button type="button" onclick="BayarNow()" class="btn btn-success">Bayar Sekarang</button>');

        } else if(id == 2){

          $('#tombolnya').html('<button type="button" onclick="BayarOnline()" class="btn btn-success">Bayar Sekarang</button>');

        }

        $('#cashmodal').modal('show');

      }

      function Online(){

        $('#onlinemodal').modal('show');

      }

      function BayarOnline(){

        $('#onlinemodal2').modal('hide');

        var plan = $('#plan').val();

        $('.loading').attr('style','display: block');

        setTimeout(function(){ window.location.href = '/users/bayar/konfirm?plan='+plan+''; }, 100);

      }

      // function BayarOnline(){

      //   $('#onlinemodal').modal('hide');

       
      //   $.post("{{ route('order.storedelivery') }}",
      //   {
      //       _method: 'POST',
      //       _token: '{{ csrf_token() }}',
      //       note: 'Beli Delivery',
      //       order_type: 'Pembelian Delivery',
      //   },
      //   function (data, status) {
      //       snap.pay(data.snap_token, {
               
      //           onSuccess: function (result) {
      //               location.reload();
      //           },
          
      //           onPending: function (result) {
      //               location.reload();
      //           },
                
      //           onError: function (result) {
      //               location.reload();
      //           }
      //       });
      //   });
      //   return false;

      // }

      function BayarNow(){

        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.validasi') }}",

          success: function(data) {

            if(data.saldo == 0) {

              $('#konfirm').modal('show');
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
              url: "{{ route('xhome.bayar.delivery') }}",
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

    </script>
</body>

</html>