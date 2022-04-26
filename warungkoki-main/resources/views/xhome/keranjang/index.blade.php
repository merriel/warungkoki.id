@include('xhome.layout.head')
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
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 4.8rem;">
        <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          <div class="ct-page-title" style="border-left: 2px solid #2dce89;">
            <h1 class="ct-title" id="content">Keranjang Anda</h1>
          </div>
          <hr>
          <!-- Card stats -->
          @php

          if($ada >= 1){
          @endphp
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
              ['posts.type', '=', 'Delivery'],
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
              ['posts.type', '=', 'Delivery'],
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
            <div class="col-2">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input id="all_{{ $kranjang->id }}" onchange="checkAll({{ $kranjang->id }})" type="checkbox" {{ $checks }}>
                </div>
              </div>
            </div>
            <div class="col-10">
              <b class="text-warning">{{ strtoupper($kranjang->name) }}</b>
              <div style="font-size: 9px;">{{ $kranjang->regency_name }}</div>
            </div>    
          </div>

          @php

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
                ['posts.type', '=', 'Delivery'],
                ['wilayah.id', '=', $kranjang->id],
            ])
            ->get();

          @endphp

          @foreach($detailss as $det)

          @php
          if($det->delivery == 'Y'){
            $checked = 'checked';
          } else {
            $checked = '';

          }
          @endphp

          <div class="row">
            <div class="col-2">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input type="checkbox" value="{{ $det->id }}" id="produk_{{ $det->id }}" onchange="CheckSatu({{ $det->id }})" class="prod_{{ $kranjang->id }}" {{ $checked }}>
                </div>
              </div>
            </div>
            <div class="col-10">
              <div class="card shadow-ss">
                <div class="card-body">
                  <div class="row">
                    <div class="col-4" style="padding-bottom: 0px;">
                        <img width="100%" src="/assets/img_post/{{ $det->img }}">
                    </div>
                    <div class="col-6" style="padding-bottom: 0px; padding-right: 0px;">
                        <div style="font-size: 13px"><b>{{ $det->prod_name }} {{ $det->name }}</b></div>
                        <h4 class="text-warning"><b>{{ rupiah($det->harga_act) }}</b></h4>
                        <table width="100%">
                          <tr>
                            <td align="center">
                              <button onclick="Minus({{ $det->id }})" id="minus_{{ $det->id }}" class="btn btn-sm btn-success" {{ $disabled }}><i class="fa fa-minus"></i></button>
                            </td>
                            <td width="40%">
                              <input type="text" id="qtyview_{{ $det->id }}" class="form-control" value="{{ $det->qty }}" disabled>
                              <input type="hidden" id="qtynow_{{ $det->id }}" class="form-control counts" value="{{ $det->qty }}">
                              <input type="hidden" class="ids" value="{{ $det->id }}">
                            </td>
                            <td align="center">
                              @if(!$adatrans)
                              <button onclick="Plus({{ $det->id }})" class="btn btn-sm btn-success pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Tambah Qty"><i class="fa fa-plus"></i></button>
                              @else
                              <button onclick="Plus({{ $det->id }})" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button>
                              @endif
                            </td>
                          </tr>
                        </table>
                        
                    </div>
                    <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">
                        @if(!$adatrans)
                        <span style="font-size: 30px" class="ni ni-fat-remove pop" onclick="RemoveKeranjang({{ $det->id }})" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Hapus Produk dari keranjang"></span>
                        @else
                        <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveKeranjang({{ $det->id }})"></span>
                        @endif
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>    
          </div>


          @endforeach
          <hr>

          @endforeach 
          @php
          } else {
          @endphp
          <div class="row">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <table width="100%">
                        <tr>
                          <td align="center">
                            <img src="/assets/content/img/theme/nothing.jpg" width="90%">
                            <br>
                            <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                            <h6>Tidak ada Transaksi apapun di Keranjang ini, Ayo Belanja!</h6>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
          @php
          }
          @endphp
          

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
              ['posts.type', '=', 'Delivery'],
              ['keranjang.delivery', '=', 'Y'],
          ])
          ->get();

          foreach($totalnyas as $t){

            $total += $t->qty * $t->harga_act;

          }

          @endphp
           
@include('content.keranjang.modal')
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
      </div>
  </a>
  <a href="/xhome/delivery" class="nav__link menusxx">
      @if($totalnyas->count() == '0')
        <button class="btn btn-sm btn-secondary" type="button" disabled>Checkout</button>
      @elseif($total == 0)
        <button onclick="KeranjangNol()" class="btn btn-success" type="button">Finish</button>
      @else
        <button class="btn btn-secondary btn-sm pop" type="button">Checkout</button>
      @endif
  </a>
</nav>

<nav class="nav">
      <a href="/xhome" class="nav__link menusxx">
        <i class="fa fa-home" style="font-size: 18px;"></i>
        <span class="nav__text">
          <div style="font-size: 10px; padding-top: 8px;"><b>Home</b></div>
        </span>
      </a>
      <a href="/xhome/keranjang" class="nav__link menusxx">
        <div id="keranjangmenu">
          <span class="circlekeranjang"><b id="keranjangcount">0</b></span>
        </div>
        <i class="fa fa-shopping-basket" style="font-size: 18px;"></i>
        <span class="nav__text">
          <div style="font-size: 10px; padding-top: 8px;"><b>Keranjang</b></div>
        </span>

      </a>
      <a href="/xhome/history" class="nav__link menusxx">
        <i class="fa fa-gift" style="font-size: 18px;"></i>
        <span class="nav__text">
          <div class="" style="font-size: 10px; padding-top: 8px;"><b>History</b></div>
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
        url: "{{ route('xhome.keranjang.count') }}",

        success: function (data) {
          $('#keranjangcount').html(data);

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

  

<script type="text/javascript">

  $('#kode').val('');

  function angkaqty(e) {
    if (!/^[0-9]*\.?[0-9]*$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
    }
  }
  
  $('#bayarx').on('click', function () {

      $('#pilihmethod').modal('show');

  });

  function Nanti(numb){

      $('.loading').attr('style','display: block');

      $('#pilihmethod').modal('hide');

      var qty = [];
      var id = [];

      $('.counts').each(function(){
          qty.push($(this).val());
      });

      $('.ids').each(function(){
          id.push($(this).val());
      });

      if(numb == '0'){
        var method = 'Yes';
      } else {
        var method = 'No';
      }

      $.ajax({
         type: 'POST',
         url: "{{ route('updatekeranjang') }}",
         data: {
              '_token': $('input[name=_token]').val(),
              'id': id,
              'qty': qty,
              'method': method,
          },
         success: function(data) {

          setTimeout(function(){ window.location.href = '/users/bayar'; }, 500);

        }

      });

  }

  function Qty(){

    var qty = $('#qty').val();

    if(qty == 0){

      $('#qty').val(1);

    }

  }

  function Minus(id){

    var qty = $('#qtynow_'+id).val();
    var harga = $('#harga_'+id).val();
    var service = $('#service_'+id).val();

    var total = parseInt(qty) - 1;

    if(total == '1'){
      $('#minus_'+id).attr("disabled", "disabled");
    } else {

      $('#minus_'+id).removeAttr("disabled");

    }

    $.ajax({
      type: 'POST',
      url: "{{ route('keranjang.min') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'qty': total,
          'id': id,
      },
      success: function(data) {

        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.keranjang.total') }}",
          
          success: function(datas) {

            var reverse = datas.toString().split('').reverse().join(''),
            ribuan  = reverse.match(/\d{1,3}/g);
            ribuan  = ribuan.join('.').split('').reverse().join('');

          // Cetak hasil  
          $("#totalsemua").html('Rp '+ribuan);

          }

        });


      }

    });

    $('#qtyview_'+id).val(total);
    $('#qtynow_'+id).val(total);

    var count = 0;
    $(".counts").each(function(){
        count += +$(this).val();
    });

  }

  function Plus(id){

    var qty = $('#qtynow_'+id).val();
    var harga = $('#harga_'+id).val();
    var service = $('#service_'+id).val();

    var total = parseInt(qty) + 1;

    if(total == '1'){
      $('#minus_'+id).attr("disabled", "disabled");
    } else {

      $('#minus_'+id).removeAttr("disabled");

    }

    $.ajax({
      type: 'POST',
      url: "{{ route('keranjang.min') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'qty': total,
          'id': id,
      },
      success: function(data) {

        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.keranjang.total') }}",
          
          success: function(datas) {

            var reverse = datas.toString().split('').reverse().join(''),
            ribuan  = reverse.match(/\d{1,3}/g);
            ribuan  = ribuan.join('.').split('').reverse().join('');

          // Cetak hasil  
          $("#totalsemua").html('Rp '+ribuan);

          if(datas == 0){

            $(".btn-secondary").prop("disabled", true);
          } else {

            $(".btn-secondary").prop("disabled", false);
          }

          }

        });

      }

    });

    //TotalQTY
    $('#qtyview_'+id).val(total);
    $('#qtynow_'+id).val(total);

    //HitungKeseluruhanQty
    var count = 0;
    $(".counts").each(function(){
        count += +$(this).val();
    });

  

  }

  function RemoveKeranjang(id){

        $('#id').val(id);

        $('#confirm_hapus').modal('show');

    }

    $('#confirm_yakin').on('click', function () {

      $('#confirm_hapus').modal('hide');

      $.ajax({
        type: 'POST',
        url: "{{ route('xhome.keranjang.delete') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#id').val(),  
        },
        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Produk Dalam Keranjang di Hapus!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        }

      });
    });

    function checkAll(id){

      if ($('#all_'+id).is(":checked")){

        $('.prod_'+id).prop('checked', true);

        var produk = [];

        $('.prod_'+id).each(function(){
              produk.push($(this).val());
        });

        $.ajax({
          type: 'POST',
          url: "{{ route('xhome.checklistall') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': produk,  
          },
          success: function(data) {

            $.ajax({
              type: 'GET',
              url: "{{ route('xhome.keranjang.total') }}",
              
              success: function(datas) {

                var reverse = datas.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                ribuan  = ribuan.join('.').split('').reverse().join('');

              // Cetak hasil  
              $("#totalsemua").html('Rp '+ribuan);

              if(datas == 0){

                $(".btn-secondary").prop("disabled", true);
              } else {

                $(".btn-secondary").prop("disabled", false);
              }

              }

            });

          }

        });
        
      } else {

        $('.prod_'+id).prop('checked', false);

        var produk = [];

        $('.prod_'+id).each(function(){
              produk.push($(this).val());
        });

        $.ajax({
          type: 'POST',
          url: "{{ route('xhome.nochecklistall') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': produk,  
          },
          success: function(data) {

            $.ajax({
              type: 'GET',
              url: "{{ route('xhome.keranjang.total') }}",
              
              success: function(datas) {

                var reverse = datas.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                ribuan  = ribuan.join('.').split('').reverse().join('');

              // Cetak hasil  
              $("#totalsemua").html('Rp '+ribuan);

              }

            });

          }

        });
      }

    }

    function CheckSatu(id){

      if ($('#produk_'+id).is(":checked")){

        $.ajax({
          type: 'POST',
          url: "{{ route('xhome.checklist') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': id,  
          },
          success: function(data) {

            $.ajax({
              type: 'GET',
              url: "{{ route('xhome.keranjang.total') }}",
              
              success: function(datas) {

                var reverse = datas.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                ribuan  = ribuan.join('.').split('').reverse().join('');

              // Cetak hasil  
              $("#totalsemua").html('Rp '+ribuan);

              if(datas == 0){

                $(".btn-secondary").prop("disabled", true);
              } else {

                $(".btn-secondary").prop("disabled", false);
              }

              }

            });


          }

        });

      } else{

        $.ajax({
          type: 'POST',
          url: "{{ route('xhome.nochecklist') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': id,  
          },
          success: function(data) {

            $.ajax({
              type: 'GET',
              url: "{{ route('xhome.keranjang.total') }}",
              
              success: function(datas) {

                var reverse = datas.toString().split('').reverse().join(''),
                ribuan  = reverse.match(/\d{1,3}/g);
                ribuan  = ribuan.join('.').split('').reverse().join('');

              // Cetak hasil  
              $("#totalsemua").html('Rp '+ribuan);

              }

            });

          }

        });

        


      }

    }

</script>
</body>

</html>