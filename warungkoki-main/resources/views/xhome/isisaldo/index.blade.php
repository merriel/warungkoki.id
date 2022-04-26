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

  <div class="col-12" align="center" style="padding-bottom: 20px;padding-left: 0px;">
      <div style="font-size: 12px">Virtual Number Anda :</div>
      <div style="font-size: 24px"><b>{{ $va }}</b></div>
      <input type="text" value="{{ $va }}" id="myInput" style="display:none;">
      <div class="text-white" style="padding-top:10px;">
        <button onclick="Copy();" class="btn btn-sm btn-secondary" style="border-radius: 1rem;"><i class="fa fa-copy"></i>&nbsp;&nbsp;Copy</button>
      </div>
  </div>

  <!-- ===== TOKO PILIHAN ANDA ====== -->

<div class="row">
  <div class="col">
    <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
      <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;">
        <div class="row">
          <div class="col-12">
            <div style="font-size: 16px;padding-bottom: 10px;">
              <b>Cara Mengisi Saldo Warungkoki :</b>
            </div>
            <div style="font-size:13px;">
              <ol style="padding-left:15px;">
                <li>Lakukan Transfer ke VA BCA dengan nommer tersebut.</li>
                <li>Sistem akan mengenakan biaya administrasi transfer sebesar 1000 rupiah /transfer, yang akan di potongkan dari saldo pengisian.</li>
                <li>Transfer dapat dilakukan via BCA ataupun Bank lain (terkena biaya transfer antar Bank sesuai ketentuan Bank masing-masing).</li>
                <li>Minimal Transfer Rp. 10.000</li>
              </ol>
            </div>
          </div>
            
        </div> 
      </div>
    </div>
  </div>    
</div>

<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('layout.footer')
@include('script.home')

<script type="text/javascript">
 
function Copy() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  navigator.clipboard.writeText(copyText.value);

  swal({
      title: "Berhasil",
      text: "Virtual Number Copied!",
      icon: "success",
      buttons: false,
      timer: 2000,
  });

}

</script>
</body>

</html>