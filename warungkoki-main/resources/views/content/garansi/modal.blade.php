<div class="modal fade" id="tambah_garansi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Garansi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Garansi :</label>
                        <input type="text" id="name" class="form-control garansi" placeholder="Nama Garansi">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Jangka Waktu :</label>
                        <input type="text" id="waktu" class="form-control garansi" placeholder="Jangka Waktu (Numerik)">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Type Waktu :</label>
                        <select class="form-control garansi" id="types">
                            <option>-- Pilih Type Waktu --</option>
                            <option>Hari</option>
                            <option>Minggu</option>
                            <option>Bulan</option>
                            <option>Tahun</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Keterangan :</label>
                        <textarea class="form-control garansi" id="ket" rows="7" placeholder="Isikan Keterangan Tambahan Disini"></textarea>
                      </div>
                    </div>
                </div>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="hapus_garansi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus Garansi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="./assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="id" ></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Hapus Data ini? </h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="delete" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="edit_garansi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Ubah Garansi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Garansi :</label>
                        <input type="text" id="nameedit" class="form-control garansiedit" placeholder="Nama Garansi">
                        <input type="hidden" id="idedit" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Jangka Waktu :</label>
                        <input type="text" id="waktuedit" class="form-control garansiedit" placeholder="Jangka Waktu (Numerik)">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Type Waktu :</label>
                        <select class="form-control garansiedit" id="typesedit">
                            <option>-- Pilih Type Waktu --</option>
                            <option>Hari</option>
                            <option>Minggu</option>
                            <option>Bulan</option>
                            <option>Tahun</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Keterangan :</label>
                        <textarea class="form-control garansiedit" id="ketedit" rows="7" placeholder="Isikan Keterangan Tambahan Disini"></textarea>
                      </div>
                    </div>
                </div>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="ubah" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>