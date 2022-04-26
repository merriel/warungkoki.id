<div class="modal fade" id="reedem" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Proses Reedem</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                	<div class="col-12" >
		                <div class="card bg-par-2 card-stats mb-4 mb-lg-0">
		                    <div class="card-body shadow">
		                        <div class="row">
		                          	<div class="col-3">
		                              <div class="icon icon-shape bg-iolo text-white rounded-circle shadow">
		                                  <i class="fas fa-car"></i>
		                              </div>
		                            </div>
		                            <div class="col-9" align="right">
		                                <h5 class="card-title text-uppercase mb-0" id="name"></h5>
		                                <h1 class="text-warning" id="saldos"></h1>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	              	</div>
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <label class="form-control-label">Masukan Qty yang Ingin Diambil :</label>
                        <input type="text" style="font-size: 24px" onkeyup="angka(this);" id="qtyreedem" class="form-control">
                        <input type="hidden" id="saldo">
                        <input type="hidden" id="saldo_id">
                      </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" id="reedem" class="btn btn-primary">Reedem</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Cancel</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="token" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title-default">Masukan PIN Anda</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group" align="left">
                        <input type="password" style="font-size: 35px" id="tokenusers" class="form-control">
                        <input type="hidden" id="saldoreedem">
                      </div>
                    </div>
                    <table width="100%">
	            		<tr>
	            			<td align="center"><button type="button" id="reedemtoken" class="btn btn-primary">Reedem</button></td>
	            		</tr>
	            	</table>
                </div>
            </div>
        </div>
    </div>
</div>

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

<div class="modal fade" id="yakin_reedem" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Reedem Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" align="center">
                <table border="0" align="center" width="100%">
                    <tr>
                        <td align="center"><img src="/assets/content/img/theme/info.png"></td>
                    </tr>
                    <tr><td height="20px"><input type="hidden" id="ids" ><input type="hidden" id="qty" ></td></tr>
                    <tr>
                        <td align="center"><h5 class="text-muted">Anda Yakin Akan Reedem Produk Ini? </h5></td>
                    </tr>
                </table>
                

            </div>
            
            <div class="modal-footer">
                <button type="button" id="reedemsekarang" class="btn btn-primary">Reedem</button>
                <button type="button" class="btn btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
            </div>
            
        </div>
    </div>
</div>