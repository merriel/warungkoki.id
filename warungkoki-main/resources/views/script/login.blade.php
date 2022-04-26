<script type="text/javascript">


	$('#logins').on('click', function () {

        var data = {
            _token:$('input[name=_token]').val(),
            username: $('#username').val(),
            password: $('#password').val()
        };

        var empty = false;
        $('input.login').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });
        if (empty) { 
            swal({
	            title: "Tidak bisa masuk!",
	            text: "Isi semua isian!",
	            icon: "error",
	            buttons: false,
	            timer: 2000,
	        });

	    } else {

	    	// Ajax Post 
            $.ajax({
                type: "post",
                url: "{{ route('login_submit') }}",
                data: data,
                cache: false,
                success: function (data)
                {
                	if (data.status == 'success'){

                        if(data.role == '4'){

                            if(data.email_confirm == null){

                                swal({
                                      title: "Sign In Failed!",
                                      text: "Harap Konfirmasi Email Terlebih Dahulu!",
                                      icon: "error",
                                      buttons: false,
                                      timer: 2000,
                                  });

                                setTimeout(function(){ window.location.href='/login/logout'; }, 1500);

                            } else {

                                swal("Sign In Success!", {
                                    icon: "success",
                                    buttons: false,
                                    timer: 2000,
                                });

                                setTimeout(function(){ window.location.href='/'; }, 1500);

                            }

                        } else {

                            swal("Sign In Success!", {
                                icon: "success",
                                buttons: false,
                                timer: 2000,
                            });

                            setTimeout(function(){ window.location.href='/'; }, 1500);

                        }

                    } else if (data.status == 'error'){

                        swal("Username or Password Salah!", {
	                        icon: "error",
	                        buttons: false,
	                        timer: 2000,
	                    });


                    }

                }
            });

	    }
	});


</script>