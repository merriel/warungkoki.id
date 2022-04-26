@include('xmission.layout.head')
<style type="text/css">
  .nav2 {
    position: fixed;
    bottom: 0;
    background-color: #8965e0;
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
    <!-- Header -->
    <div class="header bg-gradient-purple pt-2 pt-md-8" style="padding-bottom: 14rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>

    <br>
<div class="container-fluid" style="margin-top: -10rem;">

  <div class="col-12" style="padding-bottom: 20px;padding-left: 0px;">
      <div style="font-size: 12px" class="text-white">Selamat Datang di X-Mission,</div>
      <div style="font-size: 21px" class="text-white"><b>{{ Auth::user()->name }}</b></div>
  </div>

  <div class="card shadow" style="border-radius: 1rem;">
    <div class="card-body" style="padding: 1rem;">
      <div style="padding-bottom: 16px;">
        <b style="font-size: 14px;">HOT MISSION :</b>
        <hr>
        @foreach($missions as $mis)

          <a class="menusxx" href="/xmission/detail?uuid={{ $mis->uuid }}" style="color: #525f7f;">
          <div class="card shadow-ss" style="border-radius: 1rem;">
            <div class="gambar">
              <img class="card-img-top" style="border-top-left-radius: calc(1rem - 1px);border-top-right-radius: calc(1rem - 1px);" width="50px" src="/assets/content/img/theme/promcat4.jpg" alt="Card image cap">
            </div>
            <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
              <div style="font-size: 14px;font-weight: bold;padding-bottom: 9px;">
                {{ $mis->name }}
              </div>
              <div style="font-size: 11px;">
                {{ $mis->little }}
              </div>
              
              <div style="font-size: 11px;padding-top: 8px;padding-bottom:12px;">
                Berlaku : {{ date('d F Y', strtotime($mis->dari)) }} - {{ date('d F Y', strtotime($mis->sampai)) }}
              </div>
              <button class="btn btn-block btn-primary">Ikut Mission ini</button>
            </div>
          </div>
          </a>
        <br>
          
          @endforeach
      </div>

    </div>
  </div>
  <br><br><br>
</div>
<!-- ======= SELESAI PILIH DAERAH ======= -->
 <!-- Footer -->
</div>
</div>

@if(Auth::user()->role_id == '4')
<br><br><br>
<nav class="nav2">
  <a href="#" class="nav__link">
    <div style="padding-left: 1.5rem;padding-right: 1.5rem; width: 100%" >
      <table>
        <tr>
          <td>
            <input style="border-radius: 0.5rem;" type="text" class="form-control" placeholder="Masukan Kode Voucher" id="voucher">
          </td>
          <td width="2%">&nbsp;</td>
          <td align="right">
            <button onclick="Ambil()" class="btn btn-sm btn-secondary menusxx"> Ambil</button>
          </td>
        </tr>
      </table>  
    </div> 

  </a>
</nav>
<nav class="nav">
  <a href="/xmission" class="nav__link menusxx">
    <div id="homes"> 
    </div>
    <i class="fa fa-home" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Home</b></div>
    </span>
  </a>
  <a href="/xmission/proses" class="nav__link menusxx">
    <div id="keranjangmenu">
      <span class="circlekeranjang"><b id="missioncount">0</b></span>
    </div>
    <i class="fa fa-rocket" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Your Mission</b></div>
    </span>

  </a>
  <a href="/xmission/reward" class="nav__link menusxx">
    <div id="saldomenu">
      <span class="circlesaldo"><b id="rewardcount">0</b></span>
    </div>
    <i class="fa fa-gift" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px;"><b>Reward</b></div>
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

      setTimeout(function(){ $('.loading').attr('style','display: none'); }, 1000);

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('validasikadaluarsa') }}",

      

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('xmission.count') }}",

      success: function (data) {
        $('#missioncount').html(data);

      }

    });

    $.ajax({
      type: 'GET',
      url: "{{ route('xmission.countreward') }}",

      success: function (data) {
        $('#rewardcount').html(data);

      }

    });
    
    

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
 
  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('user.guides') }}",
      success: function (data) {

        if(data != '1'){

           $('#guide').modal({backdrop: 'static', keyboard: false}); 

        } 
      }
    });

  });

  function Ambil(){

    $.ajax({
      type: 'POST',
      url: "{{ route('xmission.voucher') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'kode': $('#voucher').val(),
      },

      success: function (data) {

        if(data == 0){

          swal({
              title: "Perhatikan!",
              text: "Voucher Tersebut tidak ada!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          $('#voucher').val('');

        } else if(data == 1){

          swal({
              title: "Perhatikan!",
              text: "Voucher Tersebut sudah Digunakan!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          $('#voucher').val('');

        } else {

          swal({
              title: "Berhasil",
              text: "Selamat Anda mendapatkan Hadiah Voucher",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/xmission/reward'; }, 1500);
        }

      }

    });

  }

</script>
</body>

</html>