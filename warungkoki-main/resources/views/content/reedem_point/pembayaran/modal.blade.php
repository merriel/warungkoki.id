

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


<div class="modal fade" id="konfirm_paysaldopoint" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Penukaran</h3>
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
                        <td align="center"><h5 class="text-muted">Anda Yakin Akan Menukar Saldo Poin dengan barang ini ?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="YakinBayarSaldoPoint()" class="btn btn-primary">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="paysaldopointmodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Penukaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top: 0px;padding-bottom: 0px;">
              <!-- <div class="row">
                <div class="col-12">
                  <div class="card-body shadow-ss bg-kuning" style="border-radius: 2rem;">
                              
                    <div style="font-size: 11px; color: white">
                        <i class="fa fa-money"></i>
                        Jika pembayaran menggunakan Saldo TOMX akan mendapatkan GRATIS Biaya Layanan
                    </div>
                  </div>
                </div>
              
              </div> -->
                <h5>Berikut adalah Rincian dari Belanja Anda :</h5><br>
                @php
                $total = 0;
                @endphp
                @foreach ($kranjangs as $kranjang)
                @php
                $harga = ceil($kranjang->harga_act);
                $totalnya = $kranjang->qty * $harga;

                @endphp
                  <div class="row">
                    <div class="col-12">
                      <div class="card shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-4" style="padding-bottom: 0px;">
                                <img width="100%" src="/assets/img_post/{{ $kranjang->img }}">
                            </div>
                            <div class="col-8" align="left" style="padding-bottom: 0px;">
                              @if($kranjang->retailer_name == "")
                              <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $kranjang->wilayah_name }}</b></div>
                              @endif
                                <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 12px;" class="text-warning"><b>{{ butir_padi($harga) }} <img width="25px" src="/assets/content/img/icons/padi.png"> | Qty : {{ $kranjang->qty }}</b>

                                </div> 
                            </div>
                            <div class="col-12" style="padding-bottom: 0px;">
                              <hr>
                              <table width="100%" style="font-size: 12px;">
                                <tr>
                                  <td align="left"><b>TOTAL</b></td>
                                  <td align="right">
                                    <b>{{ butir_padi($totalnya) }} <img width="25px" src="/assets/content/img/icons/padi.png"></b>
                                  </td>
                                </tr>
                              </table>
                            </div>
                              @php
                                $totalkeseluruhan = $totalnya;
                              @endphp
                          </div>
                        </div>
                      </div>
                    </div>    
                  </div>
                  @php
                    $total += $totalkeseluruhan;

                  @endphp
                @endforeach

                  <hr>
                  <div class="row">
                    <div class="col-12">
                      <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-5" style="padding-right:0px;padding-bottom: 0px;">
                              <div style="font-size: 13px" class="text-white"> <b>TOTAL BAYAR :</b></div>
                            </div>
                            <div class="col-7" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 14px" class="text-white"> <b>{{ butir_padi($total) }} <img width="25px" src="/assets/content/img/icons/padi.png"></b></div>
                                
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="BayarSaldoPointNow()" class="btn btn-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-secondary ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="tokenSaldoPoin" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                        <input type="password" style="font-size: 30px" id="tokenuserssaldopoin" class="form-control">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" id="reedemtokensaldopoin" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
