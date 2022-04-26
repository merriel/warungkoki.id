<div class="modal fade" id="barcode" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Barcode</h2>

            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left" id="img_barcode">
                        
                      </div>
                      <div style="font-size: 12px;"><b>Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</b></div>
                      <hr>
                      <a href="/users/transaksi"><button type="button" class="btn btn-success">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Download</h2>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      
                      <table width="100%">
                        <tr>
                          <td colspan="2" style="padding-bottom: 8px;">Dari Tanggal :</td>
                        </tr>
                        <tr>
                          <td><input type="date" id="daritanggal" value="{{ date('Y-m-01') }}" class="form-control"></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td colspan="2" style="padding-bottom: 8px;">Sampai Tanggal :</td>
                        </tr>
                        <tr>
                          <td><input type="date" id="sampaitanggal" value="{{ date('Y-m-t') }}" class="form-control"></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td colspan="4" style="padding-bottom: 8px;">Type Report</td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <select class="form-control" id="type">
                              <option value="all">All</option>
                              <option value="pembelian">Transaksi Pembelian</option>
                              <option value="reedem">Transaksi Reedem</option>
                            </select>
                          </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td colspan="4" align="center" id="downloaddata">
                            <button class="btn btn-success">Download</button>
                          </td>
                        </tr>
                      </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="retur" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 0px;">
                <div class="col-12" style="padding: 0px;">
                    <div style="font-size: 18px;">
                        <b>Pengajuan Pengembalian</b>
                    </div>
                </div>
            </div>
            <div class="modal-body"  style="padding-bottom: 0px;padding-top: 16px;">
                <div class="row content" id="content1">
                    
                    <div class="col-12" style="padding-bottom: 0px;">
                        <label>Upload Foto :</label>
                        <div class="photos"></div>
                        <input class="imgs" type="hidden">
                        <div onclick="$('#uploadfoto').click();">
                            <button class="btn btn-primary btn-block">
                                <i class="ni ni-image text-white"></i> Upload Foto
                            </button>
                        </div>
                        <input id="uploadfoto" name="file" type="file" style="display:none;"/>
                        <br> 
 
                        <label>Keterangan Pengembalian :</label>
                        <textarea class="form-control" id="ket" placeholder="Isikan Alasan mengapa dikembalikan" rows="7"></textarea>
                        <input type="hidden" id="idx">
                    </div>
                </div>
            </div>
            
            <div class="modal-footer tombol" id="tombol1">
                <table width="100%">
                    <tr>
                        <td>
                            <button type="button" class="btn btn-secondary btn-block ml-auto" data-dismiss="modal">Batal</button> 
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                        <td>
                            <button type="button" onclick="Kirim()" class="btn btn-block btn-success ml-auto menusxx">Kirim</button> 
                        </td>
                    </tr> 
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lihatretur" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 0px;">
                <div class="col-12" style="padding: 0px;">
                    <div style="font-size: 18px;">
                        <b>Lihat Pengajuan Pengembalian</b>
                    </div>
                </div>
            </div>
            <div class="modal-body"  style="padding-bottom: 0px;padding-top: 16px;">
                <div class="row content" id="content1">
                    
                    <div class="col-12" style="padding-bottom: 0px;">
                        <label>Foto :</label>
                        @if($ada == 1)
                            @if($retur)
                            <div class="lihatphotos">
                                <img width="100%" src="/assets/img_retur/{{ $retur->img }}">
                            </div>
                            @endif
                            <br> 
     
                            <label>Keterangan Pengajuan :</label>
                            @if($retur)
                            <div style="font-size: 13px;">
                                {{ $retur->ket }}
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="modal-footer tombol" id="tombol1">
                <table width="100%">
                    <tr>
                        <td>
                            <button type="button" class="btn btn-secondary btn-block ml-auto" data-dismiss="modal">Tutup</button> 
                        </td>
                        <td width="5%">
                            &nbsp;
                        </td>
                    </tr> 
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ovomodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Persetujuan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">

                <div class="row">
                    <div class="col-md-12">
                    <div align="left" style="font-size:11px;padding-bottom: 5px;">Pastikan OVO ID Anda sudah terdaftar di AplikasI OVO</div>
                      <div class="form-group" align="left">
                        <input type="text" value="{{ Auth::user()->ovo }}" id="ovoid" class="form-control isian" placeholder="Contoh : 0811000111">
                        <input type="hidden" id="idz">
                      </div>
                    </div>
                    <table width="100%">
                        <tr>
                            <td align="center"><button type="button" onclick="OVO();" class="btn btn-primary">Konfirmasi</button></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="ovoproses" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-body"  style="padding-top: 18px;">
                <div class="row content" id="content1" >
                    <div class="col-12">
                        <img src="/assets/content/img/theme/ovoproses.jpg" width="100%"><br>
                        <div style="font-size: 18px;color: #4c3494;">
                            <b>CEK APLIKASI OVO ANDA!</b>
                        </div>
                        <div style="font-size: 12px;" >
                            Lakukan Proses Pembayaran dari Aplikasi OVO Anda, untuk menyelesaikan Pembayaran Anda!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
