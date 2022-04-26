<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Cube Work + | Working Space</title>
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
        <div class="workingspace-login100" >
            <div class="wrap-login100 p-t-90 p-b-30">
                <div class="logo" align="center" style="display: block;">
                    <img src="{{ asset ('assets/content/img/theme/cubework.jpg') }}" width="250px" alt="AVATAR" align="center">
                </div>
                <div id="loader" style="display: none;" align="center">
                    <img src="assets/splash/images/balls.gif" width="100px" align="center">
                </div>
                    <span class="login100-form-title p-t-20 p-b-45">                 
                    </span>
            </div>
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

    $(function() {

        // setTimeout(Loading, 4000);

        setTimeout(function(){ window.location.href = '/working-space/home'; }, 2000);

    });

    // function Loading(){

    //     $("#loader").attr("style","display: block;");
    //     $(".logo").attr("style","display: none;");
    // }

</script>   

</body>
</html>