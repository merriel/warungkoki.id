<script type="text/javascript">

function Actions(id){

    $('#content_'+id).attr("style","display: block;");
    $('#data_'+id).attr("onclick","Tutup("+id+")");

}

function Tutup(id){

    $('#content_'+id).attr("style","display: none;");
    $('#data_'+id).attr("onclick","Actions("+id+")");

} 

$('#tambahgaransi').on('click', function () {

	$('#tambah_garansi').modal('show');

});

$(document).on('click', '.deletegaransi', function() {

	$('#id').val($(this).data('id'));
	$('#hapus_garansi').modal('show');
});

$('.modal-footer').on('click', '#delete', function() {

	$.ajax({
       type: 'POST',
       url: "{{ route('hapusgaransi') }}",
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
        	setTimeout(function(){ window.location.href = 'garansi'; }, 1500);
       }
   });

});

$('#simpan').on('click', function () {

	var empty = false;
    $('input.garansi, textarea.garansi').each(function() {
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
            url: "{{ route('simpangaransi') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#name').val(),
                'waktu': $('#waktu').val(),
                'types': $('#types').val(),
                'ket': $('#ket').val()
            },

            success: function(data) {

        		swal({
                    title: "Berhasil",
                    text: "Garansi Berhasil Tersimpan!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });

                setTimeout(function(){ window.location.href = 'garansi'; }, 1500);


            }

        });

	}
});

$(document).on('click', '.editgaransi', function() {

    $('#idedit').val($(this).data('id'));
    $('#nameedit').val($(this).data('name'));
    $('#waktuedit').val($(this).data('jangka'));
    $('#typesedit').val($(this).data('waktu'));
    $('textarea#ketedit').val($(this).data('text'));

    $('#edit_garansi').modal('show');
});

$('.modal-footer').on('click', '#ubah', function() {

	var empty = false;
    $('input#garansiedit, textarea#garansiedit').each(function() {
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
            url: "{{ route('updategaransi') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#nameedit').val(),
                'waktu': $('#waktuedit').val(),
                'types': $('#typesedit').val(),
                'ket': $('#ketedit').val(),
                'id': $('#idedit').val(),
                },

            success: function(data) {

        		swal({
                    title: "Berhasil",
                    text: "Garansi Berhasil Diubah!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                setTimeout(function(){ window.location.href = 'garansi'; }, 1500);

            }

        });

	}

});

</script>