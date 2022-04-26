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
                @endphp
                @foreach ($keranjangs as $kranjang)
                @php
                $harga = $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);
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
                              @else
                              <div class="text-warning" style="font-size: 10px"><b>{{ $kranjang->retailer_name }}</b></div>
                              @endif
                                <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 12px;" class="text-warning"><b>{{ rupiah($harga) }} | Qty : {{ $kranjang->qty }}</b>
                                </div> 
                            </div>

                            <div class="col-12" style="padding-bottom: 0px;">
                              <hr style="margin-bottom:0.5rem;">
                              <table width="100%" style="font-size: 12px;">
                                <tr>
                                  <td align="left"><b>TOTAL</b></td>
                                  <td align="right">
                                    <b>{{ rupiah($totalnya) }}</b>
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

                  @if($potongan)

                    @if($potongan->jenis == "cashback")

                      <div style="padding-bottom:10px;" class="text-success" align="center"><i><b>Potensi Cashback sebesar {{ rupiah($potongan->amount) }}</b></i></div>

                    @else

                      @if($potongan->amount == NULL)

                        <table id="customers">
                          <tr>
                            <td>TOTAL</td>
                            <td align="right"><b>{{ rupiah($total) }}</b></td>
                          </tr>
                          <tr>
                            <td>POTONGAN - <b>{{ $potongan->percent }}%</b></td>
                            <td align="right"><b>{{ rupiah($total * ($potongan->percent/100)) }}</b></td>
                          </tr>
                          
                        </table>

                      @else

                        <table id="customers">
                          <tr>
                            <td>TOTAL</td>
                            <td align="right"><b>{{ rupiah($total) }}</b></td>
                          </tr>
                          <tr>
                            <td>POTONGAN</td>
                            <td align="right"><b>{{ rupiah($potongan->amount) }}</b></td>
                          </tr>
                          
                        </table>

                      @endif

                    <br>

                    @endif
                    

                    @php
                    if($potongan->jenis == "cashback"){
                      $total = $total - 0;
                    } else {

                      if($potongan->amount == NULL){

                        $total = $total - ($total * ($potongan->percent/100));

                      } else {

                        $total = $total - $potongan->amount;

                      }
                      
                    }
                    @endphp

                  @endif

                  <div class="row">
                    <div class="col-12">
                      <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-5" style="padding-right:0px;padding-bottom: 0px;">
                              <div style="font-size: 13px" class="text-white"> <b>TOTAL BAYAR :</b></div>
                            </div>
                            <div class="col-7" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 14px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            
            <div class="modal-footer">
                <div id="tombolnya">
                  
                </div>
                <button type="button" class="btn btn-secondary ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="cashmodal2" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
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
                @foreach ($keranjangs as $kranjang)
                @php
                $harga = $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);
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
                              @else
                              <div class="text-warning" style="font-size: 10px"><b>{{ $kranjang->retailer_name }}</b></div>
                              @endif
                                <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 12px;" class="text-warning"><b>{{ rupiah($harga) }} | Qty : {{ $kranjang->qty }}</b>

                                </div> 
                            </div>
                            <div class="col-12" style="padding-bottom: 0px;">
                              <hr>
                              <table width="100%" style="font-size: 12px;">
                                <tr>
                                  <td align="left"><b>TOTAL</b></td>
                                  <td align="right">
                                    <b>{{ rupiah($totalnya) }}</b>
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
                  @if($potongan)

                    @if($potongan->jenis == "cashback")

                      <div style="padding-bottom:10px;" class="text-success" align="center"><i><b>Potensi Cashback sebesar {{ rupiah($potongan->amount) }}</b></i></div>

                    @else

                    <table id="customers">
                      <tr>
                        <td>TOTAL</td>
                        <td align="right"><b>{{ rupiah($total) }}</b></td>
                      </tr>
                      <tr>
                        <td>POTONGAN</td>
                        <td align="right"><b>{{ rupiah($potongan->amount) }}</b></td>
                      </tr>
                      
                    </table>
                    <br>

                    @endif
                    

                    @php
                    if($potongan->jenis == "cashback"){
                      $total = $total - 0;
                    } else {
                      $total = $total - $potongan->amount;
                    }
                    @endphp

                  @endif
                  <div class="row">
                    <div class="col-12">
                      <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-5" style="padding-right:0px;padding-bottom: 0px;">
                              <div style="font-size: 13px" class="text-white"> <b>TOTAL BAYAR :</b></div>
                            </div>
                            <div class="col-7" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 14px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                                
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="BayarSaldoNow()" class="btn btn-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-secondary ml-auto"  data-dismiss="modal">Batal</button> 
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
              <div class="row">
                <div class="col-12">
                  <div class="card-body shadow-ss bg-warung" style="border-radius: 2rem;">
                              
                    <div style="font-size: 11px; color: white">
                        Pembayaran secara Online Dikenakan Biaya layanan sebesar {{ $service->biaya }}% per produk.
                    </div>
                  </div>
                </div>
              
              </div>
                <h5>Berikut adalah Rincian dari Belanja Anda :</h5><br>
                @php
                $total = 0;
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
                                <table id="customers">
                                  <tr>
                                    <td>Harga ({{ $kranjang->qty }})</td>
                                    <td align="right"><b>
                                      {{ rupiah($kranjang->qty * $kranjang->harga_act) }}
                                      </b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Layanan</td>
                                    <td align="right" class="text-success"><b>
                                      {{ rupiah($kranjang->qty * (ceil($kranjang->harga_act * (float)$service->biaya / 100))) }}</b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Total</td>
                                    <td align="right"><b>   
                                    {{ rupiah($kranjang->qty * ($kranjang->harga_act + ceil($kranjang->harga_act * (float)$service->biaya / 100))) }}</b>
                                    </td>
                                  </tr>
                                </table>
                                
                               
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>    
                  </div>
                  @php
                    
                    $total += $kranjang->qty * ($kranjang->harga_act + ceil($kranjang->harga_act * (float)$service->biaya / 100));

                  @endphp
                  @endforeach

                  <div class="row">
                    <div class="col-12">
                      <div class="card bg-warung shadow-ss">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6">
                              <div style="font-size: 13px" class="text-white"> <b>Total :</b></div>
                            </div>
                            <div class="col-6" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 21px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                                <input type="hidden" id="amount" value="{{ $total }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="BayarOnline()" class="btn btn-primary">Bayar Sekarang</button>
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
                        <td align="center"><h5 class="text-muted">Anda yakin akan melakukan Pemesanan ini?</h5></td>
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

<div class="modal fade" id="konfirm2" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                <button type="button" onclick="YakinBayar2()" class="btn btn-primary">Yakin</button>
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

<div class="modal fade" id="onlinemodal2" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
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
                @foreach ($keranjangs as $kranjang)
                @php
                $harga = $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);
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
                              @else
                              <div class="text-warning" style="font-size: 10px"><b>{{ $kranjang->retailer_name }}</b></div>
                              @endif
                                <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 12px;" class="text-warning"><b>{{ rupiah($harga) }} | Qty : {{ $kranjang->qty }}</b>

                                </div> 
                            </div>

                            <div class="col-12" style="padding-bottom: 0px;">
                              <hr style="margin-bottom:0.5rem;">
                              <table width="100%" style="font-size: 12px;">
                                <tr>
                                  <td align="left"><b>TOTAL</b></td>
                                  <td align="right">
                                    <b>{{ rupiah($totalnya) }}</b>
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
                  
                  @if($potongan)

                    @if($potongan->jenis == "cashback")

                      <div style="padding-bottom:10px;" class="text-success" align="center"><i><b>Potensi Cashback sebesar {{ rupiah($potongan->amount) }}</b></i></div>

                    @else

                    <table id="customers">
                      <tr>
                        <td>TOTAL</td>
                        <td align="right"><b>{{ rupiah($total) }}</b></td>
                      </tr>
                      <tr>
                        <td>POTONGAN</td>
                        <td align="right"><b>{{ rupiah($potongan->amount) }}</b></td>
                      </tr>
                      
                    </table>
                    <br>

                    @endif
                    

                    @php
                    if($potongan->jenis == "cashback"){
                      $total = $total - 0;
                    } else {
                      $total = $total - $potongan->amount;
                    }
                    @endphp

                  @endif

                  <div class="row">
                    <div class="col-12">
                      <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-5" style="padding-right:0px;padding-bottom: 0px;">
                              <div style="font-size: 13px" class="text-white"> <b>TOTAL BAYAR :</b></div>
                            </div>
                            <div class="col-7" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 14px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                                
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="BayarOnline()" class="btn btn-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-secondary ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="dokumodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Pembayaran</h3>
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
                @foreach ($keranjangs as $kranjang)
                @php
                $harga = $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);
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
                              @else
                              <div class="text-warning" style="font-size: 10px"><b>{{ $kranjang->retailer_name }}</b></div>
                              @endif
                                <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                                <div style="font-size: 12px;" class="text-warning"><b>{{ rupiah($harga) }} | Qty : {{ $kranjang->qty }}</b>

                                </div> 
                            </div>

                            <div class="col-12" style="padding-bottom: 0px;">
                              <hr style="margin-bottom:0.5rem;">
                              <table width="100%" style="font-size: 12px;">
                                <tr>
                                  <td align="left"><b>TOTAL</b></td>
                                  <td align="right">
                                    <b>{{ rupiah($totalnya) }}</b>
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
                  
                  @if($potongan)

                    @if($potongan->jenis == "cashback")

                      <div style="padding-bottom:10px;" class="text-success" align="center"><i><b>Potensi Cashback sebesar {{ rupiah($potongan->amount) }}</b></i></div>

                    @else

                    <table id="customers">
                      <tr>
                        <td>TOTAL</td>
                        <td align="right"><b>{{ rupiah($total) }}</b></td>
                      </tr>
                      <tr>
                        <td>POTONGAN</td>
                        <td align="right"><b>{{ rupiah($potongan->amount) }}</b></td>
                      </tr>
                      
                    </table>
                    <br>

                    @endif
                    

                    @php
                    if($potongan->jenis == "cashback"){
                      $total = $total - 0;
                    } else {
                      $total = $total - $potongan->amount;
                    }
                    @endphp

                  @endif

                  <div class="row">
                    <div class="col-12">
                      <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-5" style="padding-right:0px;padding-bottom: 0px;">
                              <div style="font-size: 13px" class="text-white"> <b>TOTAL BAYAR :</b></div>
                            </div>
                            <div class="col-7" style="padding-bottom: 0px;" align="right">
                                <div style="font-size: 14px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                                
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

            </div>
            
            <div class="modal-footer">
              <input type="hidden" id="idz">
                <button type="button" onclick="BayarDoku()" class="btn btn-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-secondary ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="ovomodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Masukan OVO ID Anda</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div align="left" style="font-size:11px;padding-bottom: 5px;">Pastikan OVO ID Anda sudah terdaftar di AplikasI OVO</div>
                      <div class="form-group" align="left">
                        <input type="text" value="{{ Auth::user()->ovo }}" id="ovoid" class="form-control isian" placeholder="Contoh : 0811000111">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" onclick="OVO();" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ovoproses" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-body"  style="padding-top: 18px;">
                <div class="row content" id="content1" >
                    <div class="col-12">
                        <img src="/assets/content/img/theme/ovoproses.jpg" width="100%"><br>
                        <div style="font-size: 18px;color: #4c3494;">
                            <b>CEK APLIKASI OVO ANDA!</b>
                        </div>
                        <div style="font-size: 12px;" >
                            Lakukan Proses Pembayaran dari Aplikasi OVO Anda, untuk menyelesaikan Pembayaran Anda!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="token2" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                        <input type="password" style="font-size: 30px" id="tokenusers2" class="form-control">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" id="reedemtoken2" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="maintenances" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header" style="padding-bottom:0rem;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top:0px;">
                <div class="row">
                    <div class="col-md-12">
                      <img src="/assets/content/img/theme/maintenance.jpg" width="100%">

                      <div class="text-warning" style="font-size:18px;padding-bottom: 8px;padding-top: 10px;"><b>PROSES MAINTENANCE</b></div>
                    <div style="font-size:11px;">Saat ini Proses pembayaran dengan menggunakan Saldo Warungkoki belum bisa digunakan, dikarenakan sedang proses maintenance.</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>