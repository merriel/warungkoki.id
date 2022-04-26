@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <!-- Card stats -->
  <div class="ct-title" style="font-size: 24px;margin-bottom: 8px;margin-top: 0.5rem;line-height: 1.2">Transaksi Penjualan Hari ini ({{ date('d F Y') }})</div>
  <hr>
  <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1rem;">
    <div class="card-body" style="padding: 1rem;">
        <div class="table-responsive">
          <table class="table" id="customers">
            <tr>
              <th>KodeInv</th>
              <th>Qty</th>
              <th>Bayar</th>
              <th>Ops</th>
            </tr>
            @php $total=0; @endphp
            @foreach($trans as $ambil)

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
  
  
  <br><br><br><hr>
@include('content.home.petugas.modal')
@include('layout.footer')
<script type="text/javascript">
  

</script>

</body>

</html>
