@if(Auth::user())
@include('layout.head')
@else
@include('layout.head2')
@endif
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 15rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/users/transaksi"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-xl-0">
          <div class="row justify-content-center">
              <h3>Rincian Transaksi {{ $trans->type_bayar == 'Saldo Reedem Poin' ? 'Penukaran Poin' : $jenis }}</h3>   
          </div>
          <br>
          @if($saldos->count() == '0')
            <div class="card shadow">
                <div class="card-body">
                  <h5>Waktu Pembelian Anda Sudah Expired.</h5>
                </div>
            </div>
          @else

          <div class="card shadow" style="border-radius: 1rem;">
            <div class="card-body">
                <div style="padding-bottom: 16px;">
                  <b>Status :</b>
                  <br>
                  @if($trans->status == "BELUM BAYAR" || $trans->status == "NOT APPROVED")
                    <div class="text-warning" style="padding-top: 5px;"><b> BELUM BAYAR</b></div>
                  @elseif($trans->status == "KADALUARSA")
                    <div class="text-danger" style="padding-top: 5px;"><b> KADALUARSA</b></div>
                  @elseif($trans->status == "PENDING")
                    <div class="text-warning" style="padding-top: 5px;"><b> MENUNGGU PERSETUJUAN PETUGAS</b>
                    @if($user->role_id == '3')
                    <button class="btn btn-sm btn-info" id="btn_approve_transaksi" style="float:right;">APPROVE</button>
                    @endif
                    </div>
                  @elseif($trans->status == "REEDEM")
                    <div class="text-primary" style="padding-top: 5px;"><b> PROSES PENGAMBILAN</b></div>
                  @else
                    @if($trans->undian_name == NULL)
                      <div class="text-success" style="padding-top: 5px;"><b> SELESAI BAYAR</b></div>
                    @else
                      <div class="text-success" style="padding-top: 5px;"><b> SELESAI PENGAMBILAN</b></div>
                    @endif
                  @endif


                  <!-- ====== JIKA DIA PENGIRIMAN ===== -->
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
                      <div style="font-size: 11px;">Kurir sedang dalam Proses Penjemputan ke Lokasi Penjual </div>
                      @elseif($trans->status == "DROPPING_OFF")
                        <div style="padding-top:10px;">
                          <i class="fa fa-archive" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                          <i class="fa fa-motorcycle" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                          <i class="fa fa-truck" style="font-size: 24px;color: #00AA13;"></i>&nbsp;&nbsp;
                          <i class="fa fa-home" style="font-size: 24px;color: #dee2e6;"></i>
                      </div>
                      <div class="text-warning" style="padding-top:8px;"><b> DALAM PROSES PENGANTARAN KE PELANGGAN</b></div>
                      <div style="font-size: 11px;">Barang sedang proses pengantaran ke Lokasi Pelanggan </div>
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
                      <div class="text-warning" style="padding-top: 5px;"><b> MENUNGGU KONFIRMASI DARI PENJUAL</b></div>
                      @elseif($trans->status == "ALLOCATED")
                        <div class="text-warning" style="padding-top: 5px;"><b> BARANG SEDANG DIPROSES OLEH PENJUAL</b></div>
                      @elseif($trans->status == "DELIVERY")
                        <div class="text-warning" style="padding-top: 5px;"><b> BARANG SEDANG DALAM PERJALANAN</b></div>
                      @elseif($trans->status == "APPROVED" || $trans->status == "DELIVERED")
                        <div class="text-success" style="padding-top: 5px;"><b> SELESAI</b></div>
                      @else
                        <div class="text-warning" style="padding-top: 5px;"><b> {{ $trans->status }}</b></div>
                      @endif

                    @endif
                    <hr>
                  @endif

                  <!-- ==== SELESAI PENGIRIMAN ==== -->
                  
                  @if($trans->status == "CANCEL")
                  <b>Keterangan Seller :</b>
                  <br>
                  <div style="padding-top: 5px;">{{ $trans->ket }}</div>
                  <hr>
                  @endif

                  @if($trans->undian_name == NULL)
                  <b>Tanggal Pembelian :</b>
                  <br>
                  <div style="padding-top: 5px;">{{ date('d F Y H:i', strtotime($trans->created_at)) }}</div>
                  <hr>
                  @endif

                  <b>Toko :</b>
                  <br>
                  <div style="padding-top: 5px;">{{ $wilayah->name }}</div>
                  <hr>

                  @if($trans->undian_name == NULL)
                    <b>Pembayaran Malalui :</b>
                    <br>
                    @if($trans->type_bayar == 'Cash')
                      <div style="padding-top: 5px;">Bayar Cash</div>
                    @elseif($trans->type_bayar == 'ONLINE')
                      <div style="padding-top: 5px;">GO-PAY</div>
                    @elseif($trans->type_bayar == 'QRIS')
                      <div style="padding-top: 5px;">QRIS</div>
                    @elseif($trans->type_bayar == 'OVO')
                      <div style="padding-top: 5px;">OVO</div>
                    @else
                      <div style="padding-top: 5px;">Saldo Warungkoki</div>
                    @endif
                    <hr>

                  @else

                    <b>Hadiah dari :</b>
                    <br>
                    <div style="padding-top: 5px;">Undian {{ $trans->undian_name }}</div>
                    <hr>
                  @endif
                </div>


                <!-- <div style="font-size: 12px;padding-bottom: 10px;">
                  <b>Status :</b>
                  <br>
                  @if($trans->status == "REEDEM" || $trans->status == "PENDING")
                    @if($trans->alamat_id != null)
                      <div class="text-warning" style="padding-top: 5px;"><b> MENUNGGU PERSETUJUAN PETUGAS</b></div>
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
                    <div style="padding-top: 5px;"> {{ $wilayah->name }}</div>
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

                </div> -->

                <!-- @if($trans->status == 'REEDEM DISETUJUI')
                  <div style="font-size: 10px;"><b>Reedem Delivery Anda Sudah Disetujui, Barang Pesanan Anda akan segera dikirim sesuai dengan Rencana Reedem Anda!</b></div>
                @endif -->

                <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->
                @if($trans->undian_name != NULL || $trans->status == "REEDEM")
                  <div style="font-size: 12px;"><b>Produk yang di Ambil :</b></div><br>
                @else
                  <div style="font-size: 12px;"><b>Produk yang di Beli :</b></div><br>
                @endif
                
                @php $total=0; @endphp
                @foreach($saldos as $saldo)

                  @php
                  $total += round($saldo->amount);

                  @endphp
                  <div class="card shadow-ss" style="margin-bottom: 6px;border-radius: 1rem;" >
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                          @if($trans->type_bayar == 'Saldo Reedem Poin')
                            <td style="font-size: 11px;" width="65%"><b>({{ $saldo->qty  }}) {{ $saldo->prod_name }} {{ $saldo->name }} @ {{ round($saldo->amount / $saldo->qty) }} <img width="15px;" src="/assets/content/img/icons/padi.png"></b></td></b></td>
                            <td align="right"  style="font-size: 11px;"><b>{{ round($saldo->amount)  }} <img width="25px;" src="/assets/content/img/icons/padi.png"></b></td>

                          @elseif($trans->undian_name != NULL || $trans->status == "REEDEM")
                            <td style="font-size: 11px;" width="65%"><b>{{ $saldo->prod_name }} {{ $saldo->name }}</b></td>
                            <td align="right"  style="font-size: 11px;"><b class="text-warning">{{ $saldo->qty  }}</b></td>
                          @else
                            <td style="font-size: 11px;" width="65%"><b>{{ $saldo->prod_name }} {{ $saldo->name }}</b></td>
                            <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->amount)  }} </b></td>
                          @endif
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

                @if($potongan)

                  @if($potongan->jenis == "cashback")

                  @else

                    @if($potongan->amount == NULL)

                      <div class="card shadow-ss bg-danger" style="margin-bottom: 6px;border-radius: 1rem;">
                        <div class="card-body">
                            <table width="100%">
                              <tr>
                                <td style="font-size: 11px;color: white;" width="65%"><b>Potongan Voucher - {{ $potongan->percent }}%</b></td>
                                <td align="right"  style="font-size: 11px;color: white;"><b>- {{ rupiah($total * ($potongan->percent/100))  }}</b></td>
                              </tr>
                            </table>
                        </div>
                      </div>


                    @else

                      <div class="card shadow-ss bg-danger" style="margin-bottom: 6px;border-radius: 1rem;">
                        <div class="card-body">
                            <table width="100%">
                              <tr>
                                <td style="font-size: 11px;color: white;" width="65%"><b>Potongan Voucher</b></td>
                                <td align="right"  style="font-size: 11px;color: white;"><b>- {{ rupiah($potongan->amount)  }}</b></td>
                              </tr>
                            </table>
                        </div>
                      </div>

                    @endif

                  @endif

                @endif

                @if($trans->undian_name == NULL && $trans->status != "REEDEM")

                <div class="card shadow-ss bg-iolo" style="margin-bottom: 6px;border-radius: 1rem;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" class="text-white"><b>TOTAL</b></td>
                          @if($trans->alamat_id != null)

                            @if($potongan)

                              @if($potongan->jenis == "cashback")
                                <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>
                              @else

                                @if($potongan->amount == NULL)
                                  <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery-($total* ($potongan->percent/100)))  }}</b></td>
                                @else
                                  <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery-$potongan->amount)  }}</b></td>
                                @endif
                                
                              @endif        

                            @else

                              <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>

                            @endif

                          @else

                            @if($potongan)

                              @if($potongan->jenis == "cashback")
                                <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total)  }}</b></td>
                              @else
                                @if($potongan->amount == NULL)
                                  <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total-($total* ($potongan->percent/100)))  }}</b></td>
                                @else
                                  <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total-$potongan->amount)  }}</b></td>
                                @endif
                              @endif
                            
                            @else
                              @if($trans->type_bayar == 'Saldo Reedem Poin')
                                <td align="right" style="font-size: 11px;" class="text-white"><b>{{ round($total)  }} <img width="25px;" src="/assets/content/img/icons/padi.png"></b></td>
                              @else
                                <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total)  }}</b></td>
                              @endif
                            @endif
                          
                          @endif
                        </tr>
                      </table>

                  </div>
                </div>

                @endif

                @if($potongan)
                  @if($potongan->jenis == "cashback")
                    <div style="padding-top:10px;" class="text-success" align="center"><i><b>Potensi Cashback sebesar {{ rupiah($potongan->amount) }}</b></i></div>
                  @endif
                @endif

                <!-- ===== DISKON ====== -->

                @if($trans->diskon != null)

                  <div class="card shadow-ss bg-success" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>DISKON {{ $trans->diskon }}</b></td>
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total * ((int)$trans->diskon/100)) }}</b></td>
                          </tr>
                        </table>
                    </div>
                  </div>

                  <div class="card shadow-ss bg-iolo" style="margin-bottom: 6px;border-radius: 1rem;">
                    <div class="card-body">
                        <table width="100%">
                          <tr>
                            <td style="font-size: 11px;" class="text-white"><b>TOTAL BAYAR</b></td>
                            @if($trans->alamat_id != null)
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah(($total+$saldo->delivery) - $potongan)  }}</b></td>
                            @else
                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total - ($total * ((int)$trans->diskon/100)))  }}</b></td>
                            @endif
                          </tr>
                        </table>
                    </div>
                  </div>

                  <!-- ========== DETAIL PRODUK YANG DIREEDEM ========== -->
                  <div style="font-size: 12px;"><b>Produk yang di Reedem :</b></div><br>
                  @foreach($saldos as $saldo)

                    @if($saldo->detail_status == 'SELESAI')
                    <div class="card shadow-sm bg-warung" style="margin-bottom: 6px;">
                      <div class="card-body">
                        <table width="100%">
                          <tr>
                            @if($trans->type_bayar == 'Saldo Reedem Poin')
                              <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ round($saldo->harga_act) }} <img width="25px;" src="/assets/content/img/icons/padi.png"></b></td></b></td>
                              <td rowspan="2" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
                            @else
                              <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act) }}</b></td>
                              <td rowspan="2" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
                            @endif
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
                            @if($trans->type_bayar == 'Saldo Reedem Poin')
                              <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ round($saldo->harga_act) }}</b></td>
                              <td width="2%"></td>
                              <td class="text-warning" style="font-size: 16px;" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
                            @else
                              <td style="font-size: 11px;"><b>{{ $saldo->prod_name }} - {{ $saldo->name }} @ {{ rupiah($saldo->harga_act) }}</b></td>
                              <td width="2%"></td>
                              <td class="text-warning" style="font-size: 16px;" align="right" width="5%"><b>{{ $saldo->qty >= 1000 ? number_format($saldo->qty,0,',','.') : $saldo->qty  }}</b></td>
                              
                            @endif
                          </tr>
                        </table>
                      </div>
                    </div>
                    @endif
                  @endforeach

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
                  @if($transdel)

                    <hr>
                    <b>Kurir Toko :</b>
                    <br>
                    <div style="padding-top: 5px;">{{ $transdel->user_name }} ({{ $transdel->no_hp }})</div>
                    <hr>
                    <b>Foto Sebelum Kirim :</b>
                    <br>
                    <div style="padding-top: 8px;">
                      <img width="100%" src="/assets/img_delivery/{{ $transdel->photo }}">
                    </div>

                    @if($transdel->selesai != NULL)
                      <hr>
                      <b>Foto Selesai Kirim :</b>
                      <br>
                      <div style="padding-top: 8px;">
                        <img width="100%" src="/assets/img_delivery/{{ $transdel->selesai }}">
                      </div>

                    @endif
                  @endif
                @endif

                <!-- ====== END BARCODE ====== -->

                @if($trans->status == "REEDEM")
                  @if($trans->undian_name != NULL)
                  <hr>
                    <div style="font-size: 12px;"><b>Upload Foto KTP :</b></div><br>
                    <div class="photosktp">
                      @if(Auth::user()->fotoktp != NULL)
                        <img width='100%' src='/assets/img_ktp/{{ Auth::user()->fotoktp }}'><hr>
                      @endif
                    </div>
                    <div onclick="$('#uploadfotoktp').click();">
                          @if(Auth::user()->fotoktp == NULL)
                          <button class="btn btn-success btn-block">
                            <i class="ni ni-image text-white"></i> Upload KTP
                          </button>
                          @else
                          <button class="btn btn-primary btn-block">
                            <i class="ni ni-image text-white"></i> Ganti Foto KTP
                          @endif
                        </button>
                    </div>
                    <input id="uploadfotoktp" name="file" type="file" style="display:none;"/>
                  @endif
                <hr>
                  <div style="font-size: 12px;"><b>QRCODE :</b></div><br>
                  <div class="card shadow-ss">
                    <div class="card-body">

                      @if($trans->undian_name == NULL)
                        <table width="100%">
                            <tr>
                              <td align="center">
                                {!! DNS2D::getBarcodeHTML($trans->uuid, 'QRCODE'); !!}<br> <div style='font-size: 12px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                              </td>
                            </tr>
                            <tr>
                              <td align="center"><b><div style="font-size: 11px">Tunjukan QRCODE ini Ke Petugas kami Yang Berjaga !</div></b></td>
                            </tr>
                          </table>
                      @else
                        @if(Auth::user()->fotoktp == NULL)
                          <div style="font-size:11px;" align="center"><i>Upload Foto KTP terlebih dahulu, Untuk menampilan QRCODE dan Proses Pengambilan Hadiah Selanjutnya.</i></div>
                        @else
                          <table width="100%">
                            <tr>
                              <td align="center">
                                {!! DNS2D::getBarcodeHTML($trans->uuid, 'QRCODE'); !!}<br> <div style='font-size: 12px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                              </td>
                            </tr>
                            <tr>
                              <td align="center"><b><div style="font-size: 11px">Tunjukan QRCODE ini Ke Petugas kami Yang Berjaga !</div></b></td>
                            </tr>
                          </table>
                        @endif
                      @endif
                    </div>
                  </div>
                  
                  @if(Auth::user()->fotoktp != NULL)
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
                              Screenshoot QRCODE ini dan tunjukan QRCODE ini ke petugas kami untuk pengambilan produk
                            </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  @endif
                  
                </div>
                @else

                @if($trans->undian_name == NULL)
                  @if($trans->status == "NOT APPROVED")
                  <hr>
                  <div style="padding-top:10px;">

                    @if($trans->type_bayar == 'ONLINE')
                    <a href="/users/bayar/konfirm?uuid={{ $trans->uuid }}">
                    <button style="border-radius:2rem;" class="btn btn-block btn-success"><i class="fa fa-credit-card"></i> &nbsp;&nbsp;BAYAR SEKARANG</button></a>
                    @elseif($trans->type_bayar == 'OVO')
                    <button onclick="BayarOVO({{ $trans->id }})" style="border-radius:2rem;" class="btn btn-block btn-success"><i class="fa fa-credit-card"></i> &nbsp;&nbsp;BAYAR SEKARANG</button>
                    @endif
                  </div>
                  @endif

                  @if($trans->status == "BELUM BAYAR" || $trans->status == "NOT APPROVED")
                  <div style="padding-top:10px;font-size: 11px;color: red;"><i>
                    Transaksi Anda akan otomatis Kadaluarsa pada tanggal <b>{{ date('d F Y H:i', strtotime($trans->created_at . "+22 hours")) }}</b></i>
                  </div>
                  @elseif($trans->status == "KADALUARSA")
                  @elseif($trans->status == "PENDING")
                  <div style="padding-top:10px;font-size: 11px;color: red;"><i>
                    Transaksi Anda akan otomatis Kadaluarsa pada tanggal <b>{{ date('d F Y H:i', strtotime($trans->created_at . "+7 days")) }}</b></i>
                    <br>
                    Term & Cond Penukaran Produk
                    <ol>
                      <li>Barang yang sudah ditukarkan tidak bisa dikembalikan</li>
                      <li>Barang akan di cek ketersidaan nya paling lama 7 hari dari waktu penukaran dan akan di beritaukan melalui notif aplikasi</li>
                      <li>Barang yang tidak di ambil dalam waktu lebih dari 1 minggu setelah barang ready atau di approve oleh petugas, maka barang di anggap hangus</li>
                      <li>Sistem berhak membatalkan penukaran tanpa pemberitauan kepada pengguna</li>
                      <li>Jika terjadi kecurangan dalam penukaran poin, sistem berhak sepenuhnya membatalkan proses penukaran</li>
                    </ol>
                  </div>
                  @else
                    <hr>
                    <a target="_blank" href="/users/transaksi/invoice?id={{ $trans->id }}"><button class="btn btn-block btn-success"><i class="fa fa-file"></i>   Download Invoice</button></a>


                    @if(!$retur)

                      @if(date('Y-m-d', strtotime( $trans->created_at . " +3 days")) >= date('Y-m-d'))
                        <div style="padding-top:10px;">
                        <button onclick="AjukanRetur({{ $trans->id }})" class="btn btn-block btn-danger"><i class="fa fa-history"></i> Ajukan Retur</button></div>
                      @endif
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
                
                @endif
                @endif
            </div>
          </div><br>
        </div>
      </div>
      @endif
    </div>
  @include('content.transaksi.modal')
  @if(Auth::user())
  @include('layout.footer')
  @else
  @include('layout.footer2')
  @endif
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


  function BayarOVO(id){

    $('#idz').val(id);

    $('#ovomodal').modal('show');

  }

  $('#btn_approve_transaksi').on('click', function() {
  
    $('#konfirm_approve_transaksi').modal('show');

  });

  $('#btn_yakin_approve_transaksi').on('click', function() {


    $.ajax({
        type: 'POST',
        url: "{{ route('transaksi.petugas.approve') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'uuid': "{{ $trans->uuid }}",
        },
        success: function(data) {


          $('#konfirm_approve_transaksi').modal('hide');

            swal({
              title: "Success",
              text: "Approval Transaksi Sukses",
              icon: "success",
              buttons: false,
              timer: 2000,
            });

            setTimeout(function(){ window.location.reload(); }, 2000);

        }

    });

  });


function OVO(){

  $('#ovomodal').modal('hide');

  var empty = false;
  $('input.isian').each(function() {
      if ($(this).val() == '') {
          empty = true;
      }
  });
  if (empty) {

      swal({
          title: "Warning!!",
          text: "OVO ID Harap Diisi",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

  } else {

    $.ajax({
      type: 'POST',
      url: "{{ route('update.ovoid') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'ovo': $('#ovoid').val(),  
      },
      success: function(data) {


        $('#ovoproses').modal({backdrop: 'static', keyboard: false}); 

        var idz = $('#idz').val();

        $.ajax({
          type: 'POST',
          url: "{{ route('bayar.doku2') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': $('#idz').val(),
          },
          success: function(data) {
        
            if(data.status == "FAILED"){

              swal({
                  title: "FAILED!!",
                  text: "Pembayaran Dibatalkan!",
                  icon: "error",
                  buttons: false,
                  timer: 2000,
              });

              $('#ovoproses').modal('hide');

              setTimeout(function(){ window.location.href = '/users/transaksi/detail?uuid='+data.transactionid; }, 1500);

            } else if(data.status == "TIMEOUT"){

              swal({
                  title: "FAILED!!",
                  text: "Waktu Pembayaran Habis!",
                  icon: "error",
                  buttons: false,
                  timer: 2000,
              });

              $('#ovoproses').modal('hide');

              setTimeout(function(){ window.location.href = '/users/transaksi/detail?uuid='+data.transactionid; }, 1500);

            } else {

              $.ajax({
                type: 'POST',
                url: "{{ route('bayar.doku.sukses') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'uuid': data.transactionid,  
                },
                success: function(data) {        

                  swal({
                      title: "Sukses!!",
                      text: "Pembayaran Anda Berhasil!",
                      icon: "error",
                      buttons: false,
                      timer: 2000,
                  });

                  setTimeout(function(){ window.location.href = '/home'; }, 1500);


                }

              });
            }
          }

        });


      }

    });
  }

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

  $("#uploadfotoktp").on("change", function() {

    $('.loading').attr('style','display: block');

    var formData = new FormData();
    formData.append('file', $('#uploadfotoktp')[0].files[0]);

    $.ajax({
        url: "{{ route('transaksi.uploadktp') }}",
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

                swal({
                    title: "Berhasil!",
                    text: "Uplao KTP Berhasil!",
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });

                setTimeout(function(){ window.location.reload(); }, 2000);

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