<div class="modal fade" id="tambah_petugas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Petugas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Username :</label>
                        <input type="text" id="username" class="form-control petugas" placeholder="Username">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Petugas :</label>
                        <input type="text" id="name" class="form-control petugas" placeholder="Nama Petugas">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Password Petugas :</label>
                        <input type="text" id="pass" class="form-control petugas" placeholder="Password Petugas">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Jenis Kelamin :</label>
                        <select class="form-control petugas" id="jenkel">
                            <option>Pilih Jenis Kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Petugas Di Cabang :</label>
                        <select class="form-control petugas" id="cabang">
                            <option>Pilih Cabang</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Tanggal Lahir :</label>
                        <input type="date" id="tgl_lhr" class="form-control petugas">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">No Handphone :</label>
                        <input type="text" id="nohp" class="form-control petugas" placeholder="Nomor Handphone">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Petugas :</label>
                        <textarea class="form-control petugas" rows="3" id="alamat"></textarea>
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

<div class="modal fade" id="edit_petugas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Ubah Petugas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Username :</label>
                        <input type="text" id="username-edit" class="form-control edits" placeholder="Username" disabled>
                        <input type="hidden" id="id-edit">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Petugas :</label>
                        <input type="text" id="name-edit" class="form-control edits" placeholder="Nama Petugas">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Jenis Kelamin :</label>
                        <select class="form-control edits" id="jenkel-edit">
                            <option>Pilih Jenis Kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Petugas Di Cabang :</label>
                        <select class="form-control edits" id="cabang-edit">
                            <option>Pilih Cabang</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Tanggal Lahir :</label>
                        <input type="date" id="tgl_lhr-edit" class="form-control edits">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">No Handphone :</label>
                        <input type="text" id="nohp-edit" class="form-control edits" placeholder="Nomor Handphone">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Petugas :</label>
                        <input type="text" id="alamat-edit" class="form-control edits" placeholder="Alamat Lengkap">
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

<div class="modal fade" id="hapus_petugas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus Petugas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
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

<div class="modal fade" id="reset_petugas" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Reset Petugas Petugas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="idx" ></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Reset Password ini? </h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="reset" class="btn btn-primary">Reset</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>