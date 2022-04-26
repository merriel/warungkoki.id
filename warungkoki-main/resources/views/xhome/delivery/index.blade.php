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
        <input type="hidden" id="hariini" value="{{ date('Y-m-d') }}">
          <table width="100%">
            <tr>
              <td align="left">
                <div style="font-size: 12px;padding-bottom: 8px;">
                  <b>Alamat Pengiriman Anda</b>
                </div>
              </td>

              <td align="right">
                <div onclick="Ganti()" style="font-size: 12px;padding-bottom: 8px;" class="text-warning">
                  <b>Ganti Alamat</b>
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
                ['posts.type', '=', 'Delivery'],
                ['wilayah.id', '=', $kranjang->id],
                ['keranjang.delivery', '=', 'Y'],
            ])
            ->get();

            $bbm = DB::table('keranjang')
            ->select("keranjang.*")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where([
                ['keranjang.user_id', '=', $userid],
                ['voucherdet_id', '=', NULL],
                ['posts.type', '=', 'Delivery'],
                ['wilayah.id', '=', $kranjang->id],
                ['keranjang.delivery', '=', 'Y'],
                ['posts.kategori_id', '=', '10'],
            ])
            ->first();

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
                          <h4 class="text-warning"><b>{{ rupiah($det->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100)) }}</b></h4>  
                      </div>
                    </div>
                  
                    <hr>
                @php
                $totwil += $det->qty * $det->harga_act;
                @endphp
                @endforeach

                @php
                $jarak = DB::table('delivery_jarak')
                ->where([
                    ['wilayah_id', '=', $kranjang->id],
                    ['district_id', '=', $alamat->district_id],
                ])
                ->first();

                @endphp
                <!-- ======== PILIH DELIVERY ======= -->
                <input type="hidden" id="jarak_{{ $kranjang->id }}" value="{{ $jarak ? $jarak->jarak : 0 }}">
                <label>Pilih Delivery</label>
                <select class="form-control" onchange="Delivery(this,{{ $kranjang->id }})">
                  <option value="">Pilih</option>
                </select>
                
                

                <div id="delivery_{{ $kranjang->id }}">

                </div>
                <hr>
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
              ['posts.type', '=', 'Delivery'],
              ['keranjang.delivery', '=', 'Y'],
          ])
          ->get();

          foreach($totalnyas as $t){

            $total += $t->qty * $t->harga_act;

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
  <a href="/xhome/bayar" class="nav__link menusxx">
      @if($totalnyas->count() == '0')
        <button class="btn btn-sm btn-secondary" type="button" disabled>Checkout</button>
      @elseif($total == 0)
        <button onclick="KeranjangNol()" class="btn btn-success" type="button">Finish</button>
      @else
        <button class="btn btn-secondary btn-sm pop" type="button">Pembayaran</button>
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

  function Delivery(elemet,id){

    var name = elemet.value;
    var jarak = $('#jarak_'+id).val();

    $('#jamx_'+id).attr('style','display:none;');
    $('#jam_'+id).attr('style','display:none;');

    if(name == "ojol"){
      $('#tanggals_'+id).attr('style','display:none;');
      $('#perhatian_'+id).attr('style','background-color: #fb6340; display: block;');
    } else {
      $('#tanggals_'+id).attr('style','display:block;');
      $('#perhatian_'+id).attr('style','background-color: #fb6340; display: none;');
    }

    $.ajax({
        type: 'POST',
        url: "{{ route('xhome.delivery.harga') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'name': name,
            'id': id,
            'jam': '',
        },

        success: function(data) {

          var content_data="";
          var harga = parseInt(data.harga);

          if(name == "ojol"){

            harga = jarak*harga;
          }

          var number_string = harga.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }

          content_data += "<table width='100%'>";
          content_data += "<tr><td>";
          content_data += "<div style='font-size: 13px;padding-bottom: 8px;'>Pengiriman</div></td>";
          content_data += "<td align='right'>";
          content_data += "<div style='font-size: 14px;padding-bottom: 8px;'>";
          content_data += "<b>Rp. "+rupiah+"</b></div></td>";
          content_data += "</tr></table>";

           $('#delivery_'+id).html(content_data);

           var tot = $('#total_'+id).val();

           var jumlah = harga + parseInt(tot);
           $('#total2_'+id).val(jumlah);

           var subtot=0;
           $('.subtotal').each(function(){
                var subs = Number($(this).val());

                subtot += subs;
            });

           var number_string2 = jumlah.toString(),
            sisa2  = number_string2.length % 3,
            rupiah2  = number_string2.substr(0, sisa2),
            ribuan2  = number_string2.substr(sisa2).match(/\d{3}/g);
              
            if (ribuan2) {
              separator = sisa2 ? '.' : '';
              rupiah2 += separator + ribuan2.join('.');
            }

           $('#tots_'+id).html('Rp. '+rupiah2);

           var number_string3 = subtot.toString(),
            sisa3  = number_string3.length % 3,
            rupiah3  = number_string3.substr(0, sisa3),
            ribuan3  = number_string3.substr(sisa3).match(/\d{3}/g);
              
            if (ribuan3) {
              separator = sisa3 ? '.' : '';
              rupiah3 += separator + ribuan3.join('.');
            }

           $('#totalsemua').html('Rp. '+rupiah3);
           $('#totalsemuahidden').val(subtot);

           if(name == "tomx"){

              $('#jam_'+id).attr("style","display:block;");

           }else{

              $('#jam_'+id).attr("style","display:none;");

           }

        }

      });
  }

  function Ganti(){

    $.ajax({
      type: 'GET',
      url: "{{ route('alamat.ganti') }}",
      success: function(data) {

        $('#ganti').modal('show');

        var content_data="";
        var no = -1;

        $.each(data, function() {

          no++;
          var id = data[no]['id'];
          var judul = data[no]['judul'];
          var alamat = data[no]['alamat'];
          var penerima = data[no]['penerima'];
          var nohp = data[no]['nohp'];
          var regency_name = data[no]['regency_name'];
          var prov_name = data[no]['prov_name'];
          var district_name = data[no]['district_name'];
          var postal_code = data[no]['postal_code'];
          var utama = data[no]['utama'];

          if(utama == "yes"){
          content_data += "<div class='card shadow bg'>";
          } else {
          content_data += "<div class='card shadow bg' onclick='Utama("+id+")'>";
          }
          content_data += "<div class='card-body'>";
          content_data += "<table width='100%' border='0'>";
          content_data += "<tr>";
          content_data += "<td width='25%'' rowspan='2'>";
          content_data += "<div class='bulat icon icon-shape bg-deliver text-white rounded-circle shadow'>";
          content_data += "<i class='fas fa-home iconx' style='color: #ffffff'></i></div></td>";
          content_data += "<td><b><div class='judul text-warning' style='font-size: 14px'>"+judul+"</div></b></td>";
          content_data += "</tr>";
          content_data += "<tr>";
          content_data += "<td><div style='font-size: 11px'><b>"+penerima+" ("+nohp+")</b></div>";
          content_data += "<div style='font-size: 10px'>"+alamat+"  Kecamatan "+district_name+" "+regency_name+" Provinsi "+prov_name+" "+postal_code+"</div></td>";
          content_data += "</tr>";
          if(utama == "yes"){
            content_data += "<tr>";
            content_data += "<td colspan='2' align='center'>";
            content_data += "<hr>";
            content_data += "<div style='font-size: 10px;'><i>Ini merupakan Alamat UTAMA Anda!</i></div></td></tr>";

          }
          content_data += "</table>";
          content_data += "</div></div><br>";


        });

        $('#isi').html(content_data);

      }

    });
  }

  function Utama(id){

    $('#id').val(id);

    $('#utamaalamat').modal('show');

  }

  function YakinUtama(){

    $.ajax({
        type: 'POST',
        url: "{{ route('alamat.utama') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#id').val(),
        },

        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Anda Berhasil Mengganti Alamat Utama!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          $('#utamaalamat').modal('hide');

          setTimeout(function(){ window.location.reload() }, 1500);


        }

      });

  }

  function Jam(elemet,id){

    var name = elemet.value;

    $.ajax({
      type: 'POST',
      url: "{{ route('xhome.delivery.jam') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'name': name,
          'id': id,
      },

      success: function(data) {

        

      }

    });
  }

  function Tanggal(elemet,id){


    var tanggal = elemet.value;
    var hariini = $('#hariini').val();

    $.ajax({
      type: 'POST',
      url: "{{ route('xhome.delivery.tanggal') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': tanggal,
          'id': id,
      },

      success: function(data) {

        

      }

    });

    if(tanggal == hariini){

      $('#jamx_'+id).attr('style','display:none;');
      $('#jam_'+id).attr('style','display:block;');

    } else {

      $('#jam_'+id).attr('style','display:none;');
      $('#jamx_'+id).attr('style','display:block;');


    }

    
  }

</script>
</body>

</html>