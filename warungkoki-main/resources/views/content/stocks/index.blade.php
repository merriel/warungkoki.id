@include('layout.head')
<style type="text/css">
  
</style>
<div class="main-content">   
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
    <div class="row">
      <div class="col">
        <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Monitoring Stock</h1>
          </div>         
         <hr>
       </div>
      <div class="col-12">
        <div class="card shadow" style="padding: 1.5rem; border-radius: 1rem;">
          <label>Pilih Wilayah : </label>
          <select class="form-control" id="cabang">
            @foreach($wilayah as $wil)
            <option value="{{ $wil->uuid }}" {{ $wils->uuid == $wil->uuid ? "selected" : "" }}>{{ $wil->name }}</option>
            @endforeach
          </select>
          <div style="padding-bottom:8px;"></div>
          <label>Pilih Tanggal : </label>
          <input type="date" class="form-control" id="tanggal" value="{{ $tanggal }}">
          <hr>
          <div style="font-size:16px;"><b>Data STOCK Wilayah {{ $wils->name }}</b></div>
          <div style="font-size:12px;padding-bottom: 16px;">Untuk Stock pada tanggal {{ date('d F Y',strtotime($tanggal)) }}</div>

          <table id="customers" width="50%">
            <tr>
              <th colspan="2">KETERANGAN :</th>
            </tr>
            <tr>
              <td>PAGI</td>
              <td>Menginput Stock awal pada pagi hari</td>
            </tr>
            <tr>
              <td>MSUK</td>
              <td>Menginput Stock Barang yang Masuk ke Toko</td>
            </tr>
            <tr>
              <td>RTUR</td>
              <td>Menginput Retur Barang dari Pemasukan</td>
            </tr>
            <tr>
              <td>TKKL</td>
              <td>Kirim Barang Antar Toko Barang Keluar ke Toko Lain</td>
            </tr>
            <tr>
              <td>TKMS</td>
              <td>Menerima Barang dari Toko Lain Masuk Barang</td>
            </tr>
            <tr>
              <td>JUAL</td>
              <td>Data barang yang terjual</td>
            </tr>
            <tr>
              <td>MALM</td>
              <td>Menginput Stock Akhir di Malam Hari mau Tutup</td>
            </tr>
          </table>
          <hr>

          <div class="table-responsive">
            <!-- Projects table -->
            <table id="customers" width="100%">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Produk</th>
                  <th>Varian</th>
                  <th width="5%">PAGI</th>
                  <th width="5%">MSUK</th>
                  <th width="5%">RTUR</th>
                  <th width="5%">TKKL</th>
                  <th width="5%">TKMS</th>
                  <th width="5%">JUAL</th>
                  <th width="5%">MALM</th>
                </tr>
              </thead>
              <tbody>

                @foreach($posts as $post)
                <tr>
                  <td nowrap>{{ $post->kode }}</td>
                  <td nowrap>{{ $post->prod_name }}</td>
                  <td nowrap>{{ $post->name }}</td>

                  <!-- === CEK PAGI STOK === -->

                  @if($pagi)
                    @php
                      $stockpagi = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->where("post_id", $post->id)
                      ->where("stocktransaction_id", $pagi->id)
                      ->first();
                    @endphp

                    @if($stockpagi)
                      <td><b>{{ $stockpagi->qty }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif


                  <!-- === CEK PEMASUKAN BARANG === -->

                  @if($masuk)
                    @php
                      $stockmasuk = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->join("stock_transactions", "stock_transaction_details.stocktransaction_id", "=", "stock_transactions.id")
                      ->where("post_id", $post->id)
                      ->where("type","in")
                      ->where("jenis","pemasukan")
                      ->where("wilayah_id",$wils->id)
                      ->where("date",$tanggal)
                      ->sum('qty');
                    @endphp

                    @if($stockmasuk != 0)
                      <td><b class="text-success">+ {{ $stockmasuk }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif

                  <!-- === CEK RETUR BARANG === -->

                  @if($retur)
                    @php
                      $stockretur = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->join("stock_transactions", "stock_transaction_details.stocktransaction_id", "=", "stock_transactions.id")
                      ->where("post_id", $post->id)
                      ->where("type","out")
                      ->where("jenis","retur")
                      ->where("wilayah_id",$wils->id)
                      ->where("date",$tanggal)
                      ->sum('qty');
                    @endphp

                    @if($stockretur != 0)
                      <td><b class="text-danger">- {{ $stockretur }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif


                  <!-- === CEK INTRATOKO KELUAR BARANG === -->

                  @if($intratokokeluar)
                    @php
                      $stockintratokokeluar = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->join("stock_transactions", "stock_transaction_details.stocktransaction_id", "=", "stock_transactions.id")
                      ->where("post_id", $post->id)
                      ->where("type","out")
                      ->where("jenis","intratoko")
                      ->where("wilayah_id",$wils->id)
                      ->where("date",$tanggal)
                      ->sum('qty');
                    @endphp

                    @if($stockintratokokeluar != 0)
                      <td><b class="text-danger">- {{ $stockintratokokeluar }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif

                  <!-- === CEK INTRATOKO MASUK BARANG === -->

                  @if($intratokomasuk)
                    @php
                      $stockintratokomasuk = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->join("stock_transactions", "stock_transaction_details.stocktransaction_id", "=", "stock_transactions.id")
                      ->where("post_id", $post->id)
                      ->where("type","in")
                      ->where("jenis","intratoko")
                      ->where("wilayah_id",$wils->id)
                      ->where("date",$tanggal)
                       ->sum('qty');
                    @endphp

                    @if($stockintratokomasuk != 0)
                      <td><b class="text-success">+ {{ $stockintratokomasuk }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif

                  <!-- === CEK PENJUALAN ==== -->

                  @php
                    $terjual = DB::table('transaction_details')
                    ->select("transaction_details.qty")
                    ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                    ->where("transaction_details.post_id", $post->id)
                    ->where("transactions.status", "APPROVED")
                    ->whereDate("transactions.created_at", $tanggal)
                    ->sum('qty');
                  @endphp

                  @if($terjual == 0)
                    <td><b>{{ $terjual }}</b></td>
                  @else
                    <td><b class="text-danger">- {{ $terjual }}</b></td>
                  @endif

                  <!-- === CEK MALAM === -->

                  @if($malam)
                    @php
                      $stockmalam = DB::table('stock_transaction_details')
                      ->select("stock_transaction_details.qty")
                      ->where("post_id", $post->id)
                      ->where("stocktransaction_id", $malam->id)
                      ->first();
                    @endphp

                    @if($stockmalam)
                      <td><b>{{ $stockmalam->qty }}</b></td>
                    @else
                      <td><b>0</b></td>
                    @endif
                    
                  @else
                    <td><b>0</b></td>
                  @endif

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
      <hr>

    </div> 
  </div>
</div>


@include('layout.footer')
<script type="text/javascript">
  
$('#cabang').on('change', function () {

  var uuid = $(this).val();
  var tanggal = $('#tanggal').val();

  setTimeout(function(){ window.location.href = '/stocks?uuid='+uuid+'&date='+tanggal+''; }, 1000);

});

$('#tanggal').on('change', function () {

  var tanggal = $(this).val();
  var uuid = $('#cabang').val();

  setTimeout(function(){ window.location.href = '/stocks?uuid='+uuid+'&date='+tanggal+''; }, 1000);

});


</script>
</body>
</html>