@include('xhome.layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-deliver pt-4 pt-md-8" style="padding-bottom: 14rem;">
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
              <h3 class="text-white">Rincian Transaksi {{ $jenis }}</h3>   
          </div>
          <br>

          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Status :</b>
                @if($trans->delivery_name == "gojek" ||  $trans->delivery_name == "grab")
                  @if($trans->status == "DIPROSES")
                  <div style="padding-top:12px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                  </div>
                  <div class="text-warning" style="padding-top:8px;"><b> MENUNGGU KONFIRMASI</b></div>
                  <div style="font-size: 11px;">Menunggu konfirmasi pesanan oleh Penjual </div>
                  @elseif($trans->status == "CONFIRMED" || $trans->status == "ALLOCATED")
                  <div style="padding-top:12px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                  </div>
                  <div class="text-warning" style="padding-top:8px;"><b> SEDANG DI PROSES</b></div>
                  <div style="font-size: 11px;">Barang sedang di proses dan di persiapkan oleh Penjual </div>
                  @elseif($trans->status == "PICKING_UP" || $trans->status == "PICKED")
                  <div style="padding-top:10px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                  </div>
                  <div class="text-warning" style="padding-top:8px;"><b> PROSES PENJEMPUTAN</b></div>
                  <div style="font-size: 11px;">Kurir sedang dalam Proses Penjemputan ke Lokasi Penjual </div>
                  @elseif($trans->status == "DROPPING_OFF")
                   <div style="padding-top:10px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                  </div>
                  <div class="text-warning" style="padding-top:8px;"><b> PROSES PENGANTARAN</b></div>
                  <div style="font-size: 11px;">Barang sedang proses pengantaran ke Lokasi Pelanggan </div>
                  @elseif($trans->status == "BELUM BAYAR")
                  <div style="padding-top:10px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                  </div>
                  <div class="text-danger" style="padding-top:8px;"><b> BELUM BAYAR</b></div>
                  <div style="font-size: 11px;">Harap Anda membayar terlebih dahulu sesuai dengan tagihan yg ada agar proses transaksi dapat dilanjutkan. </div>
                  @elseif($trans->status == "CANCEL")
                  <div class="text-danger" style="padding-top:8px;"><b> DIBATALKAN</b></div>
                  <div style="font-size: 11px;">Pengiriman Dibatalkan oleh Penjual/Seller. </div>
                  @else

                   <div style="padding-top:10px;">
                      <i class="fa fa-user" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-truck" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                      <i class="fa fa-home" style="font-size: 24px;color: #00AA13;"></i>
                  </div>
                  <div class="text-warning" style="padding-top:8px;"><b> SELESAI</b></div>
                  <div style="font-size: 11px;">Barang Sudah sampai ke Pelanggan </div>
                  @endif

                  
                @else

                  @if($trans->status == "DIPROSES")
                  <div class="text-warning" style="padding-top: 5px;"><b> SEDANG DI PROSES</b></div>
                  @elseif($trans->status == "DELIVERY")
                    <div class="text-warning" style="padding-top: 5px;"><b> SEDANG DALAM PERJALANAN</b></div>
                  @elseif($trans->status == "APPROVED" || $trans->status == "DELIVERED")
                    <div class="text-success" style="padding-top: 5px;"><b> SELESAI</b></div>
                  @else
                    <div class="text-warning" style="padding-top: 5px;"><b> {{ $trans->status }}</b></div>
                  @endif

                @endif
                
                <hr>
                @if($trans->status == "CANCEL")
                <b>Keterangan Seller :</b>
                <br>
                <div style="padding-top: 5px;">{{ $trans->ket }}</div>
                <hr>

                @endif
                <b>Toko :</b>
                <br>
                <div style="padding-top: 5px;">{{ $wilayah->name }}</div>
                <hr>

                <b>Tanggal Pembelian :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                <hr>
                @if($trans->jam != null)
                <b>Rencana Jam Pengiriman :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b style="font-size: 14px;">{{ $trans->jam }}</b></div>
                <hr>
                @endif
              </div>

                <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->

              <div><b>Produk yang di Beli :</b></div><br>
              @php $total=0; @endphp
              @foreach($saldos as $saldo)

                @php
                $total += $saldo->amount;

                @endphp
                <div class="card shadow-ss" style="margin-bottom: 6px;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" width="65%"><b>{{ $saldo->qty  }} {{ $saldo->prod_name }} {{ $saldo->name }} @ {{ rupiah($saldo->amount / $saldo->qty) }}</b></td>
                          <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->amount)  }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>
              @endforeach
              <div class="card shadow-ss" style="margin-bottom: 6px;">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" width="65%"><b>Delivery @if($saldo->delivery_name == "tomx") TOMX @else OJOL @endif</b></td>
                        <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              <div class="card shadow-ss bg-deliver">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" class="text-white">TOTAL</td>
                        <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              <hr>
              <b>Dikirim Ke :</b>
              <br>
              <div style="padding-top: 5px;">
                {{ $trans->penerima }} ({{ $trans->nohp }})
                <div>{{ $trans->alamat }}  Kecamatan {{ $trans->district_name }} {{ $trans->regency_name }} Provinsi {{ $trans->prov_name }} {{ $trans->postal_code }}</div>
              </div>
              <hr>
              @if($trans->status != "DIPROSES")

                @php
                  $delv = DB::table('transaction_delivery')
                  ->where('transaction_id', $trans->id)
                  ->first();

                @endphp

              <b>Kurir :</b>
              <br>
              <div style="padding-top: 5px;">{{ $delv->kurir_name }} ({{ $delv->nohp }})</div>
              <hr>
              <b>Foto Proses Delivery :</b>
              <br>
              <div style="padding-top: 8px;">
                <img width="100%" src="/assets/img_delivery/{{ $delv->photo }}">
              </div>
              <hr>

                @if($delv->selesai != null)
                  <b>Foto Selesai Delivery :</b>
                  <br>
                  <div style="padding-top: 8px;">
                    <img width="100%" src="/assets/img_delivery/{{ $delv->selesai }}">
                  </div>
                  <hr>

                @endif
              @endif

            </div>
          </div><br>
          @if($trans->status == "DELIVERY")
          <button onclick="Selesai({{ $trans->id }})" class="btn btn-success btn-block"> Sudah Sampai</button>
          @endif
        </div>
      </div>
    </div>

  @include('xhome.layout.footer')
  @include('xhome.history.modal')
</body>

<script type="text/javascript">

  function Selesai(id){

    $('#id').val(id);
  
    $('#konfirmasi').modal('show');

  }

  function YakinUtama(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xhome.history.selesai') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#id').val(),
      },
     success: function(data) {

      swal({
          title: "Berhasil",
          text: "Pesanan Anda sudah Selesai!",
          icon: "success",
          buttons: false,
          timer: 2000,
      });

      setTimeout(function(){ window.location.href = '/xhome/history'; }, 1500);

     }

   });

  }

</script>

</html>