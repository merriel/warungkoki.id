<div class="modal fade" id="cashmodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <input type="hidden" id="idnya">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top: 0px;padding-bottom: 0px;">
              
                <h5>Berikut adalah Rincian dari Belanja Anda :</h5><br>
                @php
                $total = 0;
                $delivery = 0;
                @endphp
                @foreach ($keranjangs as $kranjang)
                  <div class="row">
                    <div class="col-12">
                      <div class="card shadow-ss">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-4" style="padding-bottom: 0px;">
                                <img width="100%" src="/assets/img_post/{{ $kranjang->img }}">
                            </div>
                            <div class="col-8" align="left" style="padding-bottom: 0px;">
                              <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $kranjang->wilayah_name }}</b></div>
                                <div style="font-size: 13px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 14px;" class="text-warning"><b>{{ rupiah($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100)) }} | Qty : {{ $kranjang->qty }}</b></div>
                                
                               
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
                  </div>
                  @php
                    $total += $kranjang->qty * ($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100));
                    $delivery += $kranjang->delivery_amount;
                  @endphp
                  @endforeach

                  <table id="customers">
                    <tr>
                      <td>Total Belanja</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($total) }}</b></td>
                    </tr>
                    <tr>
                      <td>Total Delivery</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($delivery) }}</b></td>
                    </tr>
                    @if($potongan)
                        @php

                        if($potongan->amount == NULL){

                            $potonganvoucher = $total * ($potongan->percent/100);

                        } else {

                            $potonganvoucher = $potongan->amount;

                        }
                            
                        @endphp
                        <tr>
                          <td>Potongan Voucher</td>
                          <td align="right" style="font-size: 12px;"><b>- {{ rupiah($potonganvoucher) }}</b></td>
                        </tr>
                    @else
                        @php
                        $potonganvoucher = 0;
                        @endphp
                    @endif
                    <tr>
                      <td>Total Pembayaran</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($total + $delivery - $potonganvoucher) }}</b></td>
                    </tr>
                  </table>

            </div>
            
            <div class="modal-footer">
                <div id="tombolnya">
                    
                </div>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="onlinemodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top: 0px;padding-bottom: 0px;">

                <h5>Berikut adalah Rincian dari Belanja Anda :</h5><br>
                @php
                $total = 0;
                $delivery = 0;
                @endphp
                @foreach ($keranjangs as $kranjang)
                  <div class="row">
                    <div class="col-12">
                      <div class="card shadow-ss">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-4" style="padding-bottom: 0px;">
                                <img width="100%" src="/assets/img_post/{{ $kranjang->img }}">
                            </div>
                            <div class="col-8" align="left" style="padding-bottom: 0px;">
                              <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $kranjang->wilayah_name }}</b></div>
                                <div style="font-size: 13px;padding-bottom: 8px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 14px;" class="text-warning"><b>{{ rupiah($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100)) }} | Qty : {{ $kranjang->qty }}</b></div>
                               
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
                  </div>
                  @php
                    
                    $total += $kranjang->qty * ($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100));

                    $delivery += $kranjang->delivery_amount;



                  @endphp
                  @endforeach

                  <table id="customers">
                    <tr>
                      <td>Total Belanja</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($total) }}</b></td>
                    </tr>
                    <tr>
                      <td>Total Delivery</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($delivery) }}</b></td>
                    </tr>
                    @if($potongan)
                    @php
                        $potonganvoucher = $potongan->amount;
                    @endphp
                    <tr>
                      <td>Potongan Voucher</td>
                      <td align="right" style="font-size: 12px;"><b>- {{ rupiah($potongan->amount) }}</b></td>
                    </tr>
                    @else
                        @php
                        $potonganvoucher = 0;
                        @endphp
                    @endif
                    <tr>
                      <td>Total Pembayaran</td>
                      <td align="right" style="font-size: 12px;"><b>{{ rupiah($total + $delivery - $potonganvoucher) }}</b></td>
                    </tr>
                  </table>

                  

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="BayarOnline()" class="btn btn-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="konfirm" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Akan Bayar Pembelian Ini menggunakan Saldo Warungkoki?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="YakinBayar()" class="btn btn-primary">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="barcode" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Barcode</h2>

            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left" id="img_barcode">
                        
                      </div>
                      <div style="font-size: 12px;"><b>Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</b></div>
                      <hr>
                      <a href="/users/transaksi"><button type="button" class="btn btn-success">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="token" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Masukan PIN Anda</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <input type="password" style="font-size: 30px" id="tokenusers" class="form-control">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" id="reedemtoken" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>