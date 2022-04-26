<div class="modal fade" id="deliverysetuju" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Setuju</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="idsetuju"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin Menyetujui Delivery Reedem ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="yakin_setuju" class="btn btn-primary">Setuju</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="deliverytolak" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Tolak</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="idtolak"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Menolak Delivery Reedem ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="yakin_tolak" class="btn btn-primary">Tolak</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="planingsetuju" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Pengambilan yang Disetujui</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <input type="hidden" id="idplan">
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" align="left">
                            <label class="form-control-label">Tanggal Pengambilan</label>
                            <input type="date" class="form-control plans" id="tgl" >
                        </div>
                        <div class="form-group" align="left">
                            <label class="form-control-label">Waktu Pengambilan</label>
                            <input type="time" class="form-control plans" id="jam">
                        </div>
                    </div>
                </div>
                <table width="100%">
                    <tr>
                        <td align="center">
                            <button type="button" id="simpanplansetuju" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
                        </td>
                    </tr>
                </table>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="siapkan" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr><td>
                        <div style="font-size:18px;color: #feac3b;"><b>PESANAN SUDAH READY?</b></div>
                        <input type="hidden" id="idready">
                    </td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin Pesanan ini sudah READY?</h5></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer" style="padding-top:0px;">
                <button type="button" class="btn btn-danger ml-auto btn-block" data-dismiss="modal">Tidak</button>
                <button type="button" id="yakinready" style="background-color: #feac3b;" class="btn btn-block btn-secondary">Yakin</button>  
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="selesai" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr><td>
                        <div class="text-success" style="font-size:18px;"><b>PESANAN SELESAI?</b></div>
                        <input type="hidden" id="idselesai">
                    </td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin Pesanan ini sudah SELESAI?</h5></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer" style="padding-top:0px;">
                <button type="button" class="btn btn-danger btn-block ml-auto"  data-dismiss="modal">Tidak</button> 
                <button type="button" id="yakinselesai" class="btn btn-success btn-block">Yakin</button>
            </div>
            
        </div>
    </div>
</div>