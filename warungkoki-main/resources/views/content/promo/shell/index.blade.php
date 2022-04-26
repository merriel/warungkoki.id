@include('layout.head2')

<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 17rem;">
  <div class="container-fluid">
    <div class="header-body">

    </div>
  </div>
</div>
<br>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      <section class="container">
        <div class="ct-page-title" style="margin-bottom:0.5rem;">
          <h2 class="ct-title" style="margin-bottom:0px;font-size: 21px;font-weight: bold;" id="content">REEDEM PROMO </h2>
          <div style="font-size:11px;">Masukan data-data berikut untuk reedem/ambil promo.</div>
        </div>

        <div class="row">
            <input type="hidden" id="wilayahid" value="{{ $wilayah->id }}">
            <div class="col" style="padding: 0px 0px 20px 0px;">
                <hr>
                <label>Masukan Kode REEDEM :</label>
                <input type="text" class="form-control isi" id="kode" placeholder="Masukan Kode dari Shell">
                <br>
                <div class="row">
                    <div class="col-4" style="padding-right:0px;">
                        <a href="/home"><button class="btn btn-block btn-danger"><i class="fa fa-times"></i>&nbsp;Batal</button></a>
                    </div>
                    <div class="col-8">
                        <button onclick="Ambil();" class="btn btn-block btn-success">Ambil Sekarang</button>
                    </div>
                </div>
            </div>
          
        </div>
        
    </div>
  </div>
</div>  
@include('content.promo.modal')
@include('layout.footer2')

<script type="text/javascript">
    

    function Ambil(){

        var empty = false;
        $('input.isi').each(function() {
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

             $('#konfirmasi').modal('show');
        }


    }

    function YakinAmbil(){

        $('#konfirmasi').modal('hide');

        $.ajax({
           type: 'POST',
           url: "{{ route('promo.shell.ambil') }}",
           data: {
                '_token': $('input[name=_token]').val(),
                'kode': $('#kode').val(),
                'wilayah_id': $('#wilayahid').val(),
            },
           success: function(data) {

            if(data.status == 0){

                swal("Kode Voucher Tersebut Tidak Ada!", {
                   icon: "error",
                   buttons: false,
                   timer: 2000,
                });

            } else if(data.status == 2){

                setTimeout(function(){ window.location.href = '/users/transaksi/detail2?uuid='+data.kode; }, 100);

            } else if(data.status == 3){

                swal("Kode Voucher Tersebut Sudah Selesai!", {
                   icon: "error",
                   buttons: false,
                   timer: 2000,
                });

            } else {

                swal("Reedem Voucher Berhasil!", {
                   icon: "success",
                   buttons: false,
                   timer: 2000,
                });

                setTimeout(function(){ window.location.href = '/promo/shell/pilih'; }, 1500);
            }

                
                
           }
       });
    }
</script>
        
</body>

</html>