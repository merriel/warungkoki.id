@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-1 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Post Baru</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Pilih Type Post:</label>
                      <br><br>
                      <table border="0" align="center" width="100%">
                        <tr>
                          <td align="center" width="25%">
                            <div id="dealnew" class="icon icon-shape bg-iolo-blue text-white rounded-circle shadow new">
                                <i class="fas fa-handshake" style="color: #ffffff"></i>
                            </div>
                          </td>
                          <td align="center" width="25%">
                            <div id="challangenew" class="icon icon-shape bg-iolo-blue text-white rounded-circle shadow new">
                                <i class="fas fa-gamepad" style="color: #ffffff"></i>
                                <input type="hidden" id="selesai" value="0">
                            </div>
                          </td>
                          <td align="center" width="25%">
                            <div id="reedemnew" class="icon icon-shape bg-iolo-blue text-white rounded-circle shadow new">
                                <i class="fas fa-coffee" style="color: #ffffff"></i>
                            </div>
                          </td>
                          <td align="center" width="25%">
                            <div id="rewardnew" class="icon icon-shape bg-iolo-blue text-white rounded-circle shadow new">
                                <i class="fas fa-gift" style="color: #ffffff"></i>
                            </div>
                          </td>
                          
                        </tr>
                        <tr>
                           <td height="10px" colspan="7"></td> 
                        </tr>
                        <tr>
                          <td align="center">
                            <h6 class="text-uppercase ls-1 mb-1">Deals</h6>
                          </td>
                          <td align="center">
                            <h6 class="text-uppercase ls-1 mb-1">Challange</h6>
                          </td>
                          <td align="center">
                            <h6 class="text-uppercase ls-1 mb-1">Reedem</h6>
                          </td>
                          <td align="center">
                            <h6 class="text-uppercase ls-1 mb-1">Reward</h6>
                          </td>
                          
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Nama</label>
                      <input type="text" id="username" class="form-control form-control-alternative" placeholder="Nama Post">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-email">Deskripsi</label>
                      <textarea class="form-control"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">Harga</label>
                      <input type="text" id="first-name" class="form-control form-control-alternative edited" placeholder="Harga">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">Pilih Produk</label>
                      <table border="0" align="center" width="100%">
                        <tr>
                          <td>
                            <span class="badge badge-success">Helm Shell</span>
                          </td>
                          <td width="5%"></td>
                          <td width="40%"><input type="text" class="form-control form-control-alternative edited" placeholder="Qty"></td>
                        </tr>
                        <tr>
                          <td></td>
                        </tr>
                        <tr>
                          <td>
                            <span class="badge badge-success">V-Power</span>
                          </td>
                          <td width="5%"></td>
                          <td width="40%"><input type="text" class="form-control form-control-alternative edited" placeholder="Qty"></td>
                        </tr>
                        <tr>
                          <td></td>
                        </tr>
                        <tr>
                          <td>
                            <span class="badge badge-success">Gantungan Kunci</span>
                          </td>
                          <td width="5%"></td>
                          <td width="40%"><input type="text" class="form-control form-control-alternative edited" placeholder="Qty"></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">Upload Gambar</label>
                      <input type="file" id="upload_gambar">
                    </div>
                  </div>
                </div>
              </div>
              
              <div id="button-simpan" align="center"><button class="btn btn-success" id="kembali">Simpan</button></div>
            </div>
          </div>
        </div>
        
      
        @include('layout.footer')
        @include('script.newpost')
</body>

</html>