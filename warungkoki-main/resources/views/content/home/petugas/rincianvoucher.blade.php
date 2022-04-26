<hr>
<div style="font-size: 15px;padding-bottom: 10px;font-weight: bold">
  Rincian Transaksi Petugas untuk <b>{{ $promo->name }}</b>
</div>
<table id="customers">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Banyak</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
    @foreach($petugasvouchers as $petugas)
    <tr>
      <td>{{ $petugas->name }}</td>
      <td>{{ $petugas->transaksi }}</td>
      <td align="right"><b>{{ number_format($petugas->amount,0,',','.') }}</b></td>
    </tr>
    @endforeach
    
  </tbody>
</table>