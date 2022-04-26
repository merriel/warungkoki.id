@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <!-- Card stats -->
  <div class="row">
    <div class="col" style="padding-bottom: 0px;">
      @if($user->ket == 'update')
        @if($kurirtoko)
        <div class="card shadow-ss bg-success">
          <div class="card-body">
            <table width="100%">
              <tr>
                <td>
                    <div style="font-size: 13px;" class="text-white">
                      <b>AKTIFKAH KURIR TOKO?</b>
                    </div>
                    <div style="font-size: 11px;" class="text-white">
                      Swipe jika kurir toko aktif di wilayah Anda, Unswipe jika kurir toko delivery tidak aktif.
                    </div>
                </td>
                <td align="right" width="30%">
                  <label class="custom-toggle">
                    @if($kurirtoko->active == "yes")
                      <input type="checkbox" onclick="Aktifkan();" checked>
                    @else
                      <input type="checkbox" onclick="Aktifkan();">
                    @endif
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                  </label>
                  @if($kurirtoko->active == "yes")
                  <div class="text-white" style="font-size:11px;"><i><b>Active</b></i></div>
                  @else
                  <div class="text-white" style="font-size:11px;"><i><b>Not Active</b></i></div>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
        <br>
        @endif
        @if(!$stocks)
          @if($wilayah->toko != "N")
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
                        <b>UPDATE STOK DULU!!</b>
                      </div>
                      <div style="font-size: 11px; padding-bottom: 12px;" class="text-white">
                        Anda harus melakukan Update Stok Terlebih dahulu sebelum melakukan Transaksi, Pastikan Stok Anda di Update Agar tidak ada yang Miss Komunikasi.
                      </div>
                      <a href="/produk/stock"><button class="btn btn-success btn-sm">
                        Update Stock Sekarang
                      </button></a>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          @endif
        @endif
      @endif
      <br>
      <div class="card shadow">
        <a href="/scanner"><button class="btn btn-success btn-block">SCAN QRCODE</button></a>
      </div>
      <div id="scan1" align="center" style="padding-top: 10px;padding-bottom: 10px;" onclick="Scan();"><u>Input secara Manual</u></div>
      <div id="scan2" align="center" style="padding-top: 10px;padding-bottom: 10px;display: none;" onclick="TutupScan();"><i class="fa fa-times"></i>&nbsp;&nbsp;<u>Tutup input manual</u></div>
      <div class="card" style="display:none;" id="isiscan">
        <div class="card-body">
          <label>Masukan Kode :</label>
          <input type="text" id="code" class="form-control" placeholder="Masukan Kode Transaksi">
          <hr>
          <button onclick="Proses();" class="btn btn-success btn-block">Proses</button>
        </div>
      </div>
    </div>    
  </div>
  <br>
  <div class="card card-stats mb-4 mb-lg-0">
    <div class="card-body">
        <div class="row">
            <div class="col" style="padding-bottom:0px;">
                <h6 class="card-title text-uppercase text-muted mb-0">Transaksi Hari Ini</h6>
                <span class="h1 font-weight-bold mb-0">{{ $reedemhariini }}</span>
            </div>
            <div class="col-auto" style="padding-bottom:0px;">
              <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                  <i class="fas fa-chart-bar"></i>
              </div>
            </div>
        </div>
        <hr>
        <a href="/petugas/transaksihariini" class="menusxx"><button class="btn btn-block btn-sm btn-primary">Lihat Detail</button></a>
    </div>
  </div>
  <!-- <div class="card card-stats mb-4 mb-lg-0">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h6 class="card-title text-uppercase text-muted mb-0">Produk yang diambil Hari Ini</h6>
                <span class="h1 font-weight-bold mb-0">{{ $prodreedems }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                  <i class="fas fa-laptop"></i>
              </div>
            </div>
        </div>
        
    </div>
  </div> -->
  <div class="card card-stats mb-4 mb-lg-0">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h6 class="card-title text-uppercase text-muted mb-0">Total Rupiah Penjualan Hari Ini</h6>
                <span class="h1 font-weight-bold mb-0">{{ rupiah($transaksirupiah) }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                  <i class="fas fa-credit-card"></i>
              </div>
            </div>
        </div>
        <hr>
        <a href="/petugas/transaksihariinirupiah" class="menusxx"><button class="btn btn-block btn-sm btn-primary">Lihat Detail</button></a>
    </div>
  </div>
  <!-- <hr>
  <div style="font-size: 16px;"><b>
    List Pengambilan Hari ini
  </b></div>
  <div style="padding-bottom: 12px;">Tanggal {{ date("d F Y") }}</div>
  <div class="table-responsive">
    <table class="table" id="customers">
      <tr>
        <th>Kode</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Jam</th>
      </tr>
      @foreach($reedems as $reedem)
      <tr>
        <td>{{ $reedem->uuid }}</td>
        <td>{{ $reedem->prod_name }} {{ $reedem->post_name }}</td>
        <td>{{ $reedem->qty }}</td>
        <td>{{ date("H:i", strtotime($reedem->updated_at)) }}</td>
      </tr>
      @endforeach
    </table>
  </div> -->
  <br><br><br><hr>
@include('content.home.petugas.modal')
@include('layout.footer')

<script type="text/javascript">
  
  $( document ).ready(function() {

     setTimeout(function(){ window.location.reload() }, 50000);

});

  function Proses() {
    
    var kode = $('#code').val();

    setTimeout(function(){ window.location.href = '/reedem/view?code='+kode; }, 100);
  }

  function Scan() {

    $("#scan2").attr("style","padding-top: 10px;padding-bottom: 10px;display: block;");
    $("#scan1").attr("style","padding-top: 10px;padding-bottom: 10px;display: none;");
    $("#isiscan").attr("style","display: block;");

  }

  function TutupScan() {

    $("#scan2").attr("style","padding-top: 10px;padding-bottom: 10px;display: none;");
    $("#scan1").attr("style","padding-top: 10px;padding-bottom: 10px;display: block;");
    $("#isiscan").attr("style","display: none;");

  }

  function Aktifkan(){

    $.ajax({
      type: 'POST',
      url: "{{ route('petugas.aktifkurir') }}",
      data: {
        '_token': $('input[name=_token]').val(),
      },
      success: function(data) {

        setTimeout(function(){ window.location.reload() }, 100);
      }

    });
  }

</script>

</body>

</html>
