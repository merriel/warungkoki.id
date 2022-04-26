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
    <div class="header bg-warung-3 pt-2 pt-md-8" style="padding-bottom: 17rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
<div class="container-fluid" style="margin-top: -8rem;">

  <div class="col-12" align="center" style="padding-bottom: 20px;padding-left: 0px;">
      <div style="font-size: 12px;padding-bottom:10px;" class="text-white">Masukan Kode Verifikasi :</div>
      <div style="font-size: 24px" class="text-white">
        <input type="text" class="form-control" id="kodeverifikasi" placeholder="Kode Verifikasi">
      </div>
      <div class="text-white" style="padding-top:10px;">
        <button onclick="Verifikasi()" class="btn btn-secondary menusxx" style="border-radius: 2rem;">Verifikasi</button>
      </div>
  </div>

  <!-- ===== TOKO PILIHAN ANDA ====== -->

<div class="row">
  <div class="col">
    <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
      <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;">
        <div class="row">
          <div class="col-12">
            <div align="center" style="font-size: 12px;padding-bottom: 10px;">
              <b>Waktu Verifikasi :</b>
            </div>
            <div style="font-size:28px;font-weight: bold;" align="center" id="time"></div>
            <div style="font-size: 12px;padding-top: 9px;">
              Masukan Kode Verifikasi yang kami kirimkan lewat email, klik tombol verifikasi untuk menyelesaikan verifikasi. Halaman ini akan refresh otomatis jika watu verifikasi sudah berakhir.
            </div>
          </div>
            
        </div> 
      </div>
    </div>
  </div>    
</div>

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
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan jadikan Verifikasi Nomor Handphone ini?</h5></td>
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
@include('xhome.layout.footer')
@include('script.home')

<script type="text/javascript">

function startTimer(duration, display) {
  var timer = duration, minutes, seconds;
  setInterval(function () {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.textContent = minutes + ":" + seconds;

      if (--timer < 0) {
          timer = duration;
      } 

      if(minutes == '00' && seconds == '00'){

        $('.loading').attr('style','display: block');
        
        $.ajax({
          type: 'GET',
          url: "{{ route('xhome.verifikasi.kadaluarsa') }}",
          success: function(data) {

            swal({
              title: "Warning",
              text: "Waktu verifikasi telah selesai!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

          }

        });


      }
  }, 1000);
}

window.onload = function () {
    var fiveMinutes = 60 * 1,
        display = document.querySelector('#time');

    startTimer(fiveMinutes, display);

};
 
function Verifikasi(){

  $('#konfirm').modal('show');

}
 
function Yakin() {

  $.ajax({
      type: 'POST',
      url: "{{ route('xhome.verifikasi2') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'kode': $('#kodeverifikasi').val(),    
      },
      success: function(data) {

        if(data == 0){

          swal({
              title: "Berhasil",
              text: "Proses Verifikasi nomor handphone Anda Berhasil!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        } else {

          swal({
              title: "Warning!",
              text: "Kode yang Anda Masukan Salah!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);


        }

        

      }

    });

}

</script>
</body>

</html>