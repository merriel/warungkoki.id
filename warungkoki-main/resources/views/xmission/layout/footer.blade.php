 <!-- Footer -->
</div>
</div>

@if(Auth::user()->role_id == '4')
<br><br><br>
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
  
  
  <!-- <a href="/profile" class="nav__link menusxx">
    <i class="fa fa-user" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Profile</b></div>
    </span>
  </a> -->
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

  