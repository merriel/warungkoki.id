@include('xmission.layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-purple pt-4 pt-md-8" style="padding-bottom: 14rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/users/transaksi"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="row justify-content-center">
              <h3 class="text-white">Ambil Reward</h3>   
          </div>
          <br>
          @if($rewards)
          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Hadiah yang di Dapatkan :</b>
                <br>
                <div style="padding-top: 5px; font-size: 14px;" class="text-warning"><b>{{ $rewards->hadiah_name }}</b></div>

                <hr>
                <b>Mission :</b>
                <br>
                <div style="padding-top: 5px;">{{ $rewards->mission_name }}</div>

                <hr>
                <div style="font-size: 12px;"><b>Barcode :</b></div><br>
                <div class="card shadow-ss">
                  <div class="card-body" >  
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img width='100%' alt='barcode' src='https://tomxperience.id/assets/barcode/barcode.php?codetype=Code128&size=85&text={{ $rewards->rewarduuid }}'><br> <div style='padding-top: 15px;font-size: 11px;' align='center'><u><b>{{ $rewards->rewarduuid }}</b></u></div>
                        </td>
                      </tr>
                      <tr>
                        <td align="center"><b><div style="font-size: 11px">Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</div></b></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div><br>

          <div class="card shadow-ss" style="background-color: #fb6340;">
            <div class="card-body">
              <table>
                <tr>
                  <td>
                    <i class="fa fa-exclamation-triangle" style="font-size: 24px;color: white;"></i>
                  </td>
                  <td width="3%">&nbsp;</td>
                  <td>
                      <div style="font-size: 13px;" class="text-white">
                        <b>PERHATIAN!!</b>
                      </div>
                      <div style="font-size: 10px;" class="text-white">
                        Hadiah mainan dan voucher dapat diambil di <b>SPBU Shell Lippo Karawaci</b> setelah proses peningkatan layanan selesai yaitu dimulai dari tanggal <b> 12 Juli 2021 </b>
                      </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          @else
          <div class="row">
            <div class="col-12">
              <div class="card shadow">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <table width="100%">
                        <tr>
                          <td align="center">
                            <img src="/assets/content/img/theme/nothing.jpg" width="90%">
                            <br>
                            <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                            <h6>Sudah Di Claim Hadiah ini!</h6>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
          @endif

        </div>
      </div>
    </div>
    <br><br>
  @include('xmission.layout.footer')
</body>

</html>