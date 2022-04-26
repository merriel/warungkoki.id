@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <div class="row">
        <div class="col">
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">List Penjualan</h1>
              <div>Wilayah : {{ $wilayah->name }}</div>
            </div>

            <div class="card shadow">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                      <label>Dari Tanggal</label>
                      <input type="date" class="form-control" value="{{ $dari }}" id="dari">
                  </div>
                  <div class="col-12">
                      <label>Sampai Tanggal</label>
                      <input type="date" class="form-control" value="{{ $sampai }}" id="sampai">
                  </div>
                  <div class="col-12" align="center">
                    <button onclick="Search()" class="btn btn-info">Search</button>
                  </div>
                </div>
                
                <hr>
                <div style="font-size: 16px;"><b>
                  List Penjualan {{ $wilayah->name }} 
                </b></div>
                <div style="padding-bottom: 12px;">Tanggal {{ date("d F Y", strtotime($dari)) }} - {{ date("d F Y", strtotime($sampai)) }}</div>
                  <div style="padding-bottom:7px;"><b>Transaksi Pengambilan di Lokasi ({{ $ambillokasi->count() }})</b></div>
                  <div class="table-responsive">
                    <table class="table" id="customers">
                      <tr>
                        <th>KodeInv</th>
                        <th>Qty</th>
                        <th>Bayar</th>
                        <th>Ops</th>
                      </tr>
                      @php $total=0; @endphp
                      @foreach($ambillokasi as $ambil)

                      @php

                        $allqty = DB::table('transaction_details')
                        ->where("transaction_id", $ambil->id)
                        ->sum('qty');

                        $total += $ambil->amount;

                      @endphp
                      <tr>  
                        <td>{{ $ambil->uuid }}</td>
                        <td>{{ $allqty }}</td>
                        <td align="right" nowrap>{{ rupiah($ambil->amount) }}</td>
                        <td align="center">
                          <a href="/petugas/lihattransaksi?id={{ $ambil->id }}" class="menusxx"><button class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a>
                          </td>
                      </tr>
                      @endforeach
                      <tr>
                        <td colspan="2"><b>TOTAL</b></td>
                        <td align="right" nowrap><b>{{ rupiah($total) }}</b></td>
                        <td></td>
                      </tr>
                    </table>
                  </div>
                
                <hr>
                <div style="padding-bottom:7px;"><b>Transaksi Delivery ({{ $delivery->count() }})</b></div>
                <div class="table-responsive">
                  <table class="table" id="customers">
                    <tr>
                      <th>KodeInv</th>
                      <th>Qty</th>
                      <th>Bayar</th>
                      <th>Ops</th>
                    </tr>
                    @php $total2=0; @endphp
                    @foreach($delivery as $del)

                    @php
                      $stocknya = DB::table('transaction_details')
                      ->where("transaction_id", $del->id)
                      ->get();

                      $allqty = DB::table('transaction_details')
                      ->where("transaction_id", $del->id)
                      ->sum('qty');

                      $total2 += $del->amount;

                    @endphp
                    <tr>  
                      <td>{{ $del->uuid }}</td>
                      <td>{{ $allqty }}</td>
                      <td align="right" nowrap>{{ rupiah($del->amount) }}</td>
                      <td align="center"><a href="/petugas/lihattransaksi?id={{ $del->id }}" class="menusxx"><button class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a></td>
                    </tr>
                    @endforeach
                    <tr>
                      <td colspan="2"><b>TOTAL</b></td>
                      <td align="right" nowrap><b>{{ rupiah($total2) }}</b></td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
        </div> 
      </div> 
      <br><br><br>
    </div>
  </div>

  @include('layout.footer')
  <script type="text/javascript">

    function Search(){

      var dari = $('#dari').val();
      var sampai = $('#sampai').val();

      setTimeout(function(){ window.location.href = '/petugas/pengambilan?dari='+dari+'&sampai='+sampai+''; }, 500);

    }

  </script>
</body>

</html>