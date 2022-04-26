@include('layout.head')
<style type="text/css">
  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 11px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: #feac3b;
    color: white;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
      <div class="ct-page-title">
        <div style="font-size:18px;font-weight:bold" id="content">Selesaikan Pembayaran</div>
      </div>

      <div class="row">
        <div class="col-12" onclick="Cash()">
          <div class="card shadow-ss" style="border-radius:1rem;">
            <div class="card-body">
                <div class="row">
                  <div class="col-12" style="padding-right:0px;padding-left: 0px;">
                  <div style="padding-left: 15px;padding-right: 15px;" align="center">
                    Klik di bawah,untuk diarahkan ke Aplikasi GOJEK!
                  </div>
                  <br>
                  <div class="col-12">
                    <a href="{{ $transxx->deeplink }}"><button style="border-radius: 2rem;" class="btn btn-success btn-block">BUKA APLIKASI GOJEK</button></a>
                  </div>
                  <hr>
                  <div style="padding-left: 15px;padding-right: 15px;" align="center">
                    Atau Scan QRCODE dari aplikasi GOJEK!
                  </div>
                  <br>
                  <img src="{{ $transxx->qris }}" width="100%">
                  <div class="col-12">
                    <a href="/users/transaksi"><button style="border-radius: 2rem;" class="btn btn-warning btn-block">Kembali</button></a>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>    
    </div>

@include('layout.footer')  
</body>

</html>