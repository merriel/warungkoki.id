<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Voucher :</label>
                        <select class="form-control isi" id="voucher_id">
                            <option value="">Pilih Voucher</option>
                            @foreach($vouchers as $vou)
                            <option value="{{ $vou->id }}">{{ $vou->name }} - {{ rupiah($vou->amount) }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Banyaknya Voucher</label>
                        <input type="number" id="banyak" class="form-control isi" placeholder="Banyaknya Voucher yang diinginkan">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Berlaku dari (Tanggal)</label>
                        <input type="date" id="dari" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Berlaku sampai (Tanggal)</label>
                        <input type="date" id="sampai" class="form-control">
                      </div>
                    </div>
                    
                </div>  

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="Simpan()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="./assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="iddel" ></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Hapus Voucher ini? </h5></td>
                    </tr>
                </table>

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="YakinDelete();" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="cetak" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Cetak Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            
            <div class="modal-body">
                
                <table id="customers" class="datatables22" width="100%">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th width="8%"></th>
                      <th width="10%">Kode</th>
                      <th>Nama</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
               </table> 
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="Download();" class="btn btn-primary">Download</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>
