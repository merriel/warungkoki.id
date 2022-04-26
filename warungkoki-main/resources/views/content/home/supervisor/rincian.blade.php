<div class="table-responsive">
    @if($stocks->count() != 0)
        <input type="hidden" id="sebelumnyaid" value="{{ $sebelumnya->id }}">
    @endif
    <table id="customers">
        <tr>
            <th>Nama Produk</th>
            <th>Sebelum</th>
            <th>Perubahan</th>
        </tr>
        <tbody>
            @if($stocks->count() == 0)
                <tr>
                    <td colspan="3">Data Kosong</td>
                </tr>
            @else
                @foreach($stocks as $stk)

                @php

                    $qtynya = DB::table('stock_transaction_details')
                    ->where("stocktransaction_id", $sebelumnya->id)
                    ->where("post_id", $stk->post_id)
                    ->first();

                    if($qty){
                        $sebelum = $qtynya->qty == NULL ? 0 : $qtynya->qty;
                        $perubahan = $stk->qty == NULL ? '0' : $stk->qty;
                    } else {
                        $sebelum = 0;
                        $perubahan = 0;
                    }

                @endphp
                <tr>
                    <td nowrap>{{ $stk->prod_name }} {{ $stk->post_name }}</td>
                    <td>{{ $sebelum }}</td>
                    @if($sebelum != $perubahan)
                        <td class="text-warning"><b>{{ $perubahan }}</b></td>
                    @else
                        <td>{{ $perubahan }}</td>
                    @endif
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>