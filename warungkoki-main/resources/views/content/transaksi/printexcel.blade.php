@if($type == 'all')
<h4>PEMBELIAN</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Jam Transaksi</th>
            <th>Nama Outlet</th>
            <th>Jenis</th>
            <th>Nama Post</th>
            <th>Metode Bayar</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($pembelians as $pembelian)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($pembelian->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($pembelian->created_at)) }}</td>
            <td>{{ $pembelian->wilayah_name }}</td>
            <td>{{ $pembelian->type_post }}</td>
            <td>{{ $pembelian->post_name }}</td>
            <td>{{ $pembelian->type_bayar }}</td>
            <td>{{ $pembelian->qty }}</td>
            <td>{{ $pembelian->amount }}</td>  
            <td>{{ $pembelian->status }}</td>          
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
            <th>Nama Outlet</th>
            <th>Jenis</th>
            <th>Nama Post</th>
            <th>Produk yang Di Reedem</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Status</th>
            <th>Keterangan Reedem</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($reedems as $reedem)

        @php

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
            <td>{{ $reedem->wilayah_name }}</td>
            <td>{{ $reedem->type_post }}</td>
            <td>{{ $reedem->post_name }}</td>
            <td>{{ $reedem->prod_name }}</td>
            <td>{{ $reedem->qty }}</td>
            <td>{{ $harga * $reedem->qty }}</td>  
            <td>{{ $reedem->status }}</td> 
            <td>{{ $reedem->ket }}</td>         
        </tr>

    @endforeach
    </tbody>
</table>

@elseif($type == 'pembelian')

<h4>PEMBELIAN</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pembelian</th>
            <th>Jam Transaksi</th>
            <th>Nama Outlet</th>
            <th>Jenis</th>
            <th>Nama Post</th>
            <th>Metode Bayar</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($pembelians as $pembelian)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ date('d M Y', strtotime($pembelian->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($pembelian->created_at)) }}</td>
            <td>{{ $pembelian->wilayah_name }}</td>
            <td>{{ $pembelian->type_post }}</td>
            <td>{{ $pembelian->post_name }}</td>
            <td>{{ $pembelian->type_bayar }}</td>
            <td>{{ $pembelian->qty }}</td>
            <td>{{ $pembelian->amount }}</td>  
            <td>{{ $pembelian->status }}</td>          
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
            <th>Nama Outlet</th>
            <th>Jenis</th>
            <th>Nama Post</th>
            <th>Produk yang Di Reedem</th>
            <th>Qty</th>
            <th>Jumlah Total Rp</th>
            <th>Status</th>
            <th>Keterangan Reedem</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($reedems as $reedem)

        @php

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
            <td>{{ $reedem->wilayah_name }}</td>
            <td>{{ $reedem->type_post }}</td>
            <td>{{ $reedem->post_name }}</td>
            <td>{{ $reedem->prod_name }}</td>
            <td>{{ $reedem->qty }}</td>
            <td>{{ $harga * $reedem->qty }}</td>  
            <td>{{ $reedem->status }}</td> 
            <td>{{ $reedem->ket }}</td>         
        </tr>

    @endforeach
    </tbody>
</table>

@endif