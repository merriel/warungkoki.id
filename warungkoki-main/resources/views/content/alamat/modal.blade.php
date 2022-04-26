<div class="modal fade" id="tambahalamat" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Tambah Alamat</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center" style="padding-bottom: 0px;">
                <div class="row">
                    <div class="col-md-12">

                      <div class="form-group" align="left">
                        <label class="form-control-label">Judul Alamat :</label>
                        <input type="text" id="judul" class="form-control mandatory" placeholder="Contoh : Alamat Rumah, Alamat Kantor">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Provinsi :</label>
                        <select class="form-control mandatory" id="prov">
                            <option value=""></option>
                            @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Kota/Kabupaten :</label>
                        <select class="form-control mandatory" id="regency">
                            
                        </select>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Kecamatan :</label>
                        <select class="form-control mandatory" id="district">
                            
                        </select>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Alamat Lengkap :</label>
                        <textarea class="form-control mandatory" id="alamat" rows="7" placeholder="Isikan Alamat Lengkap Anda Disini"></textarea>
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Nama Penerima :</label>
                        <input type="text" id="penerima" class="form-control mandatory" placeholder="Contoh : Dodi, Agus,">
                      </div>

                      <div class="form-group" align="left">
                        <label class="form-control-label">Nomor HP Penerima :</label>
                        <input type="text" id="nohp" class="form-control mandatory" placeholder="Contoh : 0890011911">
                        <input type="hidden" id="longuser">
                         <input type="hidden" id="latuser">
                      </div>

                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="padding-top: 0px;">
                <button type="button" id="simpan" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="utamaalamat" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi</h3>
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
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan jadikan Alamat ini menjadi Alamat Utama?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="YakinUtama()" class="btn btn-success">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="hapusalamat" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Hapus ALAMAT</h3>
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
                        <input type="hidden" id="idc"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan HAPUS Alamat ini?</h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="YakinHapus()" class="btn btn-success">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
            </div>
            
        </div>
    </div>
</div>