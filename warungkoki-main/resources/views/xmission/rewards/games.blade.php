<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>TomXperience GAMES</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{ asset ('assets/icon/72x72.png') }}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link href="{{ asset ('assets/content/css/nav-footer.css') }}" rel="stylesheet" />
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/animate/animate.css') }}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" type="text/css" href="/assets/content/css/loading.css">
<!--===============================================================================================-->

</head>
<div class="loading" style="display: none;">Loading&#8230;</div>
<style type="text/css">
    .logo{

        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1;

    }

    .contentss{

        position: absolute;
        top: 100px;
        left: 20px;
        z-index: 1;
        color: white;
        font-size: 16px;
        font-weight: bold;

    }

    .petugas{

        font-family: Montserrat-Bold;
        font-size: 13px;
        position: absolute;
        bottom: 30px;
        left: 22px;
        z-index: 1;
        color: white;
        width: 100%;
    }

    .swal-modal .swal-text {
      text-align: center;
  }


</style>
   {{ csrf_field() }} 
<body>
    <div class="limiter" id="img1">
      <div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-11.jpg') }}');"> 
          
          <br><br><br><br>
          <div class="row">

            @foreach($hadiah as $h)
            <div class="col-4" style="padding-bottom: 12px;">
              <div class="card shadow pilihan" style="border-radius: 1rem;height: 123px;" onclick="Pilih({{ $h->id }})">
                <div class="card-body tomall" id="tom_{{ $h->id }}" align="center" style="padding: 0.8rem;">
                  <img src="{{ asset ('assets/splash/images/newtom.png') }}" width="100%">
                </div>
                <div class="card-body all" id="hadiah_{{ $h->id }}" align="center" style="padding: 0.8rem;display: none;">
                  <img src="/assets/img_hadiah/{{ $h->img }}" width="100%">
                </div>
              </div>
            </div>
            @endforeach
          </div>
          
      </div>
    </div>
    <div class="logo" style="font-size: 12px;color: white;">
        <img src="{{ asset ('assets/splash/images/newtom2.png') }}" width="40%"> &nbsp; Pilih Kotak Dibawah ini :
    </div>
    <input type="hidden" id="uuid" value="{{ $uuid }}">
</body>

    
<!--===============================================================================================-->  
    <script src="{{ asset ('assets/splash/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset ('assets/splash/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset ('assets/splash/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!--===============================================================================================-->
    <script src="{{ asset ('assets/splash/js/main.js') }}"></script>
<!--===============================================================================================-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    

    <script type="text/javascript">
      
      function Pilih(id){
          
        $('.pilihan').attr("onclick","");
        $('#hadiah_'+id).attr("style","display:block;padding: 0.8rem 0rem 0rem 0rem;");
        $('#tom_'+id).attr("style","display:none;padding: 0.8rem 0rem 0rem 0rem;");
        

        setTimeout(function(){ 

          $('.all').attr("style","display:block;padding: 0.8rem 0rem 0rem 0rem;");
          $('.tomall').attr("style","display:none;padding: 0.8rem 0rem 0rem 0rem;");

          $('.loading').attr('style','display: block');


         }, 2500);
         

        setTimeout(function(){ 

          $.ajax({
           type: 'POST',
           url: "{{ route('xmission.gethadiah') }}",
           data: {
                '_token': $('input[name=_token]').val(),
                'id': id,
                'uuid': $('#uuid').val(),
            },
           success: function(data) {

            swal({
                title: "Selamat!!",
                text: "Anda Mendapatkan"+data,
                icon: "success",
                buttons: false,
                timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/xmission/reward'; }, 4000);


           }

         });


        }, 3500);


        



      }

    </script>

</body>
</html>