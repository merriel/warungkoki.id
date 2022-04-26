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

    .nav2 {
      position: fixed;
      bottom: 0;
      left: 15px;
      background-color: #fff;
      display: flex;
      overflow-x: auto;

      margin-bottom: 75px;
      border-radius: 3rem;
      box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
      height: 50px;
      width: 50px;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-2 pt-md-8" style="padding-bottom: 22rem;">
      <div class="container-fluid">
        <div class="header-body">
          <input type="hidden" id="ktps" value="{{ Auth::user()->token }}">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid" style="margin-top: -13rem;">
      <div class="row">
        <div class="col-12" style="padding-bottom: 20px;">
            <div style="font-size: 12px" class="text-black">Selamat Datang Retailer</div>
            <div style="font-size: 21px" class="text-black"><b>{{ $retailer->name }}</b></div>
        </div>

        <br>
        <div class="col-xl-4 order-xl-2 mb-xl-0" style="padding-right: 0px;padding-left: 0px;">
          <div class="card" style="border-radius: 2rem;border: 0px;">
            <div class="card-body" style="padding: 1rem; height: 100%">

                <div class="card-body shadow-ss" style="border-radius: 2rem;background-color: #15BE77;">   
                  <div style="font-size: 11px; color: white;">
                      <i class="fa fa-calendar"></i>
                      &nbsp;Hari ini Tanggal {{ date('d F Y') }}
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-6">
                    <a href="/retailer/history" class="menusxx">
                      <div class="card-body shadow-ss" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                          <table width="100%">
                              <tr>
                                  <td align="center">
                                      <i style="color:#525f7f ; font-size:26px;" class="fa fa-history"></i>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="center">
                                      <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">History Penjualan</div>
                                  </td>
                              </tr>
                          </table>
                      </div>
                    </a>
                  </div>

                  <div class="col-6">
                    <a href="/retailer/ubah" class="menusxx">
                      <div class="card-body shadow-ss" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                          <table width="100%">
                              <tr>
                                  <td align="center">
                                      <i style="color:#525f7f ; font-size:26px;" class="fa fa-cog"></i>
                                  </td>
                              </tr>
                              <tr>
                                  <td align="center">
                                      <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Ubah Data</div>
                                  </td>
                              </tr>
                          </table>
                      </div>
                    </a>
                  </div>
                </div>
                <hr>
                <h6 class="card-title text-uppercase text-muted mb-0">Dashboard :</h6><br>
                <div class="row">

                  <div class="col-6" style="padding-right: 7.5px;">
                    <div class="card shadow-ss" style="border-radius: 1rem;background-color: #15BE77;">
                      <div class="card-body" style="padding: 1rem;">
                        <h6 class="card-title text-white mb-0">Total Rupiah Penjualan Hari Ini :</h6>
                        <div style="font-size:16px;padding-top: 2px;color: white;"><b>{{ rupiah($transaksihariini) }}</b></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6" style="padding-left: 7.5px;">
                    <div class="card shadow-ss" style="border-radius: 1rem;background-color: #feac3b;">
                      <div class="card-body" style="padding: 1rem;">
                        <h6 class="card-title text-white mb-0">Jumlah Transaksi<br> Hari Ini :</h6>
                        <div style="font-size:16px;padding-top: 2px;color: white;"><b>{{ $transaksicounthariini }}</b></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-6" style="padding-right: 7.5px;">
                    <div class="card shadow-ss bg-danger" style="border-radius: 1rem;">
                      <div class="card-body" style="padding: 1rem;">
                        <h6 class="card-title text-white mb-0">Total Rupiah Penjualan Bulan Ini :</h6>
                        <div style="font-size:16px;padding-top: 2px;color: white;"><b>{{ $transaksibulanini }}</b></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-6" style="padding-left: 7.5px;">
                    <div class="card shadow-ss bg-info" style="border-radius: 1rem;">
                      <div class="card-body" style="padding: 1rem;">
                        <h6 class="card-title text-white mb-0">Total Insentif yang didapat Bulan ini :</h6>
                        <div style="font-size:16px;padding-top: 2px;color: white;"><b>Rp. 0</b></div>
                      </div>
                    </div>
                  </div>

                </div>
                <hr>
                <div>
                  <h6 class="card-title text-uppercase text-muted mb-0">Transaksi Berjalan Hari ini :</h6>
                  <br>
                  <table id="customers">
                    <tr>
                      <th>Pelanggan</th>
                      <th>Qty</th>
                      <th>Total</th>
                      <th>#</th>
                    </tr>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('content.home.users.modal2')
@include('layout.footer')
@include('script.home')

<script type="text/javascript">
 
  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('user.guides') }}",
      success: function (data) {

        if(data != '1'){

           $('#guide').modal({backdrop: 'static', keyboard: false}); 

        } else {

          var ktp = $('#ktps').val();

          if(ktp == ''){

            $('#ktp').modal({backdrop: 'static', keyboard: false}); 
          }

        }
      }
    });

    // $.ajax({
    //   type: 'GET',
    //   url: "{{ route('alamat.cek') }}",
    //   success: function (data) {

    //     if(data.length == 0){

    //       swal({
    //           title: "Perhatian!",
    //           text: "Harap Tentukan Alamat Anda terlebih Dahulu!",
    //           icon: "warning",
    //           buttons: false,
    //           timer: 2000,
    //       });

    //        setTimeout(function(){ window.location.href='/alamatuser'; }, 2000);

    //     } 
    //   }
    // });

  });

  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
   
      return false;
      return true;
  }

  function Next(id){
 
  $('.content').attr("style","display: none;");
  $('.tombol').attr("style","display: none;");

  $('#tombol'+id).attr("style","display: block;");
  $('#content'+id).attr("style","display: block;");

  }

  function Back(id){

    $('.content').attr("style","display: none;");
    $('.tombol').attr("style","display: none;");

    $('#tombol'+id).attr("style","display: block;");
    $('#content'+id).attr("style","display: block;");

  }

  function Finish(){

    $.ajax({
      type: 'GET',
      url: "{{ route('selesai.guide') }}",
      success: function(data) {

        $('#guide').modal('hide');

        $('#ktp').modal({backdrop: 'static', keyboard: false}); 

      }
    });

  }

  function SimpanPengaturan(){

    var pin = $('#pin').val();
    var pin2 = $('#pin2').val();
    var ktp = $('#ktpx').val();
    var nohp = $('#nohp').val();

    if(pin == pin2){

      if(pin.length == 6){
          $.ajax({
            type: 'POST',
            url: "{{ route('selesai.pengaturan') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'ktp': ktp,
                'pin': $('#pin').val(),
                'nohp': $('#nohp').val(),
            },
            success: function(data) {

              swal("Terimakasih, Selamat Datang di Warungkoki.id", {
                 icon: "success",
                 buttons: false,
                 timer: 2000,
              });

              $('#ktp').modal('hide');

            }
          });

      } else {

        swal("PIN Harus 6 Digit!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

      }

    } else {

      swal("PIN dan PIN Konfirmasi diharuskan SAMA!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

    }

  }

  var input = document.getElementById("cari");

  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     event.preventDefault();
     document.getElementById("myBtn").click();
    }
  });

  function Cari(){

    var cari = $('#cari').val();

    if(cari == ''){

      swal("Isi Keyword yang diinginkan!", {
         icon: "error",
         buttons: false,
         timer: 2000,
      });

    } else {

      $('.loading').attr('style','display: block');

      setTimeout(function(){ window.location.href='/cari?value='+cari+''; }, 1000);

    }

    
  }

  function IsiSaldo(){

    $('#isi').modal('show');

  }

  function PembayaranInfo(){

    $('#pembayaran').modal('show');

  }

  function PelayananInfo(){

    $('#pelayanan').modal('show');

  }

  function Garansi(){

    $('#garansi').modal('show');

  }

</script>
</body>

</html>
