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

<br><br><br>

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

  