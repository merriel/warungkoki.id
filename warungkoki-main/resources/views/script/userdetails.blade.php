<script type="text/javascript">
        
  function Beli(id){

    $('.loading').attr('style','display: block');

    $.ajax({
      type: 'POST',
      url: "{{ route('masukkeranjang') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'post_id': id,
          
      },
      success: function(data) {

        $('#keranjangcount').html(data);

        swal({
            title: "Berhasil",
            text: "Produk Masuk ke Dalam Keranjang!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        $('.loading').attr('style','display: none');

      }

    });

  }

  function Favorite(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('masukfavorite') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'post_id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Produk Masuk ke Dalam List Favorite!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });


  }

  function NotFavorite(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('keluarfavorite') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'post_id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Produk Dikeluarkan dari List Favorite!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });

  }

  $('#detail').on('click', function () {

    $('.menus').attr("class","btn btn-secondary menus");
    $('#detail').attr("class","btn btn-kuning menus");

    $('.contentmenu').attr("style","display: none;");
    $('#produkdetails').attr("style","display: block;");

  });

  $('#penukaran').on('click', function () {

    $('.menus').attr("class","btn btn-secondary menus");
    $('#penukaran').attr("class","btn btn-kuning menus");

    $('.contentmenu').attr("style","display: none;");
    $('#penukarandetail').attr("style","display: block;");

  });


  function Follow(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('followcompany') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Anda Berhasil Follow Toko!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });

  }

  function Unfollow(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('unfollowcompany') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Anda Berhasil Unfollow Toko!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });

  }


</script>