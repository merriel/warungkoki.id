<div class="modal fade" id="tambah_wilayah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Wilayah</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Wilayah :</label>
                        <input type="text" id="name" class="form-control wil" placeholder="Nama Wilayah">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Provinsi :</label>
                        <select class="form-control wil" id="province">
                            <option>Pilih Provinsi</option>
                            @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Kota/Kabupaten :</label>
                        <select class="form-control wil" id="kotakab">
                          <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Wilayah :</label>
                        <textarea class="form-control wil" rows="8" id="alamat"></textarea>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Admin Outlet:</label>
                        <input type="text" id="namaadmin" class="form-control wil" placeholder="Username Admin">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Username Admin Outlet:</label>
                        <input type="text" id="username" class="form-control wil" placeholder="Username Admin">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Password :</label>
                        <input type="password" id="password" class="form-control wil" placeholder="Password Admin">
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

<div class="modal fade" id="view_wilayah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Lihat Wilayah</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Wilayah :</label>
                        <input type="text" id="name_wilayah" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Wilayah :</label>
                        <textarea class="form-control" rows="10" id="alamat_view" disabled></textarea>
                      </div>
                    </div>
                </div>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="edit_wilayah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Ubah Wilayah</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Wilayah :</label>
                        <input type="text" id="wilayahname" class="form-control wils" placeholder="Nama Produk">
                        <input type="hidden" id="wilayahid" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Wilayah :</label>
                        <textarea class="form-control wils" rows="10" id="wilayahalamat"></textarea>
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

<div class="modal fade" id="hapus_wilayah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus Wilayah</h3>
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