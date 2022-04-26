@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
  <div class="row">
    <div class="col-12" style="padding-bottom: 20px;">
        <div style="font-size: 11px" class="text-black">Selamat Datang Supervisor, <br><b style="font-size:18px;">{{ Auth::user()->name }}</b></div>
        <hr>
    </div>
    <div class="col" style="padding-bottom: 0px;">

      @if($stokpendings->count() != 0)

      <div class="card shadow-ss bg-danger" style="border-radius: 1rem;">
        <div class="card-body">
          <div style="font-size:14px;"><b class="text-white">Approve Perubahan Stok</b></div>
          <div style="font-size:11px;color: white;">Tanggal {{ date('d F Y') }}</div>
          <hr>

          @foreach($stokpendings as $pend)

          <div class="card shadow-ss" style="border-radius: 1.5rem;">
            <div class="card-body">

              <div class="row">
                <div class="col-7" style="padding-bottom:0px;padding-right: 0px;">
                  <div style="font-size: 11px;">
                      Perubahan Stock :
                  </div>
                  @if($pend->type == "cek")

                    @if($pend->jenis == "awal")
                      <div style="font-size:14px;"><b>Input Stok Pagi/Awal</b></div>
                    @else
                      <div style="font-size:14px;"><b>Input Stok Malam/Akhir</b></div>
                    @endif

                  @elseif($pend->type == "in")

                    @if($pend->jenis == "pemasukan")
                      <div style="font-size:14px;"><b>Input Barang Masuk</b></div>
                    @elseif($pend->jenis == "intratoko")
                      <div style="font-size:14px;"><b>Masuk Antar Gudang</b></div>
                    @else

                    @endif

                  @else

                    @if($pend->jenis == "intratoko")
                      <div style="font-size:14px;"><b>Keluar Antar Gudang</b></div>
                    @else
                      <div style="font-size:14px;"><b>Retur Barang</b></div>
                    @endif

                  @endif
                  <div style="font-size: 11px;">
                     dari Wilayah {{ $pend->wilayah_name }} oleh {{ $pend->username }}
                  </div>
                </div>
                <div class="col-5" style="padding-bottom:0px;padding-top: 12px;">
                  <button onclick="Approved({{ $pend->id }})" style="border-radius:2rem;" class="btn btn-success btn-block btn-sm"> 
                      Approve
                  </button>
                </div>
              </div>

            </div>
          </div>
          <div style="padding-top: 10px;"></div>
          @endforeach

        </div>
      </div>
      <br>
      @endif

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
              <div class="col-8" style="padding-bottom:0px;">
                <div style="font-size: 13px;" class="text-white">
                  <b>SISA KESELURUHAN!</b>
                </div>
                <div style="font-size: 11px;" class="text-white">
                  {{ $moncek->name }}
                </div>
              </div>
              <div class="col-4" style="padding-bottom:0px;padding-left: 0px;" align="right">
                <div style="font-size:30px" class="text-white"><b>{{ number_format($sisa,0,',','.') }}</b></div>
              </div>
            </div>
          </div>
        </div>
        <br>
        @endforeach

      @endif

      <!-- ======= MENU ====== -->

      <div class="row">
  
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
            <a href="/stocks" class="menusxx">
              <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;">
                  <table width="100%">
                      <tr>
                          <td align="center">
                              <i style="color:#fb6340; font-size:26px;" class="fa fa-inbox"></i>
                          </td>
                      </tr>
                      <tr>
                          <td align="center">
                              <div style="font-size: 11px; padding-top: 10px;color: #525f7f; ">Monitoring<br> Stock</div>
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
          <a href="/transaksi/supervisor" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-handshake"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Transaksi <br> Penjualan</div>
                        </td>
                    </tr>
                </table>
            </div>
          </a>
        </div>

        <div class="col-4">
          <a href="#" class="menusxx">
            <div class="card-body shadow-ss bg-white" style="border-radius: 1rem;padding: 1rem 0.8rem;" >
                <table width="100%">
                    <tr>
                        <td align="center">
                            <i style="color:#fb6340; font-size:26px;" class="fa fa-briefcase"></i>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div style="font-size: 11px; padding-top: 10px;color: #525f7f ">Transaksi <br> Pending</div>
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

  </div>
  <br><br><br><hr>
<div class="modal fade" id="konfirmasiapprove" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom:0px;">
                <h3 class="modal-title" id="modal-title-default">&nbsp;</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top:0px;">
                <table border="0" align="center" width="100%">
                    <tr><td>
                        <div style="font-size:18px;"><b>APPROVE PERUBAHAN STOK</b></div>
                    </td></tr>
                    <tr>
                        <td><h5 class="text-muted">Apakah Anda Yakin Akan Approve Perubahan Stok ini?</h5></td>
                    </tr>
                </table>
                <input type="hidden" id="idstock">
                <hr>
                  <div id="links_container22">
                    @include('content.home.supervisor.rincian')
                  </div>
                <hr>
                <div class="row">
                    <div class="col-6" style="padding-bottom: 0px;">
                        <button type="button" onclick="Tolak();" class="btn btn-danger ml-auto btn-block" data-dismiss="modal">Tolak</button>
                    </div>
                    <div class="col-6" style="padding-bottom: 0px;">
                        <button type="button" onclick="Approvenow();" class="btn btn-block btn-success">Approve</button> 
                    </div>
                </div> 
            </div>
            
        </div>
    </div>
</div>
@include('layout.footer')

<script type="text/javascript">


  function Approved(id){

    $('#idstock').val(id);

    $('.loading').attr('style','display: block');
    setTimeout(function(){ $('.loading').attr('style','display: none'); }, 500);

    $.get('/home/supervisor/rincian?id='+id+'', function(data) {
      document.getElementById('links_container22').innerHTML = data;
    })

    $('#konfirmasiapprove').modal('show');


  }

  function Approvenow(){

    $.ajax({
      type: 'POST',
      url: "{{ route('perubahanstock.approve') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#idstock').val(),
        'sebelumnyaid': $('#sebelumnyaid').val(),
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Perubahan Stok Berhasil di Approve!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1000);

      }
    });

  }

  function Tolak(){

    $.ajax({
      type: 'POST',
      url: "{{ route('perubahanstock.tolak') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#idstock').val(),
        'sebelumnyaid': $('#sebelumnyaid').val(),
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Perubahan Stok Berhasil di Tolak!",
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
