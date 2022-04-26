 <!-- Footer -->

    </div>
  </div>
  <br><br><br><br>
  <nav class="nav">
  <a href="/working-space/home" class="nav__link menusxx">
    <i class="fa fa-home" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Home</b></div>
    </span>
  </a>
  <a href="/working-space/history" class="nav__link menusxx">
    <i class="fa fa-history" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px;"><b>History</b></div>
    </span>
  </a>

  <a href="/promo" class="nav__link menusxx">
    <i class="fa fa-arrow-left" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px;"><b>Back to Home</b></div>
    </span>
  </a>
  
  <a href="/profile" class="nav__link menusxx">
    <i class="fa fa-user" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Profile</b></div>
    </span>
  </a>
</nav>
  
  <!--   Core   -->
  <script src="{{ asset ('assets/content/js/plugins/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset ('assets/content/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!--   Argon JS   -->
  <script src="../js/app.js"></script>
  <script src="{{ asset ('assets/content/js/argon-dashboard.min.js?v=1.1.0') }}"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
  </script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
  
  <script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-messaging.js"></script>

  <script src="https://www.gstatic.com/firebasejs/7.2.3/firebase-analytics.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  
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
        url: "{{ route('GetCountMessages') }}",

        success: function (data) {
          $('#messagescount').html(data);
        }

      });

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
        url: "{{ route('countpesanusers') }}",

        success: function (data) {
          $('#komentarcountusers').html(data);
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
            $('#notifreedem').html(data.length);
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

    
  </script>

  <script type="text/javascript">

    var config = {
      apiKey: "AIzaSyBXPLEpZkP6lH8gPpBWYa2Z835ZHiUZS8w",
      authDomain: "iolosmart.firebaseapp.com",
      databaseURL: "https://iolosmart.firebaseio.com",
      projectId: "iolosmart",
      storageBucket: "iolosmart.appspot.com",
      messagingSenderId: "952156759200",
      appId: "1:952156759200:web:34521ba5714245f59895c5",
      measurementId: "G-N6XT2RHV8D"
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

      swal({
          title: "Mantapp!",
          text: "Transaksi Anda Berhasil!",
          icon: "success",
      });

    });


    // var url = window.location.pathname;

    // if(url != '/profile'){

    //   $.ajax({
    //     type: 'GET',
    //     url: "{{ route('getprofile') }}",

    //     success: function (data) {
          
    //       if(data == 0){

    //         swal({
    //             title: "Perhatian!",
    //             text: "Harap Lengkapi Profile Anda Terlebih Dahulu!",
    //             icon: "warning",
    //             buttons: false,
    //             timer: 2000,
    //         });
    //         setTimeout(function(){ window.location.href='/profile'; }, 2000);

    //       }

    //     }

    //   });

    // }

  </script>