@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="row">
        <div class="col">
            <div class="ct-page-title">
              <h1 id="content" style="margin-top:1rem;margin-bottom: 0px;">Pembayaran Selesai</h1>
              <div>Dilakukan Oleh Petugas <b>{{ Auth::user()->name }}</b> pada tanggal {{ date('d F Y', strtotime($tanggalnya)) }} </div>
            </div>
            <hr>
            <div class="card shadow">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                      <label>Tanggal</label>
                      <input type="date" class="form-control" value="{{ $tanggalnya }}" id="tanggal">
                  </div>
                </div>
                
                <hr>
                <div style="padding-bottom:7px;"><b>Transaksi Selesai ({{ $transaction->count() }})</b></div>
                <div class="table-responsive">
                  <table class="table" id="customers">
                    <tr>
                      <th>KodeInv</th>
                      <th>Qty</th>
                      <th>Bayar</th>
                      <th>Ops</th>
                    </tr>
                    @php $total=0; @endphp
                    @foreach($transaction as $ambil)

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

              </div>
            </div>
        </div> 
      </div> 
      <br><br><br>
    </div>
  </div>

  @include('layout.footer')
  <script type="text/javascript">

    $('#tanggal').on('change', function () {

      var tgl = $('#tanggal').val();

      setTimeout(function(){ window.location.href = '/reedem/bayarselesai?tanggal='+tgl+''; }, 500);

    });

  </script>
</body>

</html>