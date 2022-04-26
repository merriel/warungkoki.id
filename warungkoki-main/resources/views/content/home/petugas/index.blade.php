@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
  <div class="row">
    <div class="col-12" style="padding-bottom: 20px;">
        <div style="font-size: 11px" class="text-black">Anda berada di <b>{{ $wilayah->name }}</b>, <br><b style="font-size:18px;">{{ Auth::user()->name }}</b></div>
    </div>
    <div class="col" style="padding-bottom: 0px;">

      <!-- ==== CEK APPROVE BARANG ==== -->

      @if($cekmasukbarang->count() != 0)

      <div class="card shadow-ss bg-danger" style="border-radius: 1rem;">
        <div class="card-body">
          <div style="font-size:14px;"><b class="text-white">Approve Perpindahan Barang</b></div>
          <hr>

          @foreach($cekmasukbarang as $cekmas)

          @php
          $banyak = DB::table('stock_transaction_details')
          ->where("stocktransaction_id", $cekmas->id)
          ->sum('qty');

          @endphp
          <div class="card shadow-ss" style="border-radius: 1.5rem;">
            <div class="card-body">

              <div class="row">
                <div class="col-7" style="padding-bottom:0px;padding-right: 0px;">
                  <div style="font-size: 11px;">
                      Dikirim dari :
                  </div>
                  <div style="font-size: 13px;">
                      <b>{{ strtoupper($cekmas->name) }}</b>
                  </div>
                  <div style="font-size: 11px;">
                      Terdapat <b>{{ $banyak }}</b> Barang 
                  </div>
                </div>
                <div class="col-5" style="padding-bottom:0px;padding-top: 12px;">
                  <button onclick="Approved({{ $cekmas->id }})" style="border-radius:2rem;" class="btn btn-success btn-block btn-sm"> 
                      Approve
                  </button>
                </div>
              </div>

            </div>
          </div>
          @endforeach

        </div>
      </div>
      <br>
      @endif

      <!-- === SELESAI CEK APPROVED ======= -->


      @if($user->ket == 'update')
        <!-- @if($kurirtoko) -->
        <!-- <div class="card shadow-ss bg-success" style="border-radius: 1.5rem;">
          <div class="card-body" style="padding-top:0.5rem;padding-bottom:0.5rem;">
            <table width="100%">
              <tr>
                <td>
                    <div style="font-size: 13px;" class="text-white">
                      <b>AKTIFKAH KURIR TOKO?</b>
                    </div>
                    <div style="font-size: 11px;" class="text-white">
                      Swipe untuk Aktif atau Nonaktif kurir toko delivery
                    </div>
                </td>
                <td align="right" width="30%">
                  <label class="custom-toggle" style="margin-bottom:0px;">
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
        </div> -->
        <!-- @endif -->


        <!-- ====== CEK AWAL DAN AKHIR STOCK BARANG ==== -->
          @if($wilayah->toko != "N")
            
            @if($cekstok)
              @if($cekstok->jenis == "akhir")
                <div class="card shadow-ss bg-success" style="border-radius: 1.5rem;">
              @else
                <div class="card shadow-ss bg-primary" style="border-radius: 1.5rem;">
              @endif
            @else
            <div class="card shadow-ss bg-warning" style="border-radius: 1.5rem;">
            @endif
              <div class="card-body">
                <div class="row">

                @if(!$selesaistok)
                  <div class="col-8" style="padding-bottom:0px;">
                    <div style="font-size: 13px;" class="text-white">
                      @if($cekstok)
                        <b>STOK TUTUP TOKO!</b>
                      @else
                        <b>STOK BUKA TOKO!</b>
                      @endif
                    </div>
                    <div style="font-size: 11px;" class="text-white">
                      @if($cekstok)
                        Diharapkan Anda melakukan cek stok di akhir tutup toko.
                      @else
                        Anda harus melakukan update stok terlebih dahulu sebelum toko buka.
                      @endif
                    </div>
                  </div>
                  <div class="col-4" style="padding-bottom:0px;padding-top: 12px;">
                    <a href="/produk/stock" class="menusxx"><button style="border-radius:2rem;" class="btn btn-secondary btn-block btn-sm"> 
                        Input
                    </button></a>
                  </div>
                @endif

                  @if($stocks->count() != 0)
                  <div class="col-12" style="padding-bottom:0px;">
                    @if($cekstok->jenis != "akhir")
                    <hr>
                    @endif
                    <div style="font-size: 11px;padding-bottom: 10px;" class="text-white">Aktifitas Input Stok Hari ini :</div>

                    @foreach($stocks as $st)
                    <div class="card" style="border-radius:1.5rem;">
                      <div class="row">
                        <div class="col-7" style="padding: 10px 0px 8px 28px;">
                          @if($st->type == "cek")

                            @if($st->jenis == "awal")
                              <div style="font-size:11px;">Input Stok Pagi/Awal</div>
                            @else
                              <div style="font-size:11px;">Input Stok Malam/Akhir</div>
                            @endif

                          @elseif($st->type == "in")

                            @if($st->jenis == "pemasukan")
                              <div style="font-size:11px;">Input Barang Masuk</div>
                            @elseif($st->jenis == "intratoko")
                              <div style="font-size:11px;">Masuk Antar Gudang</div>
                            @else

                            @endif

                          @else

                            @if($st->jenis == "intratoko")
                              <div style="font-size:11px;">Keluar Antar Gudang</div>
                            @else
                              <div style="font-size:11px;">Retur Barang</div>
                            @endif

                          @endif
                        </div>
                        <div class="col-2" style="padding-top:10px; padding-bottom: 0px; padding-right: 0px;">
                          <div style="font-size:11px;">{{ date('H:i', strtotime($st->updated_at)) }}</div>
                        </div>
                        <div class="col-3" style="padding-top:5px; padding-bottom: 5px;">
                          <a class="menusxx" href="/produk/stock/edit?id={{ $st->id }}"><button class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button></a>
                        </div>
                      </div>
                    </div>
                    <div style="padding-bottom:8px;"></div>
                    @endforeach

                  </div>
                  @endif
                </div>
              </div>
            </div>
            <br>
        @endif
      @endif

      <!-- ====== SELESAI PENGECEKAN ======== -->



      <!-- ========== MONITORING VOUCHERS ========== -->

      @if($cekmonitoringvouchers->count() != 0)

        @foreach($cekmonitoringvouchers as $moncek)

        @php
        $ambil = DB::table('voucher_details')
        ->where("voucher_id", $moncek->id)
        ->where("status", "selesai")
        ->count();

        $sisa = $moncek->total - $ambil;

        @endphp

        <div class="card shadow-ss bg-info" style="border-radius: 1.5rem;">
          <div class="card-body">
            <div class="row">
              <!-- <div class="col-3" align="center" style="padding-top:20px;">
                <i class="fa fa-exclamation-triangle" style="font-size: 30px;color: white;"></i>
              </div> -->
              <div class="col-7" style="padding-bottom:0px;">
                <div style="font-size: 13px;" class="text-white">
                  <b>SISA KESELURUHAN!</b>
                </div>
                <div style="font-size: 11px;" class="text-white">
                  {{ $moncek->name }}
                </div>
              </div>
              <div class="col-5" style="padding-bottom:0px;padding-left: 0px;" align="right">
                <div style="font-size:30px" class="text-white"><b>{{ number_format($sisa,0,',','.') }}</b></div>
              </div>
            </div>
          </div>
        </div>
        <br>
        @endforeach

      @endif

      <!-- ====== AKHIR PENGECEKAN VOUCHER SISA ====== -->

        <a href="/scanner"><button style="border-radius: 2rem;" class="btn btn-success btn-block">SCAN QRCODE</button></a>
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
      <br>

      <!-- ======= MENU ====== -->

      <div class="row">
        <div class="col-4">
          <a href="#" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                          <label class="custom-toggle">
                            @if($kurirtoko->active == "yes")
                              <input type="checkbox" onclick="Aktifkan();" checked>
                            @else
                              <input type="checkbox" onclick="Aktifkan();">
                            @endif
                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                          </label>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                          @if($kurirtoko->active == "yes")
                          <div style="font-size:11px;color: #525f7f;"><b>Active</b><br> Kurir Toko</div>
                          @else
                          <div style="font-size:11px;color: #525f7f;"><b>Not Active</b><br> Kurir Toko</div>
                          @endif
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
            <a href="/profile" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;">
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-user"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f;">Profil <br> Anda</div>
                        </td>
                    </tr>
                </table>
            </div>
            </a>
        </div>

        <div class="col-4">
            <a href="/petugas/pengambilan?dari={{ date('Y-m-d') }}&sampai={{ date('Y-m-d') }}" class="menusxx">
              <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;">
                  <table width="100%">
                      <tr>
                          <td align="center">
                              <i style="color:#fb6340; font-size:26px;" class="fa fa-history"></i>
                          </td>
                      </tr>
                      <tr>
                          <td align="center">
                              <div style="font-size: 11px; padding-top: 10px;color: #525f7f; ">History<br> Penjualan</div>
                          </td>
                      </tr>
                  </table>
              </div>
            </a>
        </div>

        <div class="col-4">
          <a href="/voucher/cek" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-search"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Cek <br> Voucher</div>
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
          <a href="/produk/stock2" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-inbox"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Update Stok <br> Satuan</div>
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
          <a href="/petugas/retur" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-bullhorn"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Retur Pelanggan</div>
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
          <a href="/stock/inbound" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-archive"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Isi Barang Masuk</div>
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
            <a href="/stock/retur" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;">
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-handshake"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f;">Retur <br> Barang</div>
                        </td>
                    </tr>
                </table>
            </div>
            </a>
        </div>

        <div class="col-4">
            <a href="/stock/intratoko" class="menusxx">
              <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;">
                  <table width="100%">
                      <tr>
                          <td align="center">
                              <i style="color:#fb6340; font-size:26px;" class="fa fa-truck"></i>
                          </td>
                      </tr>
                      <tr>
                          <td align="center">
                              <div style="font-size: 11px; padding-top: 10px;color: #525f7f; ">Kirim Antar Toko</div>
                          </td>
                      </tr>
                  </table>
              </div>
            </a>
        </div>

      </div>
      <hr>
      
    </div>    
  </div>

  @php $no=0;  @endphp
  @foreach($ranking as $rank)
  @php $no++;  @endphp
  @if($userid == $rank->id)
  <div class="row">
    <div class="col-12" style="padding-bottom: 0px;padding-right: 7.5px;">
        <div class="card card-stats mb-4 mb-lg-0 bg-primary" style="border-radius: 1.5rem;">
          <div class="card-body" style="padding-bottom:0px;">
            <div class="row">
              
              <div class="col-3" style="padding-right:0px;" align="center">
                <div class="font-weight-bold text-white" style="font-size:34px;">{{ $no }}</div>
              </div>
              <div class="col-9" style="padding-left:0px;">
                <h6 class="card-title text-uppercase text-white mb-0"><b>Ranking Pendaftaran Member :</b></h6>
                @if($no <= 10)
                <div style="font-size:10px;padding-top: 5px;" class="text-white">Anda Termasuk TOP 10 Pendaftaran Member, Ayo tingkatkan lagi pendaftaran member kamu! </div>
                @else
                <div style="font-size:10px;padding-top: 5px;" class="text-white">Ayo Semangat dan tingkatkan lagi pendaftaran member kamu! </div>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  @endif
  @endforeach

  <div class="row">
    <div class="col-6" style="padding-bottom: 0px;padding-right: 7.5px;">
        <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1.5rem;">
          <div class="card-body">
              <h6 class="card-title text-uppercase text-muted mb-0">Pendaftaran Member Hari ini :</h6>
              <span class="h1 font-weight-bold mb-0">{{ $memberhariini }}</span>
          </div>
        </div>
    </div>
    <div class="col-6" style="padding-bottom: 0px;padding-left: 7.5px;">
        <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1.5rem;">
          <div class="card-body">
              <h6 class="card-title text-uppercase text-muted mb-0">Total Pendaftaran Member Anda :</h6>
              <span class="h1 font-weight-bold mb-0">{{ $totalmember }}</span>
          </div>
        </div>
    </div>
  </div>

  <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1.5rem;">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h6 class="card-title text-uppercase text-muted mb-0">Transaksi Di Toko Hari Ini</h6>
            </div>
            <div class="col-3" style="padding-bottom:0px;">
              <span class="h1 font-weight-bold mb-0">{{ $transaksihariini }}</span>
              <div style="font-size:10px;">Transaksi</div>
            </div>

            <div class="col-9" style="padding-bottom:0px;">
              <span class="h1 font-weight-bold mb-0">{{ rupiah($transaksirupiah) }}</span>
              <div style="font-size:10px;">Transaksi dalam Rupiah</div>
            </div>
        </div>
        <hr>
        @if($summarybarang->count() != 0)
        <div class="row">
          <div class="col-12">
              <h6 class="card-title text-uppercase text-muted mb-0">Barang Terjual Hari ini</h6>
          </div>
        </div>

        <table id="customers">
          <thead>
            <tr>
              <th>Nama Barang</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($summarybarang as $summ)
            <tr>
              <td>{{ $summ->prod_name }} {{ $summ->name }}</td>
              <td nowrap align="right"><b>{{ number_format($summ->barang,0,',','.') }}</b></td>
            </tr>
            @endforeach
            
          </tbody>
        </table>
        <hr>
        @endif
        <a href="/petugas/transaksihariini" class="menusxx"><button style="border-radius: 2rem;" class="btn btn-block btn-sm btn-primary">Lihat Detail</button></a>
    </div>
  </div>


  <!-- <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1.5rem;">
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
        <a href="/petugas/transaksihariinirupiah" class="menusxx"><button style="border-radius: 2rem;" class="btn btn-block btn-sm btn-primary">Lihat Detail</button></a>
    </div>
  </div> -->

  <div class="row">
    <div class="col-xl-6">
      <div class="card shadow-sm" style="padding: 1.5rem;border-radius: 1.5rem;">
        <div style="font-size: 15px;padding-bottom: 10px;font-weight: bold">
          10 TOP Total Pendaftaran Member
        </div>
        <table id="customers">
          <thead>
            <tr>
              <th>#</th>
              <th>Petugas</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @php $no=0; @endphp
            @foreach($petugastotal as $totpet)
            @php 
            $no++
            @endphp
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $totpet->name }}</td>
              <td nowrap align="right"><b>{{ number_format($totpet->member,0,',','.') }}</b></td>
            </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-xl-6">
      <div class="card shadow-sm" style="padding: 1.5rem;border-radius: 1.5rem;">
        <div style="padding-bottom:10px;">
          <label>Pilih Promo :</label>
          <select class="form-control" id="pilihpromo">
            @foreach($cekvoucher as $ckv)
            <option value="{{ $ckv->id }}">{{ $ckv->name }}</option>
            @endforeach
          </select>
        </div>
        <div id="links_container">

         @include('content.home.petugas.rincianvoucher')

        </div>
      </div>
    </div>

    <!-- <div class="col-xl-6">
      <div class="card shadow-sm" style="padding: 1.5rem;border-radius: 1.5rem;">
        <div style="padding-bottom:10px;">
          <label>Pilih Periode Bulan :</label>
          <select class="form-control" id="pilihbulan">
            <option value="01" {{ $blnnya == '01' ? 'selected' : '' }}>Januari</option>
            <option value="02" {{ $blnnya == '02' ? 'selected' : '' }}>Februari</option>
            <option value="03" {{ $blnnya == '03' ? 'selected' : '' }}>Maret</option>
            <option value="04" {{ $blnnya == '04' ? 'selected' : '' }}>April</option>
            <option value="05" {{ $blnnya == '05' ? 'selected' : '' }}>Mei</option>
            <option value="06" {{ $blnnya == '06' ? 'selected' : '' }}>Juni</option>
            <option value="07" {{ $blnnya == '07' ? 'selected' : '' }}>Juli</option>
            <option value="08" {{ $blnnya == '08' ? 'selected' : '' }}>Agustus</option>
            <option value="09" {{ $blnnya == '09' ? 'selected' : '' }}>September</option>
            <option value="10" {{ $blnnya == '10' ? 'selected' : '' }}>Oktober</option>
            <option value="11" {{ $blnnya == '11' ? 'selected' : '' }}>November</option>
            <option value="12" {{ $blnnya == '12' ? 'selected' : '' }}>Desember</option>
          </select>
        </div>
        <div id="links_container">

         @include('content.home.petugas.rincianmember')

        </div>
      </div>
    </div> -->
  </div>
  <br><br><br><hr>
@include('content.home.petugas.modal')
@include('layout.footer')

<script type="text/javascript">
  
  $( document ).ready(function() {

     setTimeout(function(){ window.location.reload() }, 50000);

});

  $('#pilihpromo').on('change', function () {

    $('.loading').attr('style','display: block');
    setTimeout(function(){ $('.loading').attr('style','display: none'); }, 500);

    var promo = $(this).val();

      $.get('/home/petugas/rincianvoucher?voucher='+promo+'', function(data) {
          document.getElementById('links_container').innerHTML = data;
      })
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

  function Approved(id){

    $('#konfirmasiapprove').modal('show');

    $.ajax({
      type: 'POST',
      url: "{{ route('stock.confirm') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': id,
      },
      success: function(data) {

        $('#idnya').val(id);

        var no = -1;
        var content_data = null;

        var wilayah = data[0]['wilayah_name'];

        $('#wilayahnya').html(wilayah);

        $.each(data, function() {
            no++;
            var qty = data[no]['qty'];
            var post_name = data[no]['post_name'];
            var prod_name = data[no]['prod_name'];

            content_data += '<tr>';
            content_data += '<td>'+prod_name+' '+post_name+'</td>';
            content_data += '<td><b style="font-size:15px;">'+qty+'</b></td>';
            content_data += '</tr>';

        });

        $('#barangnya').html(content_data);

      }

    });


  }

  function Approvenow(){

    $.ajax({
      type: 'POST',
      url: "{{ route('stock.approve') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#idnya').val(),
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Perpindahan Barang Berhasil di Approve!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1000);

      }
    });

  }

</script>

</body>

</html>
