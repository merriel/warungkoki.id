<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Warung Koki | Belanja Nyaman Harga Bersahabat</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="QQlFHuHFdZ-Lo_AjAaYiJCElYinurhfwQiBVsEG5Xjc" />
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
    @if(Auth::user() != null)
    <input type="hidden" class="form-control" id="role" value="{{ Auth::user()->role_id }}">
    <input type="hidden" class="form-control" id="userid" value="{{ Auth::user()->id }}">
    @else
        <input type="hidden" class="form-control" id="role" value="0">
        <input type="hidden" class="form-control" id="userid" value="0">
    @endif
</head>
<style type="text/css">
    
    .logo{

        position: absolute;
        top: 250px;
        z-index: 1;
        margin: auto;

    }

</style>
<body style="background-color: #feac3b;">
    <div class="limiter">
        <div class="koperasi-login100" >
            <div class="wrap-login100 p-b-30">
                <div class="logo" align="center">
                    <img src="{{ asset ('assets/splash/images/koki.png') }}" width="88%" alt="AVATAR" align="center">
                </div>
                <span class="login100-form-title p-t-20 p-b-45"> 
                          
                </span>
            </div>
        </div>
    </div>

    <!-- <div class="limiter" id="img1">
        <div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-07.jpg') }}');"> 
        </div>
    </div>
    <div class="logo" >
        <table width="100%">
            <tr>
                <td align="center">
                    <img src="{{ asset ('assets/splash/images/xtom2.png') }}" width="58%">
                </td>
            </tr>
        </table>
        
    </div> -->
    
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

        var role = $('#role').val();
        var userid = $('#userid').val();

        var w = window.innerWidth;
        var h = window.innerHeight;

        if (role != '4'){

            if(w <= 1200){

                setTimeout(function(){ window.location.href = '/home3'; }, 2000);

            } else {

                setTimeout(function(){ window.location.href = '/error'; }, 2000);

            }     

        } else {

            if(w <= 1200){
                setTimeout(function(){ window.location.href = '/home'; }, 2000);
            } else{
                setTimeout(function(){ window.location.href = '/error'; }, 2000);
            }
            
        }

    });


</script>   

</body>
</html>