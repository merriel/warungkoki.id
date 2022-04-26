<script type="text/javascript">
	
	function checkout(){

        $.ajax({
           type: 'POST',
           url: "{{ route('selesaibayar') }}",
           data: {
                '_token': $('input[name=_token]').val(),
            },
           success: function(data) {

           }

        });
        // Kirim request ajax
        $.post("{{ route('order.store') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            amount: $('#amount').val(),
            note: 'Beli Deals',
            order_type: 'Pembelian Deals or Challanges',
            order_name: $('#name').val(),
            order_email: $('#email').val(),
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        });
        return false;
    }

    function RemoveKeranjang(id){

        $('#id').val(id);

        $('#confirm_hapus').modal('show');

    }

    $('#confirm_yakin').on('click', function () {

      $('#confirm_hapus').modal('hide');

        $.ajax({
            type: 'POST',
            url: "{{ route('removekeranjang') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#id').val(),  
            },
            success: function(data) {

              swal({
                  title: "Berhasil",
                  text: "Produk Dalam Keranjang di Hapus!",
                  icon: "success",
                  buttons: false,
                  timer: 2000,
              });

              setTimeout(function(){ window.location.reload() }, 1500);

            }

          });
    });

</script>