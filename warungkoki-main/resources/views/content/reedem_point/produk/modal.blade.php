<div class="modal fade" id="tambah_produk" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Produk :</label>
                        <input type="text" id="names" class="form-control harus" placeholder="Nama Produk">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Harga Produk (Dalam Rupiah) :</label>
                        <input type="number" id="harga" class="form-control harus" placeholder="Harga Produk">
                      </div>

                      <div class="custom-control custom-checkbox mb-3" align="left">
                          <input class="custom-control-input" id="customCheck1" type="checkbox">
                          <label class="custom-control-label" for="customCheck1">Ada Garansi pada Produk Ini?</label>
                        </div>
                    </div>
                </div>
                <div class="row" id="garans" style="display: none;">
                    <div class="col-md-12">
                        <div class="form-group" align="left">
                            <label class="form-control-label">Garansi :</label>
                            <select class="form-control" id="garansi_id">
                                @foreach($garansis as $garansi)
                                <option value="{{ $garansi->id }}">{{ $garansi->name }}</option>
                                @endforeach
                            </select>
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

<div class="modal fade" id="hapus_produk" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus Produk</h3>
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

<div class="modal fade" id="edit_produk" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Ubah Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Produk :</label>
                        <input type="text" id="productname" class="form-control" placeholder="Nama Produk">
                        <input type="hidden" id="productid" class="form-control">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Harga Produk (Dalam Rupiah) :</label>
                        <input type="text" id="productprice" class="form-control" placeholder="Harga Produk">
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