@include('layout.head')
<style type="text/css">
  .bottom-left {

    position: absolute;
    bottom: 5px;
    left: 30px;
    font-size: 19px;
    font-weight: bold;
    text-align: left;
    color: white;
  }
  .photosx{
      width: 100%;
      padding-left: 10px;
      padding-right: 10px;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-warung-3 pt-2 pt-md-8" style="padding-bottom: 13rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
<div class="container-fluid" style="margin-top: -8rem;">
  <div class="card" style="border-radius: 1.5rem;">
    <div class="card-body">
      <div class="col-12" align="left" style="padding-bottom: 20px;padding-left: 0px;padding-right: 0px;">
        <div align="center"><img src="/assets/splash/images/phone.jpg" width="60%"></div><br>
        <div style="font-size: 14px;padding-bottom:5px;"><b>Masukan No Handphone Anda :</b></div>
        <div style="font-size:11px;padding-bottom: 15px;"> Anda diharuskan memasukan Nomor Handphone Anda, untuk mendaftarkannya sebagai virtual account Anda, pastikan Anda menginput nomor handphone Anda dengan benar.</div>
        <div style="font-size: 24px" class="text-white">
          <input type="number" class="form-control" id="nohp" placeholder="Contoh: 0811909018827">
        </div>
        <div class="text-white" style="padding-top:20px;" align="center">
          <button onclick="Verifikasi()" class="btn btn-secondary menusxx" style="border-radius: 2rem;">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  <br><br>
  <!-- ===== TOKO PILIHAN ANDA ====== -->

<!-- <div class="row">
  <div class="col">
    <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
      <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;">
        <div class="row">
          <div class="col-12">
            <div style="font-size: 16px;padding-bottom: 10px;">
              <b>Cara Verifikasi Nomor Handphone Anda :</b>
            </div>
            <div style="font-size:13px;">
              <ol style="padding-left:15px;">
                <li>Masukan nomor handphone Anda</li>
                <li>Klik tombol verifikasi untuk memverifikasi nomor handphone Anda</li>
                <li>Warungkoki akan mengirimkan kode verifikasi ke Email Anda.</li>
                <li>Masukan kode verifikasi tersebut</li>
                <li>Klik tombol verifikasi dan proses verifikasi nomor handphone Berhasil!</li>
              </ol>
            </div>
          </div>
            
        </div> 
      </div>
    </div>
  </div>    
</div> -->
<div class="modal fade" id="konfirm" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Simpan Nomor Handphone ini?</h5></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="Yakin()" class="btn btn-success">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('layout.footer')
@include('script.home')

<script type="text/javascript">

function Verifikasi(){

  if($('#nohp').val() == ''){

    swal({
        title: "Perhatikan",
        text: "Masukan Nomor HP Dulu!",
        icon: "error",
        buttons: false,
        timer: 2000,
    });

  } else if($('#nohp').val().length == 12 || $('#nohp').val().length == 13 || $('#nohp').val().length == 11 || $('#nohp').val().length == 10){

    $('#konfirm').modal('show');

  } else {

    swal({
        title: "Perhatikan",
        text: "Pastikan No Handphone Anda Benar!",
        icon: "error",
        buttons: false,
        timer: 2000,
    });

  }

}
 
function Yakin() {

  $('.loading').attr('style','display: block');

  $('#konfirm').modal('hide');

  $.ajax({
    type: 'POST',
    url: "{{ route('xhome.verifikasi') }}",
    data: {
        '_token': $('input[name=_token]').val(),
        'nohp': $('#nohp').val(),    
    },
    success: function(data) {

      if(data == 0){

        swal({
            title: "Berhasil",
            text: "Terimakasih Sudah memasukan No Handphone Anda!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

      } else {

        swal({
            title: "Perhatian",
            text: "No Handphone Tersebut sudah ada yang pakai!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

      }

      setTimeout(function(){ window.location.reload() }, 1500);

    }

  });


}

</script>
</body>

</html>