<div class="modal fade" id="confirm_hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Hapus</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="trans_id">
                        <input type="hidden" id="id"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Menghapus Produk di Keranjang ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="confirm_yakin" class="btn btn-primary">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" id="editqty" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Update QTY</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-12" >
                        <div class="card bg-par-2 card-stats mb-4 mb-lg-0">
                            <div class="card-body shadow">
                                <div class="row">
                                    <div class="col-3">
                                      <div class="icon icon-shape bg-iolo text-white rounded-circle shadow">
                                          <i class="fas fa-car"></i>
                                      </div>
                                    </div>
                                    <div class="col-9" align="right">
                                        <h5 class="card-title text-uppercase mb-0" id="name"></h5>
                                        <h1 class="text-warning" id="qtyasli"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Masukan Qty yang Ingin Diubah :</label>
                        <input type="number" style="font-size: 20px" onkeyup="Qty()" id="qty" class="form-control harus">
                        <input type="hidden" id="ids">
                      </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" id="ubah" class="btn btn-primary">Ubah</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="pilihmethod" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Pilih Metode</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td>
                            <div class="card shadow-ss bg-biru-muda" onclick="Nanti(0)">
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            <td align="left">
                                                <img src="/assets/content/img/icons/takeaway.png" width="80%">
                                            </td>
                                            <td align="left" width="70%">
                                                <div style="font-size: 15px; color: black; padding-bottom: 5px;"><b>Ambil di Lokasi</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;">Melakukan Pengambilan ke Lokasi dengan menunjukan QRCODE Transaksi ke Petugas kami
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                            @php

                                $alamatk = DB::table('alamat')
                                ->where("user_id", $userdetails->id)
                                ->get();

                            @endphp
                            @if($alamatk->count() == 0)
                            <div class="card shadow-ss" onclick="Alamat()">
                            @else
                            <div class="card shadow-ss" onclick="Nanti(1)">

                            @endif
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            <td align="left">
                                                <img src="/assets/content/img/icons/scooter.png" width="80%">
                                            </td>
                                            <td align="left" width="70%">
                                                <div style="font-size: 15px; color: black; padding-bottom: 5px;"><b>Pengiriman Ojol</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;">Barang dikirim dengan Ojek Online ke Lokasi Pelanggan dengan tambahan biaya Pengiriman.
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($getfree == "yes")
                            <br>
                            @if($alamatk->count() == 0)
                            <div class="card shadow-ss" onclick="Alamat()">
                            @else
                            <div class="card shadow-ss" onclick="Nanti(2)">
                            @endif
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            @if($berat >= 500000)
                                            <td align="left">
                                                <img src="/assets/content/img/icons/truck.png" width="80%">
                                            </td>
                                            <td align="left" width="70%">
                                                <div style="font-size: 15px; color: black; padding-bottom: 5px;"><b>Pengiriman dari Gudang Utama (Free)</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;padding-bottom: 5px;">Barang dikirim dari Gudang Utama ke Lokasi Pelanggan dengan <b>GRATIS</b> biaya pengiriman.
                                                </div>
                                                <span class="badge badge-pill badge-danger">BARU</span>
                                            </td>

                                            @else

                                            <td align="left">
                                                <img src="/assets/content/img/icons/kurirlokal.png" width="80%">
                                            </td>
                                            <td align="left" width="70%">
                                                <div style="font-size: 15px; color: black; padding-bottom: 5px;"><b>Pengiriman Kurir Toko</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;padding-bottom: 5px;">Barang dikirim dengan Kurir toko ke Lokasi Pelanggan dengan <b>GRATIS</b> biaya pengiriman.
                                                </div>
                                                <span class="badge badge-pill badge-danger">BARU</span>
                                            </td>

                                            @endif
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @endif

                        </td>
                    </tr>               
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="pilihmethodbazaar" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Pilih Metode Bazaar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td>
                            <div class="card shadow-ss bg-biru-muda" onclick="Nanti(0)">
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            <td align="left">
                                                <img src="/assets/content/img/theme/people2.png" width="100%">
                                            </td>
                                            <td align="left" width="60%">
                                                <div style="font-size: 16px; color: black; padding-bottom: 10px;"><b>Bayar & Ambil Sekarang</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;">Melakukan pembayaran dan pengambilan di satu waktu
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </td>
                    </tr>               
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="hapus_voucher" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Hapus Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="idv"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Menghapus Voucher di Keranjang ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="HapusVoucher()" class="btn btn-primary">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
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
                        <input type="password" style="font-size: 30px" id="tokennya" class="form-control">
                        <input type="hidden" id="reedem">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" onclick="Confirm();" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pilihambil" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Pilih Pengambilan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td>
                            <div class="card shadow-ss bg-biru-muda" onclick="Ambil(0)">
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            <td align="left">
                                                <img src="/assets/content/img/theme/people2.png" width="100%">
                                            </td>
                                            <td align="left" width="60%">
                                                <div style="font-size: 16px; color: black; padding-bottom: 10px;"><b>Ambil Sekarang</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;">Melakukan Pengambilan Sekarang!
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="card shadow-ss" onclick="Ambil(1)">
                                <div class="card-body" style="padding-right: 1rem;padding-left: 0.5rem;">
                                    <table width="100%" >
                                        <tr>
                                            <td align="left">
                                                <img src="/assets/content/img/theme/people1.png" width="100%">
                                            </td>
                                            <td align="left" width="60%">
                                                <div style="font-size: 16px; color: black; padding-bottom: 10px;"><b>Ambil Nanti</b>
                                                </div>
                                                <div style="font-size: 12px; color: black;"> Mengambilnya dilakukan di lain waktu, Produk masuk ke Saldo Anda.
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </td>
                    </tr>               
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button>
            </div>
            
        </div>
    </div>
</div>


