<div class="modal" id="livestream_scanner">
    <div class="modal-dialog">
        <div id="interactive" class="viewport">
                    
        </div>
        <div class="modal-content">
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="melihat" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Lihat Transaksi</h3>
                <hr>
            </div>
            
            <div class="modal-body"  style="padding-bottom: 0px;padding-top: 0px;">
                <div class="row content">
                    <input type="hidden" id="idx">
                    <div class="col-12">
                        <div style="font-size: 11px;"> Nama User :</div>
                        <div style="font-size: 15px;font-weight: bold;" id="user"> </div>
                        <hr>
                        <div style="font-size: 11px;"> Waktu :</div>
                        <div style="font-size: 15px;font-weight: bold;" id="periode"> </div>
                        <hr>
                        <div style="font-size: 11px;padding-bottom: 10px;"> Produk Yang Dibeli :</div>
                        <table id="customers">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Qty</th>
                            </tr>
                            <tbody id="prodx"></tbody>
                        </table>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding-top:0px;">
               
                <button type="button" class="btn btn-absen ml-auto" data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="melihatdelivery" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Lihat Transaksi</h3>
                <hr>
            </div>
            
            <div class="modal-body"  style="padding-bottom: 0px;padding-top: 0px;">
                <div class="row content">
                    <input type="hidden" id="idx">
                    <div class="col-12">
                        <div style="font-size: 11px;"> Nama User :</div>
                        <div style="font-size: 15px;font-weight: bold;" id="user"> </div>
                        <hr>
                        <div style="font-size: 11px;"> Waktu :</div>
                        <div style="font-size: 15px;font-weight: bold;" id="periode"> </div>
                        <hr>
                        <div style="font-size: 11px;padding-bottom: 10px;"> Produk Yang Dibeli :</div>
                        <table id="customers">
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            <tbody id="prodx"></tbody>
                            <tbody id="delivery"></tbody>
                        </table>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding-top:0px;">
               
                <button type="button" class="btn btn-absen ml-auto" data-dismiss="modal">Close</button> 
            </div>
            
        </div>
    </div>
</div>