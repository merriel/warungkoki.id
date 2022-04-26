<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Warung Koki LOGIN</title>
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
        top: 10px;
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
    	<div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/loginramadhan.jpg') }}');"> 
	    </div>
    </div>
    <!-- <div class="logo">
        <img src="{{ asset ('assets/splash/images/koki_putih.png') }}" width="60%">
    </div> -->
    <!-- <div class="petugas">
       <table width="100%">
           <tr>
            <td align="center">
                <a href="/loginiolo" style="color: white;font-family: Montserrat-Bold; font-size: 13px;"><u>Masuk Sebagai Petugas</u></a>
            </td>
           </tr>
       </table> 
    </div> -->
</body>

<div class="footer" style="height: 100px;">
    <div class="container-login100-form-btn p-t-10" id="button1" style="display: block;">
        
        <a href="{{ url('auth/google') }}?page=1">
            <button class="google100-form-btn" id="next1-submit">
                <img src="{{ asset ('assets/content/img/theme/google.png') }}" width="10%"> &nbsp;&nbsp;Login with Google
            </button>
        </a>
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
    

</body>
</html>