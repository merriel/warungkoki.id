<div class="modal fade" id="postimg" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Posting</h3>
               
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <img id="images" src="" width="100%">
                      <input type="hidden" id="id">
                      <input type="hidden" id="imgs">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <br><br>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Type :</label>
                        <select class="form-control ada" id="type">
                            <option value="">Pilih Type</option>
                            <option>Challange</option>
                            <option>Deals</option>
                            <option>Products</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="row contents" style="display: none;">    
                    <div class="col-md-12 products">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Produk :</label>
                        <select class="form-control" id="produk_id">
                            <option value="">Pilih Produk</option>
                            @foreach($prods as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12 products">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Barang Bisa Delivery? :</label>
                        <select class="form-control" id="deliver">
                            <option value="no">Tidak</option>
                            <option value="yes">Ya</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12 products">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Barang Pre-Order? :</label>
                        <select class="form-control" id="po">
                            <option value="no">Tidak</option>
                            <option value="yes">Ya</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12 deals products">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Kategori :</label>
                        <select class="form-control" id="kategori">
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12 deals challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Judul Post :</label>
                        <input type="text" id="title" class="form-control" placeholder="Judul Posting">
                      </div>
                    </div>

                    <div class="col-md-12 challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Jenis Challange:</label>
                        <select class="form-control" id="jenis">
                            <option value="global">Global</option>
                            <option value="perproduk">Per Produk</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12 challanges global">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Pilih Produk:</label>
                        <table id="customers" class="datatabless">
                            <tr>
                                <th></th>
                                <th>Nama Produk</th>
                            </tr>
                            <tbody>
                                @foreach($prod2s as $prod2)
                                <tr>
                                    <td width="10%" style="padding-top: 5px; padding-bottom: 5px;">
                                        <input type="checkbox" style="width: 22px;" class="form-control prod_id" value="{{ $prod2->id }}">
                                    </td>
                                    <td style="padding-top: 5px; padding-bottom: 5px;">
                                        {{ $prod2->name }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-12 challanges global">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Total Value :</label>
                        <input type="text" id="value" placeholder="Total Value Challange" class="form-control">
                        <input type="hidden" id="value2">
                      </div>
                    </div>

                    <div class="col-md-12 products">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Stok Barang :</label>
                        <input type="text" onkeyup="angka(this);" id="stok" class="form-control">
                      </div>
                    </div>
                    
                    <div class="col-md-12 deals challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Berlaku Dari:</label>
                        <input type="date" id="dari" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12 deals challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Berlaku Sampai:</label>
                        <input type="date" id="sampai" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12 deals challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Maksimal Daftar:</label>
                        <input type="text" onkeyup="angka(this);" id="max" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Deskirpsi Post :</label>
                        <textarea rows="10" class="form-control ada" id="desc"></textarea>
                      </div>
                    </div>

                    <div class="col-md-12 products deals">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Harga Actual(Rp):</label>
                        <input type="text" onkeyup="angka(this);" id="harga_act" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12 deals">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Harga Coret(Rp):</label>
                        <input type="text" onkeyup="angka(this);" id="harga_crt" class="form-control">
                      </div>
                    </div>
                </div>
                <hr>
                <div class="row contents" style="display: none;">
                    <div class="col-md-12">
                        <div class="form-group deals challanges" id="perproduk" align="left">
                            <label class="form-control-label">Pilih Produk:</label><br>
                            <button type="button" class="btn btn-sm btn-primary add-product"><i class="fa fa-plus"></i>  Tambah Produk</button>
                            <br><br>
                            <table width="100%">
                                <tbody id="nambahproduk" class="table">
                                    <tr>
                                        <td width="60%">
                                            <select class="form-control prods" id="produk_0">
                                                <option value="">Pilih Barang</option>
                                                @foreach($prods as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="35%"><input class="form-control" placeholder="Value" type="text" id="qty_0"><input class="form-control prodqty" type="hidden" id="qty2_0"></td>
                                        <td width="5%"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12" id="challange" style="display: none;">
                        <div class="form-group" align="left">
                            <label class="form-control-label">Pilih Reward:</label><br>
                            <button type="button" class="btn btn-sm btn-primary add-reward"><i class="fa fa-plus"></i>  Tambah Reward</button>
                            <br><br>
                            <table width="100%">
                                <tbody id="nambahreward" class="table">
                                    <tr>
                                        <td width="60%">
                                            <select class="form-control reward" id="reward_0">
                                                <option value="">Pilih Reward</option>
                                                @foreach($prods as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width="35%"><input class="form-control" placeholder="Qty" type="text" id="qtyreward_0"><input class="form-control qtyreward" type="hidden" id="qtyreward2_0"></td>
                                        <td width="5%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Batas Waktu Penukaran Reward (Dari):</label>
                        <input type="date" id="darireward" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-12 challanges">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Batas Waktu Penukaran Reward (Sampai):</label>
                        <input type="date" id="sampaireward" class="form-control">
                      </div>
                    </div>
                </div>
            
            <div class="modal-footer contents" style="display: none;">
                <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
                <button type="button" id="cancel" class="btn btn-danger ml-auto">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="cancel_confirm" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
                        <td align="center"><img src="./assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="id" ></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Membatalkan Posting ini? </h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="yakin" class="btn btn-primary">Yakin</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>