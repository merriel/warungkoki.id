@if($type == 'all')
<h4>PENJUALAN</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Jam Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Nama Produk</th>
            <th>Metode Bayar</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Jumlah Total Rp</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($penjualans as $penjualan)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($penjualan->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($penjualan->created_at)) }}</td>
            <td>{{ $penjualan->user_name }}</td>
            <td>{{ $penjualan->prod_name }} {{ $penjualan->post_name }}</td>
            <td>{{ $penjualan->type_bayar }}</td>
            <td>{{ $penjualan->qty }}</td>
            <td>{{ $penjualan->amount / $penjualan->qty }}</td>
            <td>{{ $penjualan->amount }}</td>           
        </tr>
    @endforeach
    </tbody>
</table>

<br>

<h4>REEDEM</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Reedem</th>
            <th>Jam Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Produk yang Di Reedem</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Petugas</th>
            <th>Keterangan Reedem</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($reedems as $reedem)

        @php

        $petugas = DB::table('users')
        ->where('id', $reedem->petugas_id)
        ->first();

        if($reedem->type_post == 'Products'){

            $harga = $reedem->harga_act;

        } else {

            $harga = 0;

        }

        @endphp

        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($reedem->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($reedem->created_at)) }}</td>
            <td>{{ $reedem->user_name }}</td> 
            <td>{{ $reedem->prod_name }} {{ $reedem->post_name }}</td>
            <td>{{ $reedem->qty }}</td>
            <td>{{ $harga * $reedem->qty }}</td>    
            <td>{{ $petugas->name }}</td>
            <td>{{ $reedem->ket }}</td>       
        </tr>
    @endforeach
    </tbody>
</table>

@elseif($type == 'penjualan')

<h4>PENJUALAN</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Jam Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Nama Produk</th>
            <th>Metode Bayar</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Jumlah Total Rp</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($penjualans as $penjualan)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($penjualan->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($penjualan->created_at)) }}</td>
            <td>{{ $penjualan->user_name }}</td>
            <td>{{ $penjualan->prod_name }} {{ $penjualan->post_name }}</td>
            <td>{{ $penjualan->type_bayar }}</td>
            <td>{{ $penjualan->qty }}</td>
            <td>{{ $penjualan->amount / $penjualan->qty }}</td>
            <td>{{ $penjualan->amount }}</td>           
        </tr>
    @endforeach
    </tbody>
</table>

@else

<h4>REEDEM</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Reedem</th>
            <th>Jam Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Produk yang Di Reedem</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Petugas</th>
            <th>Keterangan Reedem</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($reedems as $reedem)

        @php

        $petugas = DB::table('users')
        ->where('id', $reedem->petugas_id)
        ->first();

        if($reedem->type_post == 'Products'){

            $harga = $reedem->harga_act;

        } else {

            $harga = 0;

        }

        @endphp

        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($reedem->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($reedem->created_at)) }}</td>
            <td>{{ $reedem->user_name }}</td> 
            <td>{{ $reedem->prod_name }} {{ $reedem->post_name }}</td>
            <td>{{ $reedem->qty }}</td>
            <td>{{ $harga * $reedem->qty }}</td>    
            <td>{{ $petugas->name }}</td>
            <td>{{ $reedem->ket }}</td>      
        </tr>
    @endforeach
    </tbody>
</table>

@endif