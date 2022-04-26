<script type="text/javascript">

function Actions(id){

    $('#content_'+id).attr("style","display: block;");
    $('#data_'+id).attr("onclick","Tutup("+id+")");

}

function Tutup(id){

    $('#content_'+id).attr("style","display: none;");
    $('#data_'+id).attr("onclick","Actions("+id+")");

}
	
$('#tambahprod').on('click', function () {

	$('#tambah_produk').modal('show');
});

$(document).on('click', '.deleteproduct', function() {

	$('#id').val($(this).data('id'));
	$('#hapus_produk').modal('show');
});

$(document).on('click', '.editproduct', function() {
    $('#productid').val($(this).data('id'));
    $('#productname').val($(this).data('name'));
    $('#productprice').val($(this).data('price'));
    $('#edit_produk').modal('show');
});

$('.modal-footer').on('click', '#ubah', function() {

	var empty = false;
    $('input#productname').each(function() {
        if ($(this).val() == '') {
            empty = true;
        }
    });
    if (empty) { 
        swal({
            text: "Isian Tidak Boleh Kosong!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

    } else {

		$.ajax({
            type: 'POST',
            url: "{{ route('updateproduct') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#productname').val(),
                'id': $('#productid').val(),
                'harga': $('#productprice').val(),
                },

            success: function(data) {


        		swal({
                    title: "Berhasil",
                    text: "Produk Berhasil Diubah!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                setTimeout(function(){ window.location.href = 'produk'; }, 1500);


            }

        });

	}

});

$('.modal-footer').on('click', '#delete', function() {

	$.ajax({
       type: 'POST',
       url: "{{ route('hapusproduct') }}",
       data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#id').val()
        },
       success: function(data) {

	        swal("Data berhasil terhapus!", {
               icon: "success",
               buttons: false,
               timer: 2000,
	        });
        	setTimeout(function(){ window.location.href = 'produk'; }, 1500);
       }
   });

});

$('#simpan').on('click', function () {

	var empty = false;
    $('input.harus').each(function() {
        if ($(this).val() == '') {
            empty = true;
        }
    });
    if (empty) { 
        swal({
            text: "Isian Tidak Boleh Kosong!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

    } else {

		$.ajax({
            type: 'POST',
            url: "{{ route('simpanproduct') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#names').val(),
                'garansi': $('#garansi_id').val(),
                'harga': $('#harga').val()
                },

            success: function(data) {

            	if (data == '1'){

            		swal({
	                    title: "Gagal",
	                    text: "Produk Sudah Ada!",
	                    icon: "error",
	                    buttons: false,
	                    timer: 2000,
	                });

            	} else {

            		swal({
	                    title: "Berhasil",
	                    text: "Produk Berhasil Tersimpan!",
	                    icon: "success",
	                    buttons: false,
	                    timer: 2000,
	                });
	                setTimeout(function(){ window.location.href = 'produk'; }, 1500);

            	}

            }

        });

	}
});

</script>