<div class="modal fade" id="reedem_hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                    <tr><td height="20px"><input type="hidden" id="id"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Menghapus Produk di Keranjang Reedem ini?</h5></td>
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

<div class="modal fade" id="reedem_confirm" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Reedem</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="id"></td></tr>
                    <tr>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Reedem Produk di Keranjang Reedem ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="yakin_reedem" class="btn btn-primary">Yakin</button>
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
                        <input type="password" style="font-size: 24px" id="tokenusers" class="form-control">
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

<div class="modal fade" id="catatan" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Catatan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <textarea class="form-control wajib" rows="8" id="keterangan">{{ $ket ? $ket->ket : '' }}</textarea>
                    </div>
                </div>
                <table width="100%">
                    <tr>
                        <td align="center"><button type="button" id="simpancatatan" class="btn btn-primary">Simpan Catatan</button></td>
                    </tr>
                </table>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="planing" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Rencana Pengambilan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" align="left">
                            <label class="form-control-label">Tanggal Pengambilan</label>
                            <input type="date" class="form-control plans" id="tgl" value="{{ $ket ? date('Y-m-d', strtotime($ket->plan)) : '-' }}">
                        </div>
                        <div class="form-group" align="left">
                            <label class="form-control-label">Waktu Pengambilan</label>
                            <input type="time" class="form-control plans" id="jam" value="{{ $ket ? date('H:i:s', strtotime($ket->plan)) : '' }}">
                        </div>
                    </div>
                </div>
                <table width="100%">
                    <tr>
                        <td align="center"><button type="button" id="simpanplan" class="btn btn-primary">Simpan</button></td>
                    </tr>
                </table>
            </div>  
        </div>
    </div>
</div>