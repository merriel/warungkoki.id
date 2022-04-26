<div class="modal fade" id="proses" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Proses Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px">
                         <input type="hidden" id="idx"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Proses Pengiriman ini, Pastikan Barang nya sudah di packing dengan Rapi ya sebelum diberikan ke Kurir?</h5></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="Simpan()" class="btn btn-success">Proses Sekarang</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="proses2" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Proses Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <input type="hidden" id="idp">
                <label>Foto Barang : </label>
                <div class="row">
                    <div class="col-12">
                        <div id="foto1"></div>
                        <input type="hidden" id="img1">
                        <div id="akhirtombol1" style="display: none;">
                            <table width="100%">
                                <tr>
                                    <td width="80%">
                                        <div onclick="$('.uploadfoto1').click();">
                                            <button class="btn btn-info btn-block">
                                                <i class="ni ni-image text-white"></i> Ganti Gambar
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button onclick="HapusNew(1)" class='btn btn-danger btn-block'><i class='ni ni-fat-remove text-white'></i></button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="awaltombol1">
                            <div onclick="$('.uploadfoto1').click();">
                                <button class="btn btn-info btn-block">
                                    <i class="ni ni-image text-white"></i> Upload Gambar
                                </button>
                            </div>
                        </div>
                        
                        <input class="uploadfoto1" name="file" type="file" style="display:none;"/>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="SimpanProses()" class="btn btn-success menusxx">Proses Sekarang</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Cancel/Batalkan Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <label>Keterangan Kenapa Dibatalkan?</label> 
                <input type="hidden" id="idc">
                <textarea class="form-control" id="ket" rows="9"></textarea>
                <br>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="Batalkan()" class="btn btn-info">Batalkan Sekarang</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="konfirmcancel" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Batalkan Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px">
                         <input type="hidden" id="idx"></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Apakah Anda Yakin akan Membatalkan Pengiriman ini, Pastikan Anda memberikan Alasan dalam memproses pembatalan Pengiriman ini!</h5></td>
                    </tr>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
                <button type="button" onclick="YakinBatal()" class="btn btn-info">Yakin Batalkan</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="selesai" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Selesai Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <input type="hidden" id="ids">
                <label>Foto Selesai</label>
                <div class="row">
                    <div class="col-12">
                        <div id="foto2"></div>
                        <input type="hidden" id="img2">
                        <div id="akhirtombol2" style="display: none;">
                            <table width="100%">
                                <tr>
                                    <td width="80%">
                                        <div onclick="$('.uploadfoto2').click();">
                                            <button class="btn btn-info btn-block">
                                                <i class="ni ni-image text-white"></i> Ganti Gambar
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button onclick="HapusNew(2)" class='btn btn-danger btn-block'><i class='ni ni-fat-remove text-white'></i></button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="awaltombol2">
                            <div onclick="$('.uploadfoto2').click();">
                                <button class="btn btn-info btn-block">
                                    <i class="ni ni-image text-white"></i> Upload Gambar
                                </button>
                            </div>
                        </div>
                        
                        <input class="uploadfoto2" name="file" type="file" style="display:none;"/>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" onclick="SimpanSelesai()" class="btn btn-success menusxx">Selesai Delivery</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>