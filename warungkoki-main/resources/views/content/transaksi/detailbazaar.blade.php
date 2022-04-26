@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-bazaar pt-4 pt-md-8" style="padding-bottom: 14rem;">
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

          @if($saldos->count() == '0')
            <div class="card shadow">
                <div class="card-body">
                  <h5>Waktu Pembelian Anda Sudah Expired.</h5>
                </div>
            </div>
          @else

          <div class="card shadow">
            <div class="card-body">
                @if($trans->type == "in")
                    <div style="padding-bottom: 16px;">
                      <b>Status :</b>
                      <br>
                      @if($trans->status == "NOT APPROVED")
                        <div class="text-warning" style="padding-top: 5px;"><b> BELUM BAYAR</b></div>
                      @elseif($trans->status == "KADALUARSA")
                        <div class="text-danger" style="padding-top: 5px;"><b> KADALUARSA</b></div>
                      @else
                        <div class="text-success" style="padding-top: 5px;"><b> SELESAI BAYAR</b></div>
                      @endif
                      <hr>

                      <b>Tanggal Pembelian :</b>
                      <br>
                      <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                      <hr>

                      <!-- <b>Pembayaran Mala :</b>
                      <br>
                      </div>
                      @if($trans->type_bayar == 'CASH')
                        <span class="badge badge-primary"><i class="fa fa-gift"></i> BAYAR CASH</span>
                      @else
                        <span class="badge badge-info"><i class="fa fa-laptop"></i> BAYAR ONLINE</span>
                      @endif

                      <span class="badge badge-primary"><i class="fa fa-calendar"></i> {{ date('d M Y', strtotime($trans->created_at)) }}</span> -->
                    </div>

                    <!-- @if($trans->type_bayar == 'CASH')
                    <div style="font-size: 10px;padding-bottom: 10px;">Pembayaran ini harus dilakukan pada outlet <b>@foreach($wilayah as $lokasi) {{ $lokasi->name }} @endforeach</b></div>
                    @endif -->

                @else

                  <div style="font-size: 12px;padding-bottom: 10px;">
                    <b>Status :</b>
                    <br>
                    @if($trans->status == "REEDEM")
                      @if($trans->alamat_id != null)
                        <div class="text-warning" style="padding-top: 5px;"><b> PROSES REVIEW ADMIN</b></div>
                      @else
                        <div class="text-warning" style="padding-top: 5px;"><b> PROSES REDEEM</b></div>
                      @endif
                      
                    @elseif($trans->status == "DITOLAK")
                      <div class="text-danger" style="padding-top: 5px;"><b> DELIVERY DITOLAK</b></div>
                    @elseif($trans->status == "REEDEM DISETUJUI")
                      <div class="text-success" style="padding-top: 5px;"><b> DELIVERY DISETUJUI</b></div>
                    @elseif($trans->status == "KADALUARSA")
                      <div class="text-danger" style="padding-top: 5px;"><b> KADALUARSA</b></div>
                    @else
                      <div class="text-success" style="padding-top: 5px;"><b> SELESAI REDEEM</b></div>
                    @endif
                    <hr>
                    <b>Tanggal Transaksi :</b>
                    <br>
                    <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                    <hr>
                    <b>Ambil Barang di :</b>
                    <br>
                    @if($trans->alamat_id == null)
                      <div style="padding-top: 5px;">@foreach($wilayah as $lokasi) {{ $lokasi->name }} @endforeach</div>
                    @endif
                    <hr>
                    @if($trans->plan != '' || $trans->plan != null)
                      <b>Rencana Ambil :</b>
                      <br>
                      <div style="padding-top: 5px;" class="text-success"><b>{{ date('d F Y H:i', strtotime($trans->plan)) }}</b></div>
                      <hr>
                    @endif

                    @if($trans->ket != '' || $trans->ket != null)
                      <b>Keterangan Ambil :</b>
                      <br>
                      <div style="padding-top: 5px;">{{ $trans->ket }}</div>
                      <hr>
                    @endif

                  </div>
                  

                  <!-- @if($trans->status == 'REEDEM DISETUJUI')
                    <div style="font-size: 10px;"><b>Reedem Delivery Anda Sudah Disetujui, Barang Pesanan Anda akan segera dikirim sesuai dengan Rencana Reedem Anda!</b></div>
                  @endif -->

                  

                
                @endif

                <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->

                @if($trans->type == "in")
                  <div style="font-size: 12px;"><b>Produk yang di Beli :</b></div><br>
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
                    <div class="card shadow-ss bg-iolo">
                      <div class="card-body">
                          <table width="100%">
                            <tr>
                              <td style="font-size: 11px;" class="text-white">TOTAL</td>
                              <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total)  }}</b></td>
                            </tr>
                          </table>
                      </div>
                    </div>
                @else

                  <!-- ========== DETAIL PRODUK YANG DIREEDEM ========== -->
                  <div style="font-size: 12px;"><b>Produk yang di Reedem :</b></div><br>
                  @foreach($saldos as $saldo)

                    @if($saldo->detail_status == 'SELESAI')
                    <div class="card shadow-sm bg-kuning" style="margin-bottom: 6px;">
                      <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act + ceil($saldo->harga_act * (float)$service->biaya / 100)) }}</b></td>
                            <td rowspan="2" align="right" width="5%"><b>{{ $saldo->qty  }}</b></td>
                          </tr>
                          <tr>
                            <td align="left" style="font-size: 10px;">
                              <i>Sudah Selesai di Reedem</i>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    @else
                    <div class="card shadow-sm" style="margin-bottom: 6px;">
                      <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act + ceil($saldo->harga_act * (float)$service->biaya / 100)) }}</b></td>
                            <td width="2%"></td>
                            <td class="text-warning" style="font-size: 16px;" align="right" width="5%"><b>{{ $saldo->qty  }}</b></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    @endif
                  @endforeach

                  <!-- @if($trans->alamat_id != null)
                  <br><div style="font-size: 12px;"><b>Dikirim Ke Alamat :</b></div>
                  @php

                    $alamatc = DB::table('alamat')
                    ->select("alamat.*", "regencies.name as regency_name","provinces.name as prov_name")
                    ->leftJoin("regencies", "alamat.regency_id", "=", "regencies.id")
                    ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
                    ->where("alamat.id", $trans->alamat_id)
                    ->first();

                  @endphp
                  <br><div class="card shadow-ss">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td width="25%" rowspan="3">
                            <div  class="bulat icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                              <i class="fas fa-home" style="color: #ffffff"></i>
                          </div>
                          </td>
                          <td><b><div style="font-size: 15px">{{ $alamatc->judul }}</div></b></td>
                        </tr>
                        <tr>
                          <td>
                            <div style="font-size: 10px">{{ $alamatc->alamat }}</div>
                          </td>
                        </tr>
                        <tr>
                          <td style="padding-top: 8px;">
                            <span class="badge badge-pill badge-primary" style="font-size: 8px;"><i class="fa fa-building"></i>  {{ $alamatc->regency_name }}</span> 
                            <span class="badge badge-pill badge-warning" style="font-size: 8px;"><i class="fa fa-home"></i>  {{ $alamatc->prov_name }}</span>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  @endif -->
                @endif


                <!-- ====== BARCODE ======== -->
                
                @if($trans->type == "in")
                  @if($trans->status == "NOT APPROVED" && $trans->type_bayar == 'CASH')
                    <hr>
                    <div style="font-size: 12px;"><b>Barcode :</b></div><br>
                    <div class="card shadow-ss">
                      <div class="card-body" >
                        @if($tour->transdetail != 1)
                        <table width="100%" class="pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Barcode ini yang diberikan ke Petugas untuk Bertransaksi">
                        @else
                        <table width="100%">
                        @endif
                          <tr>
                            <td align="center">
                              <img width='100%' alt='barcode' src='https://tomxperience.id/assets/barcode/barcode.php?codetype=Code128&size=85&text={{ $trans->uuid }}'><br> <div style='padding-top: 15px;font-size: 11px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                            </td>
                          </tr>
                          <tr>
                            <td align="center"><b><div style="font-size: 11px">Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</div></b></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  @endif

                @else
                  @if($trans->status == "REEDEM" || $trans->status == "REEDEMREWARD" || $trans->status == "REEDEM DISETUJUI")
                  <hr>
                  <div style="font-size: 12px;"><b>Barcode :</b></div><br>
                  <div class="card shadow-ss">
                    <div class="card-body" >
                      @if($tour->transdetail != 1)
                      <table class="pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Barcode ini yang diberikan ke Petugas untuk Bertransaksi">
                      @else
                      <table>
                      @endif
                        <tr>
                          <td>
                            <img width='100%' alt='barcode' src='https://tomxperience.id/assets/barcode/barcode.php?codetype=Code128&size=85&text={{ $trans->uuid }}'><br> <div style='padding-top: 15px;font-size: 15px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="center"><b><div style="font-size: 11px">Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</div></b></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  @endif

                @endif
                  

                <!-- ====== END BARCODE ====== -->

                @if($trans->type == "out" && $trans->status == "REEDEM")
                <br><div class="card shadow-ss" style="background-color: #fb6340;">
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
                              Jika barang tidak diambil sesuai rencana pengambilan, maka Saldo akan otomatis terpotong di keesokan hari nya.
                            </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                @elseif($trans->type == "in")
                  @if($trans->status != "NOT APPROVED")
                    <hr><div style="font-size: 12px;"><b>Invoice :</b></div><br>
                    <a target="_blank" href="/users/transaksi/invoice?id={{ $trans->id }}"><button class="btn btn-block btn-success"><i class="fa fa-file"></i>   Download Invoice</button></a>
                  @endif 
                @else
                
                @endif
            </div>
          </div><br>
        </div>
      </div>
      @endif
    </div>

  @include('layout.footer')

</body>

</html>