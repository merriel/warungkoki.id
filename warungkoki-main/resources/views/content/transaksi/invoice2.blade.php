<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice WarungKoki.id</title>
    
    <style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #8a5d3b;
  color: white;
}

#company {
  float: right;
  text-align: right;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}
#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}
body {
  position: relative;
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}
</style>
  </head>
  <body>
    <header class="clearfix">
        <table width="97%">
            <tr>
                <td align="left">
                    <img width="40%" src="https://warungkoki.id/assets/splash/images/warung.png">
                <td>
                <td align="right">
                    <div style="font-size: 24px;"><b>Warungkoki.id</b></div>
                    <div>Jl. Peta Barat No.9a, RW.18, Pegadungan, Kec. Kalideres,</div>
                    <div>Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta </div>
                    <div><a href="mailto:company@example.com">admin@warungkoki.id</a></div>
                </td>
            </tr>
        </table>
      
      </div>
    </header>
    <main>
    <table width="97%">
        <tr>
            <td>
               
                  <div style="font-size: 16px;">INVOICE Ke:</div>
                  <div style="font-size: 21px; padding-bottom: 8px; padding-top: 12px;">{{ $users->name }}</div>
                  <div>{{ $users->email }}</div>
                  <div>{{ $users->no_hp }}</div>
                 
            </td>
            <td align="right">
               
                  <div style="font-size: 24px; padding-bottom: 8px;"><b>INV/{{ date('Y') }}/{{ date('m',  strtotime($hari)) }}/{{ $users->uuid }}</b></div>
                  <div>Tanggal Pembelian: {{ date('d F Y',  strtotime($users->date)) }}</div>
                
            </td>
        </tr>
    </table>
    <br>
      <table border="0" id="customers" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">Produk</th>
            <th class="qty">Qty</th>
            <th class="qty">Harga</th>
            <th class="total">Total</th>
          </tr>
        </thead>
        <tbody>
        @php $no=0 @endphp
        @foreach($invoices as $invoice)
        @php $no++ @endphp
          <tr>
            <td>{{ $no }}</td>
            <td>{{ $invoice->prod_name }} {{ $invoice->post_name }}</td>
            <td>{{ $invoice->qty }}</td>
            <td align="right">{{ rupiah($invoice->amount / $invoice->qty) }}</td>
            <td align="right">{{ rupiah($invoice->amount) }}</td>
          </tr>
        @endforeach
        </tbody>
        @if($orders->delivery != null)
        <tfoot>
          <tr>
            <td colspan="4"><b>PENGIRIMAN {{ strtoupper($orders->delivery_name) }} {{ strtoupper($orders->delivery_type) }}</b></td>
            <td align="right"><b>{{ rupiah($orders->delivery) }}</b></td>
          </tr>
        </tfoot>
        @endif
        <tfoot>
          <tr>
            <td colspan="4"><b>GRAND TOTAL</b></td>
            <td align="right"><b>{{ rupiah($users->total) }}</b></td>           
          </tr>
        </tfoot>
      </table>
      <br><br>
      <div id="thanks">Terimakasih!</div>
      
    </main>
    <footer>
      Invoice ini dibuat otomatis oleh komputer, invoice ini berlaku tanpa tanda tangan dan stempel
    </footer>
  </body>
</html>