@include('bazaar.layouts.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <a href="/bazaar/keranjang"><button type="button" class='btn btn-sm btn-success'>Kembali</button></a>
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Pembayaran</h1>
      </div>
      <!-- Card stats -->
      <div class="row">
        <!-- <div class="col-6" onclick="Cash()">
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
                  <td align="center"><h6><b>Pembayaran Secara Cash</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div> -->

        <div class="col-12" onclick="Online()">
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
                  <td align="center"><h6><b>Pembayaran Secara Online</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    @include('content.pembayaran.modal')
    @include('bazaar.layouts.footer')  

    <script type="text/javascript">

      $(document).ready(function(){

        $.ajax({
          type: 'GET',
          url: "{{ route('bazaar.keranjang') }}",

          success: function (data) {
           
            if(data == '0'){
                $('.loading').attr('style','display: block');
                setTimeout(function(){ window.location.href = '/bazaar/transaksi'; }, 1500);
            } 

          }

        });

      });
      
      function Cash(){

        $('#cashmodal').modal('show');

      }

      function Online(){

       // Kirim request ajax
        $.post("{{ route('order.store') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            note: 'Beli Deals',
            order_type: 'Pembelian Deals/Product',
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        });
        return false;

      }

      function BayarNow(){

        $.ajax({
          type: 'GET',
          url: "{{ route('validasiwilayahbayar') }}",

          success: function(data) {

            if(data == '1'){

              $('#konfirm').modal('show');
              $('#cashmodal').modal('hide');

            } else {

              swal({
                title: "Perhatikan",
                text: "Pembelian Cash diharuskan pada satu Outlet saja!",
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

        setTimeout(function(){ $('.loading').attr('style','display: block'); }, 1000);

        $.ajax({
          type: 'GET',
          url: "{{ route('transaksicash') }}",

          success: function(data) {

            $('#img_barcode').html("<img width='100%' alt='barcode' src='https://tomxperience.id/assets/barcode/barcode.php?codetype=Code128&size=85&text="+data.uuid+"'><br> <div style='padding-top: 15px;font-size: 15px;' align='center'><u><b>"+data.uuid+"</b></u></div>");
            
            $('.loading').attr('style','display: none');
            $('#barcode').modal({backdrop: 'static', keyboard: false});
            $('#barcode').modal('show');


          }

        });

      }

    </script>
</body>

</html>