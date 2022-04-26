<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>IOLO-SMART | Deals & Challanges</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{ asset ('assets/splash/dist/img/favicon.png') }}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/animate/animate.css') }}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/main.css') }}">
<!--===============================================================================================-->

</head>

<body>
    <div class="limiter">
        <div class="splash-login100" >
            <div class="wrap-login100 p-t-50 p-b-200">
                <div class="logo" id="img1" align="center" style="display: block;">
                    <img src="./assets/splash/images/intro4.png" width="90%" alt="AVATAR" align="center"><br><br>
                    <h5 style="color: white;"><b>BANYAK DISKONNYA</b></h5><br>
                    <div style="color: white; font-size: 12px">Banyak Diskon Melimpah di Setiap Toko-toko Kesayangan Anda</div>
                </div>
                <div class="logo" id="img2" align="center" style="display: none;">
                    <img src="./assets/splash/images/intro2.png" width="90%" alt="AVATAR" align="center"><br><br>
                    <h5 style="color: white;"><b>DEALS & CHALLANGES</b></h5><br>
                    <div style="color: white; font-size: 12px">Terdapat Deals & Challanges yang Menarik dan Lebih Murah</div>
                </div>
                <div class="logo" id="img3" align="center" style="display: none;">
                    <img src="./assets/splash/images/intro3.png" width="90%" alt="AVATAR" align="center"><br><br>
                    <h5 style="color: white;"><b>MUDAH DIGUNAKAN</b></h5><br>
                    <div style="color: white; font-size: 12px">Mudah dalam penggunaan, memiliki user interface yang menarik</div>
                </div>
                <div class="logo" id="img4" align="center" style="display: none;">
                    <img src="./assets/splash/images/intro1.png" width="90%" alt="AVATAR" align="center"><br><br>
                    <h5 style="color: white;"><b>PEMBAYARAN MUDAH</b></h5><br>
                    <div style="color: white; font-size: 12px">Pembayaran Mudah, ada banyak metode pembayaran yang dapat digunakan</div>
                </div>
            </div>
        </div>
    </div>
</body>

<div class="footer">
    <div class="container-login100-form-btn p-t-10" id="button1" style="display: block;">
        <button class="masuk100-form-btn" id="next1-submit">
            Lanjut
        </button>
    </div>

    <div class="container-login100-form-btn p-t-10" id="button2" style="display: none;">
        <button class="masuk100-form-btn" id="next2-submit">
            Lanjut
        </button>
    </div>

    <div class="container-login100-form-btn p-t-10" id="button3" style="display: none;">
        <button class="masuk100-form-btn" id="next3-submit">
            Lanjut
        </button>
    </div>

    <div class="container-login100-form-btn p-t-10" id="button4" style="display: none;">
        <button class="hijau100-form-btn" id="selesai-submit">
            Selesai
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

        $("#img3").attr("style","display: none;");
        $("#img4").attr("style","display: block;");
        $("#button3").attr("style","display: none;");
        $("#button4").attr("style","display: block;");

    });

    $('#selesai-submit').on('click', function () {

         window.location.href = '/home';

    });

</script>
</body>
</html>