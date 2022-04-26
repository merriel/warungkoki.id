<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Konfirmasi Setuju</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Berikut adalah Rincian dari Booking Anda, Harap diperhatikan dengan baik agar tidak terdapat kesalahan dalam pemesanan/booking :</div>
                <hr>
                <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Tempat :</div>
                <div class="card shadow-ss">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="2">
                          <div class="icon icon-shape bg-gradient-shell text-white rounded-circle shadow-ss">
                            <i class="fas fa-compass" style="color: #ffffff"></i>
                        </div>
                        </td>
                        <td><b><div id="konf_wilayah" style="font-size: 14px;color: #323232;"></div></b>
                      </tr>
                      <tr>
                        <td><div id="konf_alamat" style="font-size: 10px"> </div></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <br>
                <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Waktu :</div>
                <div class="card shadow-ss">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="2">
                          <div class="icon icon-shape bg-gradient-shell text-white rounded-circle shadow-ss">
                            <i class="fas fa-calendar" style="color: #ffffff"></i>
                        </div>
                        </td>
                        <td><b><div style="font-size: 14px;color: #323232;" id="konf_tanggal"></div></b>
                          <input type="hidden" id="room_id" value="{{ $detailroom->id }}"></td>
                      </tr>
                      <tr>
                        <td><div style="font-size: 10px" id="konf_waktu">Jam 09:00 s/d 11:00  </div></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <hr>
                <table width="100%">
                  <tr>
                    <td align="left">
                      <b  style="font-size: 14px;color: #323232;">Total Bayar</b>
                    </td>
                    <td align="right">
                      <b class="text-warning" style="font-size: 21px;" id="konf_total">-</b>
                    </td>
                  </tr>
                </table>

            </div>
            
            <div class="modal-footer">
                <table width="100%">
                    <tr>
                        <td align="left">
                            <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Tidak</button> 
                        </td>
                        <td align="right">
                            <button type="button" id="booking" class="btn btn-primary">Setuju Booking</button>
                        </td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>