<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>TomXperience SIAGA</title>
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
<!--===============================================================================================-->

</head>
<style type="text/css">
    .logo{

        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1;

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


</style>
    
<body>
    <div class="limiter" id="img1">
        <div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-01.jpg') }}');">
            <div class="wrap-login100 p-t-50 p-b-300" style="bottom: 2px;padding-top: 20rem;">
                <div style="color: white;font-size: 27px;font-weight: bold;">
                    Membantu Anda
                </div>
                <div style="color: white; font-size: 12px">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati</div>
            </div>   
        </div>
    </div>
    <div class="limiter" id="img2" style="display: none;">
        <div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-02.jpg') }}');">
            <div class="wrap-login100 p-t-50 p-b-300" style="bottom: 2px;padding-top: 20rem;">
                <div style="color: white;font-size: 27px;font-weight: bold;">
                    Kehabisan Bensin?
                </div>
                <div style="color: white; font-size: 12px">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati</div>
            </div>   
        </div>
    </div>

    <div class="limiter" id="img3" style="display: none;">
        <div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-03.jpg') }}');">
            <div class="wrap-login100 p-t-50 p-b-300" style="bottom: 2px;padding-top: 20rem;">
                <div style="color: white;font-size: 27px;font-weight: bold;">
                    Melayani 24 Jam
                </div>
                <div style="color: white; font-size: 12px">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati</div>
            </div>   
        </div>
    </div>

</body>

<div class="footer">
    <div class="container-login100-form-btn p-t-10" id="button1" style="display: block;">
        <button class="google100-form-btn" id="next1-submit">
            NEXT
        </button>
    </div>

    <div class="container-login100-form-btn p-t-10" id="button2" style="display: none;">
        <button class="google100-form-btn" id="next2-submit">
            NEXT
        </button>
    </div>

    <div class="container-login100-form-btn p-t-10" id="button3" style="display: none;">
        <button class="hijau100-form-btn" id="next3-submit">
            FINISH
        </button>
    </div>

</div>
    
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

    $('#next1-submit').on('click', function () {

        $("#img1").attr("style","display: none;");
        $("#img2").attr("style","display: block;");
        $("#button1").attr("style","display: none;");
        $("#button2").attr("style","display: block;");
    });

    $('#next2-submit').on('click', function () {

        $("#img2").attr("style","display: none;");
        $("#img3").attr("style","display: block;");
        $("#button2").attr("style","display: none;");
        $("#button3").attr("style","display: block;");

    });

    $('#next3-submit').on('click', function () {

        window.location.href = '/siaga/aksi';

    });


</script>

</body>
</html>