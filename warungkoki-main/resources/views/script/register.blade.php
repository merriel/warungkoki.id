<script type="text/javascript">

	$('#token').on('keyup', function () {

		var token = $(this).val();

		if(token.length > 6){

			swal({
	            title: "Perhatikan!",
	            text: "Token Maksimal 6 Karakter!",
	            icon: "warning",
	            buttons: false,
	            timer: 2000,
	        });

	        var hasil = token.substr(0, 6);

	        $('#token').val(hasil);

		} else if(token.length == 6){

			$('#valtoken').attr("class","form-group has-success");

		} else if(token.length < 6){

			$('#valtoken').attr("class","form-group has-danger");

		}

	});

	$('#nama').on('keyup', function () {

		var value = $(this).val();

		if(value.length >= 1){
			$('#valnama').attr("class","form-group mb-3 has-success");
		} else {
			$('#valnama').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#email').on('keyup', function () {

		var value = $(this).val();

		if(value.length >= 1){
			$('#valemail').attr("class","form-group mb-3 has-success");
		} else {
			$('#valemail').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#clubsmart').on('keyup', function () {

		var value = $(this).val();

		if(value.length >= 1){
			$('#valclubsmart').attr("class","form-group mb-3 has-success");
		} else {
			$('#valclubsmart').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#nohp').on('keyup', function () {

		var value = $(this).val();

		if(value.length >= 1){
			$('#valnohp').attr("class","form-group mb-3 has-success");
		} else {
			$('#valnohp').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#password').on('keyup', function () {

		var value = $(this).val();

		if(value.length >= 7){
			$('#valpassword').attr("class","form-group mb-3 has-success");
		} else {
			$('#valpassword').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#confirm-password').on('keyup', function () {

		var value = $(this).val();
		var value2 = $('#password').val();

		if(value2.length >= 7){
			if(value == value2){
				$('#valpassword2').attr("class","form-group mb-3 has-success");
			} else {
				$('#valpassword2').attr("class","form-group mb-3 has-danger");
			}
		} else {
			$('#valpassword2').attr("class","form-group mb-3 has-danger");
		}

	});

	$('#provinsi').on('change', function () {

		var value = $(this).val();

		if(value != ""){
			$('#valprovinsi').attr("class","form-group mb-3 has-success");
		} else {
			$('#valprovinsi').attr("class","form-group mb-3 has-danger");
		}

		$.ajax({
	        url: "{{ route('register.ambilkabkot') }}",
	        type: "POST",
	        data: {
	            '_token': $('input[name=_token]').val(),
	            'id': $(this).val(),
	        },
	        success:function(data) {

	            var no = -1;
	            var content_data ="";
	            content_data += "<option value=''>Pilih Kota/Kabupaten</option>";
	            $.each(data, function() {

	                no++;
	                var name = data[no]['name'];
	                var id = data[no]['id'];

	                content_data += "<option value="+id+">"+name+"</option>";

	            });

	            $('#kotakab').html(content_data);
	        }
    	});

	});

	$('#kotakab').on('change', function () {

		var value = $(this).val();

		if(value.length >= 1){
			$('#valkotakab').attr("class","form-group mb-3 has-success");
		} else {
			$('#valkotakab').attr("class","form-group mb-3 has-danger");
		}

	});
	
	$('#daftar').on('click', function () {

		$('.loading').attr('style','display: block;');

		var data = {
            _token:$('input[name=_token]').val(),
            nama: $('#nama').val(),
            email: $('#email').val(),
            nohp: $('#nohp').val(),
            password: $('#password').val(),
            token: $('#token').val(),
            provinsi: $('#provinsi').val(),
            kabkot: $('#kotakab').val(),
            clubsmart: $('#clubsmart').val(),
        };

        var empty = false;
        $('input.register, select.register').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });
        if (empty) { 
            swal({
	            title: "Error!",
	            text: "Pastikan Semua Data Terisi!",
	            icon: "error",
	            buttons: false,
	            timer: 2000,
	        });

	        $('.loading').attr('style','display: none;');


	    } else {

	    	var pass1 = $('#password').val();
	    	var pass2 = $('#confirm-password').val();

	    	if(pass1.length >= '7'){

		    	if(pass1 != pass2){

		    		swal({
			            title: "Error!",
			            text: "Confirm Password dangan Password Tidak Sama!",
			            icon: "error",
			            buttons: false,
			            timer: 2000,
			        });

			        $('.loading').attr('style','display: none;');

		    	} else {

			    	$.ajax({
		                type: "post",
		                url: "{{ route('registersubmit') }}",
		                data: data,
		                cache: false,
		                success: function (data)
		                {
		                	swal({
					            title: "Berhasil!",
					            text: "Daftar Berhasil, Segera Lakukan Konfirmasi Melalui E-mail Anda!",
					            icon: "success",
					            buttons: false,
					            timer: 2000,
					        });
					        setTimeout(function(){ window.location.href='login'; }, 500);

		                }

		            });

			    }

			} else {

				swal({
		            title: "Error!",
		            text: "Password Harus Lebih dari 7 Karakter!",
		            icon: "error",
		            buttons: false,
		            timer: 2000,
		        });

		        $('.loading').attr('style','display: none;');

			}

	    }

	});

</script>