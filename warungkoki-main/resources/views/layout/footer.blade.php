 <!-- Footer -->
</div>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HHJBY31Z5M"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HHJBY31Z5M');
</script>

@if(Auth::user()->role_id == '4')
<br><br><br>
<nav class="nav11">
  <a href="/scanner/users" class="nav__link menusxx" style="padding-left:15px;padding-right:15px;">
    <img width="90%" src="/assets/splash/images/iconwk.jpg">
  </a>
</nav>

<nav class="nav12">
  <div class="nav__link" style="padding-left:19px;padding-right:15px;color: white;">
    <b>SCAN</b>
  </div>
</nav>
<nav class="nav9">
  
</nav>
<nav class="nav">
  <a href="/home" class="nav__link menusxx">
    <div id="homes">
      
    </div>
    <img width="60%" src="/assets/content/img/icons/home2.png">
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Home</b></div>
    </span>
  </a>
  <a href="/keranjang" class="nav__link menusxx">
    <div id="keranjangmenu">
      <span class="circlekeranjang"><b id="keranjangcount">0</b></span>
    </div>
    <img width="45%" src="/assets/content/img/icons/keranjang.png">
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Keranjang</b></div>
    </span>

  </a>
  <a href="#" class="nav__link menusxx">
  </a>
  <a href="#" class="nav__link menusxx">
  </a>
  <a href="/users/transaksi" class="nav__link menusxx">
    <div id="transaksimenu">
    </div>
    <img width="45%" src="/assets/content/img/icons/transaksi.png">
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px; color: white;"><b>Transaksi</b></div>
    </span>
  </a>
  
  <a href="/favorite" class="nav__link menusxx">
    <img width="45%" src="/assets/content/img/icons/favorite.png">
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px; color: white;"><b>Favorite</b></div>
    </span>
  </a>
  <!-- <a href="/profile" class="nav__link menusxx">
    <i class="fa fa-user" style="font-size: 18px;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;"><b>Profile</b></div>
    </span>
  </a> -->
</nav>
@elseif(Auth::user()->role_id == '3')
<nav class="nav">
  <a href="/home" class="nav__link menusxx">
    <div id="homes">
      
    </div>
    <i class="fa fa-home" style="font-size: 18px;color: white;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;color: white;"><b>Home</b></div>
    </span>
  </a>
  <a href="/reedemtoday" class="nav__link menusxx">
    <div id="keranjangmenu">
      
    </div>
    <i class="fa fa-shopping-basket" style="font-size: 18px;color: white;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;color: white;"><b>Transaksi</b></div>
    </span>

  </a>

  <a href="/reedem/bayarselesai?tanggal={{ date('Y-m-d') }}" class="nav__link menusxx">
    <i class="fa fa-check" style="font-size: 18px;color: white;"></i>
    <span class="nav__text">
      <div style="font-size: 10px; padding-top: 8px;color: white;"><b>Selesai</b></div>
    </span>
  </a>

  <a href="/reedem/bayarpending?tanggal={{ date('Y-m-d') }}" class="nav__link menusxx">
    <i class="fa fa-times" style="font-size: 18px;color: white;"></i>
    <span class="nav__text">
      <div class="" style="font-size: 10px; padding-top: 8px;color: white;"><b>Pending</b></div>
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

<!--   <script src="../carousel-12/js/popper.min.js"></script>
  <script src="../carousel-12/js/bootstrap.min.js"></script>
  <script  src="../carousel-12/js/owl.carousel.min.js"></script>
  <script src="../carousel-12/js/main.js"></script> -->
  
  <!-- <script src="/js/app.js"></script> -->
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js"></script>

<!--   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<!--   <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}">
  </script> --> 
 
 <script type="text/javascript">
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });


    var poppy = localStorage.getItem($('#urgent').val());

    if(!poppy){

          $.ajax({
            type: 'GET',
            url: "{{ route('messages.super') }}",
            success: function(data) {

              $('#judul').html(data.title.toUpperCase());
              $('#images').html('<img src="/assets/img_messages/'+data.images+'" width="100%">');
              $('#desc').html(data.desc);

              $('#isinya').modal('show');

            }


          });

        $('.closedd').click(function() {
            $('.isinya').modal('hide');
        });
        localStorage.setItem($('#urgent').val(),'true');
    }

    function angka(e) {
      if (!/^[0-9]+$/.test(e.value)) {
        e.value = e.value.substring(0,e.value.length-1);
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

    $.ajax({
      type: 'GET',
      url: "{{ route('messages.count') }}",

      success: function (data) {
        $('#pesancount').html(data);

      }

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
        url: "{{ route('reedem_point.keranjang.count') }}",

        success: function (data) {
          $('#keranjangreedemcount').html(data);

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

      $.ajax({
        type: 'GET',
        url: "{{ route('xhome.countdeliveryuser') }}",

        success: function (data) {

          if(data != '0'){

            $('#transaksimenu').html('<span class="circletransaksi"><b>'+data+'</b></span>');
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

            if(data != '0'){

              $('#keranjangmenu').html('<span class="circlekeranjang"><b>'+data+'</b></span>');
            } 
            
          }

        });

        // $.ajax({
        //   type: 'GET',
        //   url: "{{ route('xhome.countdelivery') }}",

        //   success: function (data) {
            
        //   }

        // });
        
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

      if (role == '4' || role == '3'){

        swal({
            title: "Mantapp!",
            text: "Transaksi Anda Berhasil!",
            icon: "success",
        });

        setTimeout(function(){ window.location.href = '/home'; }, 1500);
      }

      

    });

  </script>

  