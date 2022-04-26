@include('layout.head')
<style type="text/css">
  .nav2 {
    position: fixed;
    bottom: 0;
    background-color: #2dce89;
    display: flex;
    overflow-x: auto;

    margin-bottom: 80px;
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
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
        <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
        <input type="hidden" id="hariini" value="{{ date('Y-m-d') }}">
          <table width="100%">
            <tr>
              <td align="left">
                <div style="font-size: 12px;padding-bottom: 8px;">
                  <b>Alamat Pengiriman Anda</b>
                </div>
              </td>
            </tr>

          </table>
          

          <div style="font-size: 14px;" class="text-success"><b>{{ $alamat->judul }}</b></div>
           <div style="font-size: 11px;"><b>{{ $alamat->penerima }} ({{ $alamat->nohp }})</b></div>
           <div style="font-size: 10px;">{{ $alamat->alamat }} Kecamatan {{ $alamat->district_name }} {{ $alamat->regency_name }} Provinsi {{ $alamat->prov_name }} {{ $alamat->postal_code }}</div>
          <!-- Card stats -->
          <hr>

          @foreach ($kranjangs as $kranjang)

          @php

          if($kranjang->qty == '1'){

            $disabled = 'disabled';

          } else {

            $disabled = '';

          }

          $countx = DB::table('keranjang')
          ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->where([
              ['keranjang.user_id', '=', $userid],
              ['voucherdet_id', '=', NULL],
              ['wilayah.id', '=', $kranjang->id],
          ])
          ->count();

          $countx2 = DB::table('keranjang')
          ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->where([
              ['keranjang.user_id', '=', $userid],
              ['voucherdet_id', '=', NULL],
              ['wilayah.id', '=', $kranjang->id],
              ['delivery', '=', 'Y'],
          ])
          ->count();

          if($countx == $countx2){
            $checks = 'checked';
          } else {
            $checks = '';
          }

          @endphp
          <div class="row">
            <div class="col-12">
              <b class="text-warning">{{ strtoupper($kranjang->name) }}</b>
              <div style="font-size: 9px;">{{ $kranjang->regency_name }}</div>
            </div>    
          </div>

          @php

            $totwil=0;

            $detailss = DB::table('keranjang')
            ->select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","keranjang.delivery")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where([
                ['keranjang.user_id', '=', $userid],
                ['voucherdet_id', '=', NULL],
                ['wilayah.id', '=', $kranjang->id],
                ['keranjang.delivery', '=', 'Y'],
            ])
            ->get();

          
          @endphp

          <div class="row">  
            <div class="col-12">
              <div class="card shadow-ss">
                <div class="card-body">
                @foreach($detailss as $det)
                  
                    <div class="row">
                      <div class="col-4" style="padding-bottom: 0px;">
                          <img width="100%" src="/assets/img_post/{{ $det->img }}">
                      </div>
                      <div class="col-6" style="padding-bottom: 0px; padding-right: 0px;">
                          <div style="font-size: 13px"><b>{{ $det->prod_name }} {{ $det->name }}</b></div>
                          <div style="font-size: 10px">Terdapat {{ $det->qty }} barang</div>
                          <h4 class="text-warning"><b>{{ rupiah($det->harga_act - ceil($det->harga_act * (float)$diskon / 100)) }}</b></h4>  
                      </div>
                    </div>
                  
                    <hr>
                @php
                $totwil += $det->qty * ($det->harga_act - ceil($det->harga_act * (float)$diskon / 100));
                @endphp
                @endforeach

                <label>Rencana Pengiriman :</label>
                <input type="date" class="form-control" id="plan">
                <hr>
                <table width="100%">
                  <tr>
                    <td>
                      <div style="font-size: 13px;padding-bottom: 8px;">
                        Pengiriman GRATIS
                      </div>
                    </td>
                    <td align="right">
                      <div style="font-size: 14px;padding-bottom: 8px;">
                        <b>Rp. 0</b>
                      </div>
                    </td>
                  </tr>
                </table>
                <hr style="margin-bottom:0.5rem;margin-top:0.5rem">
                <!-- ======= SUBTOTAL ====== -->
                <table width="100%">
                  <tr>
                    <td>
                      <div style="font-size: 13px;padding-bottom: 8px;">
                        SUBTOTAL
                      </div>
                    </td>
                    <td align="right">
                      <div style="font-size: 14px;padding-bottom: 8px;">
                        <b id="tots_{{ $kranjang->id }}">{{ rupiah($totwil) }}</b>
                        <input type="hidden" value="{{$totwil}}" id="total_{{$kranjang->id}}">
                        <input type="hidden" class="subtotal" value="{{$totwil}}" id="total2_{{$kranjang->id}}">
                      </div>
                    </td>
                  </tr>
                </table>

                @if($potongan)

                  @if($potongan->amount == NULL)
                    <hr style="margin-bottom:0.5rem;margin-top:0.5rem">
                    <table width="100%">
                      <tr>
                        <td>
                          <div style="font-size: 13px;padding-bottom: 8px;">
                            POTONGAN - <b>{{ $potongan->percent }}%</b>
                          </div>
                        </td>
                        <td align="right">
                          <div style="font-size: 14px;padding-bottom: 8px;">
                            <b>{{ rupiah($totwil * ($potongan->percent/100)) }}</b>
                          </div>
                        </td>
                      </tr>
                    </table>
                  @else
                    <hr style="margin-bottom:0.5rem;margin-top:0.5rem">
                    <table width="100%">
                      <tr>
                        <td>
                          <div style="font-size: 13px;padding-bottom: 8px;">
                            POTONGAN
                          </div>
                        </td>
                        <td align="right">
                          <div style="font-size: 14px;padding-bottom: 8px;">
                            <b>{{ rupiah($potongan->amount) }}</b>
                          </div>
                        </td>
                      </tr>
                    </table>

                  @endif


                @endif
                </div>
              </div>
            </div>    
          </div>
          
          @endforeach 

          @php

          $total=0;

          $totalnyas = DB::table('keranjang')
          ->select("keranjang.qty","posts.harga_act")
          ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
          ->leftJoin("product", "posts.product_id", "=", "product.id")
          ->where([
              ['keranjang.user_id', '=', $userid],
              ['voucherdet_id', '=', NULL],
              ['keranjang.delivery', '=', 'Y'],
          ])
          ->get();

          foreach($totalnyas as $t){

            $total += $t->qty * ($t->harga_act - ceil($t->harga_act * (float)$diskon / 100));

          }

          if($potongan){

            if($potongan->amount == NULL){

              $total = $total - ($total * ($potongan->percent/100));

            } else {

              $total = $total - $potongan->amount;

            }
          }

          @endphp
           
@include('xhome.delivery.modal')
 <!-- Footer -->
</div>
</div>



@if(Auth::user()->role_id == '4')
<br><br><br><br><br><br>
<nav class="nav2">
  <a href="#" class="nav__link menusxx">
    <div class="text-white" style="font-size: 10px;">Grand Total :</div> 
      <div class="text-white" style="font-size: 16px;"> 
        <b id="totalsemua">{{ rupiah($total) }}</b>
        <input type="hidden" id="totalsemuahidden" value="{{ $total }}">
      </div>
  </a>
  <a href="#" class="nav__link menusxx">
      <button id="pembayaran" onclick="Pembayaran();" class="btn btn-secondary btn-sm" type="button">Pembayaran</button>  
  </a>
</nav>
<nav class="nav">
  <a href="/home" class="nav__link menusxx">
    <div id="homes">
      
    </div>
    <i class="fa fa-home" style="font-size: 18px;" color: white;></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Home</b></div>
    </span>
  </a>
  <a href="/keranjang" class="nav__link menusxx">
    <div id="keranjangmenu">
      <span class="circlekeranjang"><b id="keranjangcount">0</b></span>
    </div>
    <i class="fa fa-shopping-basket" style="font-size: 18px; color: white;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Keranjang</b></div>
    </span>

  </a>
  <a href="/users/transaksi" class="nav__link menusxx">
    <i class="fa fa-gift" style="font-size: 18px; color: white;"></i>
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px; color: white;"><b>Transaksi</b></div>
    </span>
  </a>
  
  <a href="/favorite" class="nav__link menusxx">
    <i class="fa fa-heart" style="font-size: 18px; color: white;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Favorite</b></div>
    </span>
  </a>

</nav>

@endif
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
  
  <!-- <script src="/js/app.js"></script> -->
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js"></script>

<!--   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
 
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


    function Pembayaran(){

      var bayar = $('#plan').val();

      if(bayar == ""){

        swal({
            title: "Perhatikan",
            text: "Harap isi Rencana Pengiriman!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });


      } else {

        setTimeout(function(){ window.location.href = '/xhome/bayar?plan='+bayar+''; }, 1500);

      }

    }


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
  
  if(role != '3'){

    var config = {
      apiKey: "AIzaSyCatv1S29zowA-inpEgjhXb9rOCEFcyM9A",
      authDomain: "warungkoki.firebaseapp.com",
      projectId: "warungkoki",
      storageBucket: "warungkoki.appspot.com",
      messagingSenderId: "811344277883",
      appId: "1:811344277883:web:1ba003d0fa821bff94cdde",
      measurementId: "G-HHJBY31Z5M"
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
    
  }

  </script>

  

<script type="text/javascript">

  $('#kode').val('');

  function angkaqty(e) {
    if (!/^[0-9]*\.?[0-9]*$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
    }
  }


</script>
</body>

</html>