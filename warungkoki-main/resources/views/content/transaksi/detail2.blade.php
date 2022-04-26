@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 19rem;">
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
              <h3>Rincian Transaksi {{ $jenis }}</h3>   
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
                      @if($trans->status == "BELUM BAYAR" || $trans->status == "NOT APPROVED")
                        <div class="text-warning" style="padding-top: 5px;"><b> BELUM BAYAR</b></div>
                      @elseif($trans->status == "KADALUARSA")
                        <div class="text-danger" style="padding-top: 5px;"><b> KADALUARSA</b></div>
                      @else
                        <div class="text-success" style="padding-top: 5px;"><b> SELESAI BAYAR</b></div>
                      @endif
                      <hr>
                      @if($trans->alamat_id != null)
                      <!-- ====== DELIVERY STATUS ==== -->
                        <b>Proses Pengiriman :</b>
                        <br>
                        @if($trans->delivery_name == "gojek" ||  $trans->delivery_name == "grab")
                          @if($trans->status == "DIPROSES" || $trans->status == "CONFIRMED" || $trans->status == "ALLOCATED")
                          <div style="padding-top:12px;">
                              <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-motorcycle" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                              <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                              <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                          </div>
                          <div class="text-warning" style="padding-top:8px;"><b> SEDANG DI PROSES</b></div>
                          <div style="font-size: 11px;">Barang sedang di proses dan di persiapkan oleh Seller </div>
                          @elseif($trans->status == "PICKING_UP" || $trans->status == "PICKED")
                          <div style="padding-top:10px;">
                              <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-truck" style="font-size: 24px;color: #dee2e6;"></i>&nbsp;&nbsp;
                              <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                          </div>
                          <div class="text-warning" style="padding-top:8px;"><b> DALAM PROSES PENJEMPUTAN</b></div>
                          <div style="font-size: 11px;">Kurir sedang dalam Proses Penjemputan ke Lokasi Seller </div>
                          @elseif($trans->status == "DROPPING_OFF")
                           <div style="padding-top:10px;">
                              <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-truck" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                          </div>
                          <div class="text-warning" style="padding-top:8px;"><b> DALAM PROSES PENGANTARAN KE BUYER</b></div>
                          <div style="font-size: 11px;">Barang sedang proses pengantaran ke Lokasi Buyer </div>
                          @elseif($trans->status == "BELUM BAYAR" || $trans->status == "NOT APPROVED")
                          <div class="text-danger" style="padding-top:8px;"><b> -</b></div>
                          @elseif($trans->status == "CANCEL")
                          <div class="text-danger" style="padding-top:8px;"><b> DIBATALKAN</b></div>
                          <div style="font-size: 11px;">Pengiriman Dibatalkan oleh Penjual/Seller. </div>
                          @elseif($trans->status == "KADALUARSA")
                          <div class="text-danger" style="padding-top:8px;"><b> -</b></div>
                          @else

                           <div style="padding-top:10px;">
                              <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-truck" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                              <i class="fa fa-home" style="font-size: 24px;color: #00AA13;"></i>
                          </div>
                          <div class="text-warning" style="padding-top:8px;"><b> SELESAI</b></div>
                          <div style="font-size: 11px;">Barang Sudah sampai ke Customer </div>
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
                      @endif
                      
                      
                      @if($trans->status == "CANCEL")
                      <b>Keterangan Seller :</b>
                      <br>
                      <div style="padding-top: 5px;">{{ $trans->ket }}</div>
                      <hr>

                      @endif
                      <b>Tanggal Pembelian :</b>
                      <br>
                      <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                      <hr>

                      <b>Toko :</b>
                      <br>
                      @if($wilayah->retailer_name == "")
                      <div style="padding-top: 5px;">{{ $wilayah->name }}</div>
                      @else
                      <div style="padding-top: 5px;">{{ $wilayah->retailer_name }} (Retailer)</div>
                      @endif
                      
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
                    <div class="card shadow-ss" style="margin-bottom: 6px;border-radius: 1rem;" >
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
                  @if($trans->alamat_id != null)
                  <div class="card shadow-ss" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" width="65%"><b>{{ strtoupper($saldo->delivery_name) }} {{ strtoupper($saldo->delivery_type) }}</b></td>
                            <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->delivery)  }}</b></td>
                          </tr>
                        </table>
                    </div>
                  </div>
                  @endif

                  <div class="card bg-iolo shadow-ss text-white" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;"><b>TOTAL BAYAR</b></td>
                            @if($trans->alamat_id != null)
                            <td align="right" style="font-size: 11px;"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>
                            @else
                            <td align="right" style="font-size: 11px;"><b>{{ rupiah($total)  }}</b></td>
                            @endif
                          </tr>
                        </table>
                    </div>
                  </div>

                  <!-- ===== DISKON ====== -->

                  <!-- @if($total >= 25000000)
                  @php $potongan = $total * 0.05; @endphp
                  <div class="card shadow-ss bg-success" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>DISKON 5%</b></td>
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total * 0.05) }}</b></td>
                          </tr>
                        </table>
                    </div>
                  </div>

                  @elseif($total >= 2500000)
                  @php $potongan = $total * 0.03; @endphp

                  <div class="card shadow-ss bg-success" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>DISKON 3%</b></td>
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total * 0.03) }}</b></td>
                          </tr>
                        </table>
                    </div>
                  </div>

                  @else
                  @php $potongan = 0; @endphp

                  <div class="card shadow-ss bg-success" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>DISKON 0%</b></td>
                            <td align="right" style="font-size: 11px;" class="text-white"><b>Rp 0</b></td>
                          </tr>
                        </table>
                    </div>
                  </div>

                  @endif

                  <div class="card shadow-ss bg-iolo" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>TOTAL BAYAR</b></td>
                            @if($trans->alamat_id != null)
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah(($total+$saldo->delivery) - $potongan)  }}</b></td>
                            @else
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total - $potongan)  }}</b></td>
                            @endif
                          </tr>
                        </table>
                    </div>
                  </div> -->
                @else

                  <!-- ========== DETAIL PRODUK YANG DIREEDEM ========== -->
                  <div style="font-size: 12px;"><b>Produk yang di Reedem :</b></div><br>
                  @foreach($saldos as $saldo)

                    @if($saldo->detail_status == 'SELESAI')
                    <div class="card shadow-sm bg-warung" style="margin-bottom: 6px;">
                      <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act) }}</b></td>
                            <td rowspan="2" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
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
                            <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act) }}</b></td>
                            <td width="2%"></td>
                            <td class="text-warning" style="font-size: 16px;" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
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
                
                @if($trans->status == "BELUM BAYAR" && $trans->type_bayar == 'Cash')
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
                            {!! DNS2D::getBarcodeHTML($trans->uuid, 'QRCODE'); !!}<br> <div style='font-size: 12px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="center"><b><div style="font-size: 11px">Tunjukan QRCODE ini Ke Petugas kami Yang Berjaga !</div></b></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                @endif

                @if($trans->alamat_id != null)
                <hr>
                <b>Dikirim Ke :</b>
                <br>
                <div style="padding-top: 5px;">
                  {{ $trans->penerima }} ({{ $trans->nohp }})
                  <div>{{ $trans->alamat }}  Kecamatan {{ $trans->district_name }} {{ $trans->regency_name }} Provinsi {{ $trans->prov_name }} {{ $trans->postal_code }}</div>
                </div>
                
                @endif

                <!-- ====== END BARCODE ====== -->

                @if($trans->type == "out" && $trans->status == "REEDEM")
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
                            {!! DNS2D::getBarcodeHTML($trans->uuid, 'QRCODE'); !!}<br> <div style='font-size: 12px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="center"><b><div style="font-size: 11px">Tunjukan QRCODE ini Ke Petugas kami Yang Berjaga !</div></b></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  
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
                  @if($trans->status == "NOT APPROVED")
                  <hr>
                  <div style="padding-top:10px;">
                    <input type="hidden" id="doku" value="{{ $trans->doku }}">
                    <button onclick="BayarSekarang({{ $trans->id }})" class="btn btn-block btn-success"><i class="fa fa-credit-card"></i> &nbsp;&nbsp;BAYAR SEKARANG</button>
                  </div>
                  @endif

                  @if($trans->status == "BELUM BAYAR" || $trans->status == "NOT APPROVED") 
                  <div style="padding-top:10px;font-size: 11px;color: red;"><i>
                    Transaksi Anda akan otomatis Kadaluarsa pada tanggal <b>{{ date('d F Y H:i', strtotime($trans->created_at . "+1 days")) }}</b></i>
                  </div>
                  @elseif($trans->status == "KADALUARSA")
                  @else
                    <hr>
                    <a target="_blank" href="/users/transaksi/invoice?id={{ $trans->id }}"><button class="btn btn-block btn-success"><i class="fa fa-file"></i>   Download Invoice</button></a>
                    @if(!$retur)
                    <div style="padding-top:10px;">
                    <button onclick="AjukanRetur({{ $trans->id }})" class="btn btn-block btn-danger"><i class="fa fa-history"></i> Ajukan Retur</button></div>
                    @else
                    <hr>
                    <div style="font-size: 12px;"><b>Proses Pengajuan Retur :</b></div>
                      @if($retur->status == "DIPROSES")
                      <div class="row">
                        <div class="col-8" style="padding-bottom: 3px;">
                          <div class="text-warning" style="padding-top: 5px;"><b> SEDANG DI PROSES</b></div>
                        </div>
                        <div class="col-4" style="padding-bottom: 3px;" align="right">
                          <button onclick="LihatRetur({{ $trans->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i> &nbsp;Lihat</button>
                        </div>
                        <div class="col-12" style="font-size:12px;"> 
                          Keterangan : Pengajuan Anda sedang di Proses oleh Tim Kami.
                        </div>
                      </div>
                      @elseif($retur->status == "DITOLAK")
                      <div class="row">
                        <div class="col-8" style="padding-bottom: 3px;">
                          <div class="text-danger" style="padding-top: 5px;"><b> PENGAJUAN ANDA DITOLAK</b></div>
                        </div>
                        <div class="col-4" style="padding-bottom: 3px;" align="right">
                          <button onclick="LihatRetur({{ $trans->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i> &nbsp;Lihat</button>
                        </div>
                        <div class="col-12" style="font-size:12px;"> 
                          Alasan Tolak  : {{ $retur->ketadmin }}
                        </div>
                      </div>
                      @else
                      <div class="row">
                        <div class="col-8" style="padding-bottom: 3px;">
                          <div class="text-success" style="padding-top: 5px;"><b> PENGAJUAN SELESAI</b></div>
                        </div>
                        <div class="col-4" style="padding-bottom: 3px;" align="right">
                          <button onclick="LihatRetur({{ $trans->id }})" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i> &nbsp;Lihat</button>
                        </div>
                        <div class="col-12" style="font-size:12px;"> 
                          Keterangan  : {{ $retur->ketadmin }}
                        </div>
                      </div>
                      @endif
                    @endif
                  @endif 

                  
                @else
                
                @endif
            </div>
          </div><br>
        </div>
      </div>
      @endif
    </div>
  @include('content.transaksi.modal')
  @include('layout.footer')
  <script type="text/javascript">
    
    function BayarSekarang(transid){

       // Kirim request ajax
      $.post("{{ route('xhome.bayaronline') }}",
      {
          _method: 'POST',
          _token: '{{ csrf_token() }}',
          note: 'Beli Delivery',
          order_type: 'Pembelian Delivery',
          transaction_id: transid,
      },
      function (data, status) {
          snap.pay(data.snap_token, {
              // Optional
              onSuccess: function (result) {
                  location.reload();
              },
              // Optional
              onPending: function (result) {
                  location.reload();
              },
              // Optional
              onError: function (result) {
                  location.reload();
              }
          });
      });

      return false;

  }

  function AjukanRetur(id){

    $('#idx').val(id);
    $('#retur').modal('show');

  }

  $("#uploadfoto").on("change", function() {

    var formData = new FormData();
    formData.append('file', $('#uploadfoto')[0].files[0]);

    $.ajax({
        url: "{{ route('transaksi.upload') }}",
        method:"POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,

        success:function(data) {

            if(data.status == '1'){

                $('.photos').html("<img width='100%' src='/assets/img_retur/"+data.name+"'><hr>"); 
                $('.imgs').val(data.name);         

            } else {

                swal({
                    title: "Gagal!",
                    text: "Pastikan File yang Anda Upload Benar!",
                    icon: "error",
                    buttons: false,
                    timer: 2000,
                });

                
            }
        }
    });

  });

  function Kirim(){

    if($('.imgs').val() == ""){

      swal({
        title: "Perhatikan",
        text: "Harap Upload Foto Terlebih dahulu!",
        icon: "error",
        buttons: false,
        timer: 2000,
      });

    } else {

      $.ajax({
        type: 'POST',
        url: "{{ route('transaksi.storeretur') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#idx').val(),
          'img': $('.imgs').val(),
          'ket': $('#ket').val(),
        },
        success: function(data) {


            $('#retur').modal('hide');

            swal({
              title: "Success",
              text: "Pengajuan Retur Berhasil Terkirim",
              icon: "success",
              buttons: false,
              timer: 2000,
            });

            setTimeout(function(){ window.location.reload(); }, 2000);

        }

      });
    }


  }

  function LihatRetur(id){

      $('#lihatretur').modal('show');

  }

  </script>

</body>

</html>