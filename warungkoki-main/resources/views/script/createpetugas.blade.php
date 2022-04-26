<script type="text/javascript">

function Aksi(id){

    $('#content_'+id).attr("style","display: block;");
    $('#data_'+id).attr("onclick","Ditutup("+id+")");

}

function Ditutup(id){

    $('#content_'+id).attr("style","display: none;");
    $('#data_'+id).attr("onclick","Aksi("+id+")");

}

$(document).on('click', '.deletepetugas', function() {

    $('#id').val($(this).data('id'));

    $('#hapus_petugas').modal('show');
});

$('.modal-footer').on('click', '#delete', function() {

    $.ajax({
       type: 'POST',
       url: "{{ route('hapuspetugas') }}",
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
            setTimeout(function(){ window.location.href = '/principle/createpetugas'; }, 1500);
       }
   });

});

$('#tambahpetugas').on('click', function () {

    $('#tambah_petugas').modal('show');
});

$('#simpan').on('click', function () {

    var empty = false;
    $('input.petugas, textarea.petugas, select.petugas').each(function() {
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
            url: "{{ route('simpanpetugas') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#name').val(),
                'pass': $('#pass').val(),
                'jenkel': $('#jenkel').val(),
                'cabang': $('#cabang').val(),
                'tgl_lhr': $('#tgl_lhr').val(),
                'no_hp': $('#nohp').val(),
                'alamat': $('#alamat').val(),
                'username': $('#username').val()
            },

            success: function(data) {

                if (data == '1'){

                    swal({
                        title: "Gagal",
                        text: "Petugas Sudah Ada!",
                        icon: "error",
                        buttons: false,
                        timer: 2000,
                    });

                } else {

                    swal({
                        title: "Berhasil",
                        text: "Petugas Baru Berhasil Tersimpan!",
                        icon: "success",
                        buttons: false,
                        timer: 2000,
                    });
                    setTimeout(function(){ window.location.href = '/principle/createpetugas'; }, 1500);

                }

            }

        });

    }
});

$(document).on('click', '.editpetugas', function() {
    $('#petugasid').val($(this).data('id'));
    $('#name-edit').val($(this).data('name'));
    $('#username-edit').val($(this).data('username'));
    $('#jenkel-edit').val($(this).data('jenkel'));
    $('#cabang-edit').val($(this).data('wilayah'));
    $('#tgl_lhr-edit').val($(this).data('tgl'));
    $('#nohp-edit').val($(this).data('hp'));
    $('#alamat-edit').val($(this).data('alamat'));
    $('#id-edit').val($(this).data('id'));

    $('#edit_petugas').modal('show');
});

$('.modal-footer').on('click', '#ubah', function() {

    var empty = false;
    $('input.edits').each(function() {
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
            url: "{{ route('updatepetugas') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#name-edit').val(),
                'id': $('#id-edit').val(),
                'jenkel': $('#jenkel-edit').val(),
                'wilayah_id': $('#cabang-edit').val(),
                'tgl_lahir': $('#tgl_lhr-edit').val(),
                'nohp': $('#nohp-edit').val(),
                'alamat': $('#alamat-edit').val(),
                },

            success: function(data) {

                swal({
                    title: "Berhasil",
                    text: "Petugas Berhasil Diubah!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                setTimeout(function(){ window.location.href = '/principle/createpetugas'; }, 1500);

            }

        });

    }

});

function ResetPetugas(id){

    $('#idx').val(id);

    $('#reset_petugas').modal('show');
}

$('.modal-footer').on('click', '#reset', function() {

    $.ajax({
        type: 'POST',
        url: "{{ route('resetpetugas') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idx').val(),
            },

        success: function(data) {

            swal({
                title: "Berhasil",
                text: "Password User Berhasil di Reset!",
                icon: "success",
                buttons: false,
                timer: 2000,
            });
            
            $('#reset_petugas').modal('hide');

        }

    });

});

</script>