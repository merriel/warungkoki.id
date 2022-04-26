@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
  <div class="ct-title" style="font-size: 24px;margin-bottom: 8px;margin-top: 0.5rem;line-height: 1.2">Transaksi Penjualan Hari ini ({{ date('d F Y') }})</div>
  <hr>
  <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1rem;">
    <div class="card-body" style="padding: 1rem;">
        <div style="padding-bottom:7px;"><b>Transaksi Pengambilan di Lokasi ({{ $ambillokasi->count() }})</b></div>
        <div class="table-responsive">
          <table class="table" id="customers">
            <tr>
              <th>KodeInv</th>
              <th>Qty</th>
              <th>Bayar</th>
              <th>Type</th>
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
              @if($ambil->type_bayar == "ONLINE")
                <td align="right" nowrap>GO-Pay</td>
              @else
                <td align="right" nowrap>{{ $ambil->type_bayar }}</td>
              @endif
              <td align="center">
                <a href="/petugas/lihattransaksi?id={{ $ambil->id }}" class="menusxx"><button class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a>
                </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="2"><b>TOTAL</b></td>
              <td align="right" nowrap><b>{{ rupiah($total) }}</b></td>
              <td colspan="2"></td>
            </tr>
          </table>
        </div>
    </div>
  </div>
  
  <hr>
  <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1rem;">
    <div class="card-body" style="padding: 1rem;">
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
  <br><br><br><hr>
@include('content.home.petugas.modal')
@include('layout.footer')
<script type="text/javascript">
  

</script>

</body>

</html>
