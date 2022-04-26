<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warungkoki Petugas LOGIN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset ('assets/splash/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/bootstrap/css/bootstrap.min.css') }}">

	  <link rel="manifest" href="/manifest.json">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/main.css') }}">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="login-login100" style="background-image: url('{{ asset ('assets/splash/images/img-06.jpg') }}');">
			<div class="wrap-login100 p-t-60 p-b-30" style="padding-top: 10px;">

				<span class="login100-form-title p-b-45">
					<img width="85%" src="{{ asset ('assets/splash/images/koki_putih.png') }}" alt="AVATAR">
				</span>

				@error('username')
                    <div class="alert alert-danger" role="alert" align="center" style="padding-top: 0.5rem;padding-bottom: 0.5rem; font-size: 12px;">
			            <strong>{{ $message }}</strong>
			         </div>
                @enderror
                @error('password')
                    <div class="alert alert-danger" role="alert" align="center" style="padding-top: 0.5rem;padding-bottom: 0.5rem; font-size: 12px;">
			            <strong>{{ $message }}</strong>
			         </div>
                @enderror
				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
					@csrf
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="email" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="babantos100-form-btn" id="login">
							Login
						</button>
					</div>
					
					
				</form>
				<div class="petugas" style="padding-top: 12px;">
			       <table width="100%">
			           <tr>
			            <td align="center">
			                <a href="/login" style="color: white;font-family: Montserrat-Bold; font-size: 13px;"><u>Kembali</u></a>
			            </td>
			           </tr>
			       </table> 
			    </div>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset ('assets/splash/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset ('assets/splash/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset ('assets/splash/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset ('assets/splash/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset ('assets/splash/js/main.js') }}"></script>

	<script type="text/javascript">
		
		// $('#login').on('click', function () {

	 //        window.location.href = '/mobile/homes';

	 //    });

	    function Google(){

	    	window.location.href = '/mobile/auth/google';

	    }

	</script>

</body>
</html>