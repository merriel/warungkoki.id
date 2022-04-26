@include('layout.head')
<style type="text/css">
  .nav2 {
    position: fixed;
    bottom: 0;
    background-color: #2dce89;
    display: flex;
    overflow-x: auto;

    margin-bottom: 75px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 60px;
    margin-left: 5%;
    width: 90%;

}

.nav__link2 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #444444;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}
</style>
  <div class="main-content">
    <!-- Header -->
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10rem;">
      <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
    <div class="ct-page-title">
      <h1 class="ct-title" id="content">On Progress Delivery</h1>
    </div>
    <hr>
    <!-- Card stats -->
    @if($transaksis->count() == '0')
      <div class="card shadow-ss">
        <div class="card-body">
          <table width="100%" border="0">
            <tr>
              <td><h6>Belum ada Transaksi Delivery Apapun pada Saat ini!</h6></td>
            </tr>
          </table>
        </div>
      </div>
    @else
      @foreach($transaksis as $trans)

      <a href="/xhome/petugas/detail?uuid={{ $trans->uuid }}"><div class="card shadow-ss menusxx">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="4">
                  <div class="icon icon-shape bg-kuning text-white rounded-circle shadow-ss">
                    <i class="fas fa-truck" style="color: #ffffff"></i>
                </div>
                </td>
                <td><b><div style="font-size: 17px"></div></b></td>
              </tr>

              @php

                $barang = DB::table('transaction_details')
                ->select("posts.name","transactions.created_at","orders.amount","orders.type_bayar","wilayah.name as wilayah_name")
                ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                ->where("transactions.id", $trans->id)
                ->first();

                if($barang->type_bayar == "CASH"){
                  $btns = 'primary';
                  $icons = 'gift';
                } else {
                  $btns = 'info';
                  $icons = 'laptop';
                }

                $details = DB::table('transaction_details')
                ->select("posts.name","product.name as prod_name")
                ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->distinct()
                ->where("transactions.id", $trans->id)
                ->limit(2)
                ->get();

                $detailcounts = DB::table('transaction_details')
                ->select("posts.name","product.name as prod_name")
                ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->distinct()
                ->where("transactions.id", $trans->id)
                ->count();


              @endphp
              <tr>
                <td>
                  <div class="text-warning" style="font-size: 14px; color: black;">
                    <b>@foreach($details as $detail) {{ $detail->prod_name }} {{ $detail->name }}, @endforeach</b>
                    @if($detailcounts > 2)
                    <b style="color: black; font-size: 11px;">+ {{ $detailcounts - 2 }} Produk</b>
                    @endif
                  </div>
                  
                </td>
              </tr>
              <tr>
                <td>
                  <div style="font-size: 13px;color: black;padding-bottom: 3px;">
                    <b>{{ date('d M Y', strtotime($trans->created_at)) }} | Rp. {{ $barang ?  number_format($barang->amount,0,',','.') : '' }} {{ $trans->jam == '' ? '' : '| '.$trans->jam }}</b><br>
                    <div style="font-size: 10px;color: black;">Transaksi ini mengandung {{ $detailcounts }} barang</div>
                    </div>

                </td>
              </tr>
            </table>
          </div>
        </div>
      </a>
      <br>
      @endforeach


    @endif
           
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
  
  <!-- <script src="/js/app.js"></script> -->
  <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-messaging.js"></script>

<!--   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
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

      setTimeout(function(){ $('.loading').attr('style','display: none'); }, 1000);

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
        url: "{{ route('getcountSaldo') }}",

        success: function (data) {
          $('#saldocount').html(data);

        }

      });

      $.ajax({
        type: 'GET',
        url: "{{ route('getcounthome') }}",

        success: function (data) {

          if(data != '0'){

            $('#homes').html('<div id="keranjangmenu"><span class="circlekeranjang"><b id="homecount">'+data+'</b></span></div>');
          } 
          

        }

      });

      // $.ajax({
      //   type: 'GET',
      //   url: "{{ route('countpesanusers') }}",

      //   success: function (data) {
      //     $('#komentarcountusers').html(data);
      //   }

      // });

    } else if(role == '0'){

      $('#belumlogin').attr("style","display: block;");

    } else if(role == '3'){

        $('#userpetugas').attr("style","display: block;");

        $.ajax({
          type: 'GET',
          url: "{{ route('countreedem') }}",

          success: function (data) {
            $('#notifreedem').html(data);
          }

        });

        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.countdelivery') }}",

          success: function (data) {
            $('#notifdelivery').html(data);
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

      // $.ajax({
      //   type: 'GET',
      //   url: "{{ route('countpesan') }}",

      //   success: function (data) {
      //     $('#komentarcount').html(data);
      //   }

      // });
    }

    $('.pop')
    .popover('show')
    .off('click');

    
  </script>
  <script type="text/javascript">

    var config = {
      apiKey: "AIzaSyB_tDnHn3pV3b_7gXCL3GA7XdWhhiok_vQ",
      authDomain: "tomxperience-dev.firebaseapp.com",
      projectId: "tomxperience-dev",
      storageBucket: "tomxperience-dev.appspot.com",
      messagingSenderId: "953896781879",
      appId: "1:953896781879:web:3af00fec9c5b2b00d757b2"
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

      if (role == '4'){

        swal({
            title: "Mantapp!",
            text: "Transaksi Anda Berhasil!",
            icon: "success",
        });

        setTimeout(function(){ window.location.href = '/home'; }, 1500);
      }

      

    });

  </script>

  

</body>

</html>