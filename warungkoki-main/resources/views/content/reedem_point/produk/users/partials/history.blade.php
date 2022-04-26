<div class="row pop tab-pane fade show active" id="tabs-history" role="tabpanel" aria-labelledby="tabs-history">
    <div class="col">
        <div style="font-size: 14px; padding-bottom: 12px;"><b>Rincian Transaksi Poin:</b></div>
            <table id="customers">
                <tr>
                    
                    <th>Before</th>
                    <th>Amount</th>
                    <th>Sisa</th>
                </tr>
                <tbody>
                    @if($saldos->count() == 0)
                    <tr>
                        <td colspan="4">Tidak ada Transaksi Saldo Apapun untuk saat ini!</td>
                    </tr>
                    @else
                    @foreach($saldos as $sald)
                    <tr>
                        
                        <td align="right">{{ ($sald->before) }}</td>
                        @if($sald->type == "in")
                            <td align="right" class="text-success"><b> +
                                {{ ($sald->amount) }}
                            </b></td>
                        @else
                            <td align="right" class="text-danger"><b> -
                                {{ ($sald->amount) }}
                            </b></td>
                        @endif
                        <td align="right">
                            <b>{{ ($sald->sisa) }}</b>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
