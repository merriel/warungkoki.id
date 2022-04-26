<script type="text/javascript">

$('#province').on('change', function () {

    var value = $(this).val();

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

function Actions(id){

    $('#content_'+id).attr("style","display: block;");
    $('#data_'+id).attr("onclick","Tutup("+id+")");

}

function Tutup(id){

    $('#content_'+id).attr("style","display: none;");
    $('#data_'+id).attr("onclick","Actions("+id+")");

}

function View(id){

    $.ajax({
        type: 'POST',
        url: "{{ route('viewwilayah') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
        },

        success: function(data) {

            $('#name_wilayah').val(data.name);
            $('#alamat_view').html(data.alamat);

            $('#view_wilayah').modal('show');
        }

    });

}

$('#tambahwilayah').on('click', function () {

    $('#tambah_wilayah').modal('show');
});

$('#simpan').on('click', function () {

    var empty = false;
    $('input.wil, textarea.wil').each(function() {
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

        $('#tambah_wilayah').modal('hide');

        $.ajax({
            type: 'POST',
            url: "{{ route('simpanwilayah') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#name').val(),
                'alamat': $('#alamat').val(),
                'username': $('#username').val(),
                'password': $('#password').val(),
                'namaadmin': $('#namaadmin').val(),
                'regency_id': $('#kotakab').val(),
                },

            success: function(data) {

                if (data == '1'){

                    swal({
                        title: "Gagal",
                        text: "Wilayah Tersebut Sudah Ada!",
                        icon: "error",
                        buttons: false,
                        timer: 2000,
                    });

                } else {

                    swal({
                        title: "Berhasil",
                        text: "Wilayah Baru Berhasil Tersimpan!",
                        icon: "success",
                        buttons: false,
                        timer: 2000,
                    });
                    setTimeout(function(){ window.location.href = 'wilayah'; }, 1500);

                }

            }

        });

    }
});

$(document).on('click', '.editwilayah', function() {
    $('#wilayahid').val($(this).data('id'));
    $('#wilayahname').val($(this).data('name'));
    $('#wilayahalamat').val($(this).data('alamat'));
    $('#edit_wilayah').modal('show');
});

$('.modal-footer').on('click', '#ubah', function() {

    var empty = false;
    $('input.wils, textarea.wils').each(function() {
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
            url: "{{ route('updatewilayah') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('#wilayahname').val(),
                'id': $('#wilayahid').val(),
                'alamat': $('#wilayahalamat').val(),
                },

            success: function(data) {

                swal({
                    title: "Berhasil",
                    text: "Wilayah Berhasil Diubah!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                setTimeout(function(){ window.location.href = 'wilayah'; }, 1500);

            }

        });

    }

});

$(document).on('click', '.deletewilayah', function() {

    $('#id').val($(this).data('id'));
    $('#hapus_wilayah').modal('show');
});

$('.modal-footer').on('click', '#delete', function() {

    $.ajax({
       type: 'POST',
       url: "{{ route('hapuswilayah') }}",
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
            setTimeout(function(){ window.location.href = 'wilayah'; }, 1500);
       }
   });

});

</script>