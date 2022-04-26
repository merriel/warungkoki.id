<script type="text/javascript">

	function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
	
	$('#datamaster').on('click', function () {

		$('#homes').attr('style', 'display: none;');
		$('#master').attr('style', 'display: block;');

	});

	$('#qty_0').on('keyup', function () {

    	$('#qty_0').val(formatRupiah($(this).val()));

        var vals2 = $(this).val().split('.').join('');
        $('#qty2_0').val(vals2);

   	});

   	$('#qtyreward_0').on('keyup', function () {

    	$('#qtyreward_0').val(formatRupiah($(this).val()));

        var vals2 = $(this).val().split('.').join('');
        $('#qtyreward2_0').val(vals2);

   	});

   	$('#value').on('keyup', function () {

    	$('#value').val(formatRupiah($(this).val(), 'Rp. '));

    	var vals = $(this).val().replace('Rp. ','');
        var vals2 = vals.split('.').join('');
        $('#value2').val(vals2);

   	});

	$('#home').on('click', function () {

		$('#homes').attr('style', 'display: block;');
		$('#master').attr('style', 'display: none;');

	});

	$('#mypost').on('click', function () {

		setTimeout(function(){ window.location.href = 'mypost'; }, 10);

	});

	$('#newpost').on('click', function () {

		setTimeout(function(){ window.location.href = 'newpost'; }, 10);

	});

	$('#trans').on('click', function () {

		setTimeout(function(){ window.location.href = 'transaksi'; }, 10);

	});


	$("#uploadpost").on("change", function() {

		$('.loading').attr('style','display: block');

		var formData = new FormData();
        formData.append('file', $('#uploadpost')[0].files[0]);

		$.ajax({
            url: "{{ route('uploadpost') }}",
            method:"POST",
            data: formData,
            headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,

            success:function(data) {


            	$('#images').attr('src','./assets/img_post/'+data.img+'');
            	$('#id').val(data.id);
            	$('#imgs').val('/assets/img_post/'+data.img);
            	$('#postimg').modal({backdrop: 'static', keyboard: false})
            	$('.loading').attr('style','display: none');
            	$('#postimg').modal('show');

            }
        });

	});

	$('.modal-footer').on('click', '#cancel', function() {

		$('#cancel_confirm').modal('show');
	});

	$('.modal-footer').on('click', '#yakin', function() {

		$('#cancel_confirm').modal('hide');

		$('#postimg').modal('show');

		$('.loading').attr('style','display: block');

		$.ajax({
	       type: 'POST',
	       url: "{{ route('cancelimages') }}",
	       data: {
	            '_token': $('input[name=_token]').val(),
	            'id': $('#id').val(),
	            'imgs': $('#imgs').val(),
	        },
	       success: function(data) {

	       		setTimeout(function(){ window.location.href = 'outlet'; }, 1500);

	       }
	   });
		
	});

	var tambah = 0;
	$(document).on('click', '.add-product', function() {   

	    tambah++; 

	    var row_tambah = 	'<tr class="baris" id="row_'+tambah+'">'+
		                        '<td><select class="form-control prods ada" id="produk_'+tambah+'"></select></td>'+
		                        '<td><input type="text"  class="form-control" placeholder="Value" id="qty_'+tambah+'"><input type="hidden" class="form-control ada prodqty" id="qty2_'+tambah+'"></td>'+
		                        '<td style="padding-top: 24px;"><i style="font-size: 20px;" class="fa fa-times" onclick="RemoveProduk('+tambah+');"></i></td>'+
	                    	'</tr>';

	    jQuery('#nambahproduk').append(row_tambah);

	    $.ajax({
	        url: "{{ route('getproduct2') }}",
	        type: "GET",
	        dataType: "json",
	        success:function(data) {
	            var no = -1;
	            $.each(data, function() {
	                no++;
	                var id = data[no]['id'];
	                var name = data[no]['name'];

	                $('#produk_'+tambah+'').append('<option value="'+ id +'">'+ name +'</option>');

	            });
	        }
	    });

	    $('#qty_'+tambah).on('keyup', function () {

	    	$('#qty_'+tambah).val(formatRupiah($(this).val()));

            var vals2 = $(this).val().split('.').join('');
            $('#qty2_'+tambah).val(vals2);

	    });


	});

	function RemoveProduk(rnum) {
	    jQuery('#row_'+rnum).remove();

	}

	function Check(id){

		$('#wil_'+id).attr('class', 'alert2 alert-success');
		$('#check_'+id).attr('onclick', 'CheckRemove('+id+')');
		$('#val_'+id).val(id);
	}

	function CheckRemove(id){

		$('#wil_'+id).attr('class', 'alert2 alert-default');
		$('#check_'+id).attr('onclick', 'Check('+id+')');
		$('#val_'+id).val('');
	}

	$("#type").on("change", function() {

		var value = $(this).val();

		if (value == 'Deals'){

			$('#challange').attr('style', 'display: none;');
			$('.products').attr('style', 'display: none;');
			$('.challanges').attr('style', 'display: none;');
			$('.deals').attr('style', 'display: block;');
			$('.contents').attr('style', 'display: block;');

		} else if (value == 'Products') {

			$('.deals').attr('style', 'display: none;');	
			$('#challange').attr('style', 'display: none;');
			$('.challanges').attr('style', 'display: none;');
			$('.products').attr('style', 'display: block;');
			$('.contents').attr('style', 'display: block;');

		} else {
	
			$('.products').attr('style', 'display: none;');
			$('.deals').attr('style', 'display: none;');
			$('#challange').attr('style', 'display: block;');
			$('.challanges').attr('style', 'display: block;');
			$('.contents').attr('style', 'display: block;');
			$('.global').attr('style', 'display: block;');
			$('#perproduk').attr('style', 'display: none;');

		}

	});

	$("#jenis").on("change", function() {

		var value = $(this).val();

		if(value == 'global'){

			$('.global').attr('style', 'display: block;');
			$('#perproduk').attr('style', 'display: none;');

		} else {

			$('.global').attr('style', 'display: none;');
			$('#perproduk').attr('style', 'display: block;');

		}

		

	});

	var nambah = 0;
	$(document).on('click', '.add-reward', function() {   

	    nambah++; 

	    var row_nambah = 	'<tr class="baris" id="row_'+nambah+'">'+
		                        '<td><select class="form-control reward" id="reward_'+nambah+'"></select></td>'+
		                        '<td><input type="text" class="form-control qtyreward" placeholder="Qty" id="qtyreward_'+nambah+'"><input type="hidden" class="form-control qtyreward" id="qtyreward2_'+nambah+'"></td>'+
		                        '<td style="padding-top: 24px;"><i style="font-size: 20px;" class="fa fa-times" onclick="RemoveReward('+nambah+');"></i></td>'+
	                    	'</tr>';

	    jQuery('#nambahreward').append(row_nambah);

	    $.ajax({
	        url: "{{ route('getproduct2') }}",
	        type: "GET",
	        dataType: "json",
	        success:function(data) {
	            var no = -1;
	            $.each(data, function() {
	                no++;
	                var id = data[no]['id'];
	                var name = data[no]['name'];

	                $('#reward_'+nambah+'').append('<option value="'+ id +'">'+ name +'</option>');

	            });
	        }
	    });

	    $('#qtyreward_'+nambah).on('keyup', function () {

	    	$('#qtyreward_'+nambah).val(formatRupiah($(this).val()));

            var vals2 = $(this).val().split('.').join('');
            $('#qtyreward2_'+nambah).val(vals2);

	    });


	});

	function RemoveReward(rnum) {
	    jQuery('#row_'+rnum).remove();

	}

	$('.modal-footer').on('click', '#simpan', function() {

		$('.loading').attr('style','display: block');

		 var empty = false;
        $('.ada').each(function() {
        if ($(this).val() == '') {
                empty = true;
            }
        });

        if (empty) { 

            swal("Isi Semua Isian!", {
                icon: "error",
                buttons: false,
                timer: 2000,
            });

            $('.loading').attr('style','display: none');
            
        } else {

        	var type = $('#type').val();
        	var jenis = $('#jenis').val();

        	var product = [];
        	var prodqty = [];

            $('.prods').each(function(){
                product.push($(this).val());
            });

            $('.prodqty').each(function(){
                prodqty.push($(this).val());
            });

            if(type == 'Challange'){

            	var reward = [];
            	var qtyreward = [];

            	$('.reward').each(function(){
	                reward.push($(this).val());
	            });

	            $('.qtyreward').each(function(){
	                qtyreward.push($(this).val());
	            });

	            if(jenis == 'global'){

	            	var prod_id = [];

		            $('.prod_id:checked').each(function(){
		                prod_id.push($(this).val());
		            });

	            	$.ajax({
		                type: 'POST',
		                url: "{{ route('simpanpost') }}",
		                data: {
		                    '_token': $('input[name=_token]').val(),
		                    'type': $('#type').val(),
		                    'name': $('#title').val(),
		                    'dari': $('#dari').val(),
		                    'sampai': $('#sampai').val(),
		                    'banyaknya': $('#max').val(),
		                    'desc': $('#desc').val(),
		                    'jenis': $('#jenis').val(),
		                    'prod_id': prod_id,
		                    'value': $('#value2').val(),
		                    'reward': reward,
		                    'qtyreward': qtyreward,
		                    'img_id': $('#id').val(),
		                    'dari_reward': $('#darireward').val(),
		                    'sampai_reward': $('#sampaireward').val(),
		                    },
		                success: function(data) {

		                	swal({
			                    title: "Berhasil",
			                    text: "Post Berhasil Tersimpan!",
			                    icon: "success",
			                    buttons: false,
			                    timer: 2000,
			                });
			                setTimeout(function(){ window.location.href = 'mypost'; }, 1500);


		                }
		            });

	            } else {

	            	$.ajax({
		                type: 'POST',
		                url: "{{ route('simpanpost') }}",
		                data: {
		                    '_token': $('input[name=_token]').val(),
		                    'type': $('#type').val(),
		                    'name': $('#title').val(),
		                    'dari': $('#dari').val(),
		                    'sampai': $('#sampai').val(),
		                    'banyaknya': $('#max').val(),
		                    'desc': $('#desc').val(),
		                    'jenis': $('#jenis').val(),
		                    'reward': reward,
		                    'qtyreward': qtyreward,
		                    'img_id': $('#id').val(),
		                    'dari_reward': $('#darireward').val(),
		                    'sampai_reward': $('#sampaireward').val(),
		                    'product': product,
		                    'prodqty': prodqty,
		                    },
		                success: function(data) {

		                	swal({
			                    title: "Berhasil",
			                    text: "Post Berhasil Tersimpan!",
			                    icon: "success",
			                    buttons: false,
			                    timer: 2000,
			                });
			                setTimeout(function(){ window.location.href = 'mypost'; }, 1500);


		                }
		            });

		        }

	            
            
            } else if(type == 'Deals'){

            	$.ajax({
	                type: 'POST',
	                url: "{{ route('simpanpost') }}",
	                data: {
	                    '_token': $('input[name=_token]').val(),
	                    'type': $('#type').val(),
	                    'name': $('#title').val(),
	                    'dari': $('#dari').val(),
	                    'sampai': $('#sampai').val(),
	                    'kategori': $('#kategori').val(),
	                    'banyaknya': $('#max').val(),
	                    'harga_act': $('#harga_act').val(),
	                    'harga_crt': $('#harga_crt').val(),
	                    'desc': $('#desc').val(),
	                    'product': product,
	                    'prodqty': prodqty,
	                    'img_id': $('#id').val(),
	                    },
	                success: function(data) {

	                	swal({
		                    title: "Berhasil",
		                    text: "Post Berhasil Tersimpan!",
		                    icon: "success",
		                    buttons: false,
		                    timer: 2000,
		                });
	                	setTimeout(function(){ window.location.href = 'mypost'; }, 1500);

	                }
	            });

            } else {

            	$.ajax({
	                type: 'POST',
	                url: "{{ route('simpanpost') }}",
	                data: {
	                    '_token': $('input[name=_token]').val(),
	                    'type': $('#type').val(),
	                    'name': $('#title').val(),
	                    'product_id': $('#produk_id').val(),
	                    'deliver': $('#deliver').val(),
	                    'po': $('#po').val(),
	                    'kategori': $('#kategori').val(),
	                    'banyaknya': $('#stok').val(),
	                    'harga_act': $('#harga_act').val(),
	                    'desc': $('#desc').val(),
	                    'img_id': $('#id').val(),
	                    },
	                success: function(data) {

	                	swal({
		                    title: "Berhasil",
		                    text: "Post Berhasil Tersimpan!",
		                    icon: "success",
		                    buttons: false,
		                    timer: 2000,
		                });
	                	setTimeout(function(){ window.location.href = 'mypost'; }, 1500);

	                }
	            });

            }




        }
	});
</script>