@include('layout.head')
<style type="text/css">
  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 10px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: #feac3b;
    color: white;
  }
</style>
<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 18rem;">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->
      	<!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
      
    </div>
  </div>
</div>
<br>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      	<div class="row justify-content-center">
          	<h5>Saldo Warungkoki Anda :</h5>   	
      	</div>
      	<div class="row justify-content-center">
      		<div style="font-size: 32px;"><b>{{ $adasaldo ? rupiah($adasaldo->sisa) : 'Rp. 0' }}</b></div>
      	</div>
      	<br>
      	<div class="card">
            <div class="card-body" style="padding-top: 0.2rem;">
            	<br>
            	<div style="font-size: 14px; padding-bottom: 12px;"><b>Rincian Transaksi :</b></div>
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
            				
            				<td align="right">{{ rupiah($sald->before) }}</td>
            				@if($sald->type == "in")
	            				<td align="right" class="text-success"><b> +
	            					{{ rupiah($sald->amount) }}
	            				</b></td>
            				@else
            					<td align="right" class="text-danger"><b> -
	            					{{ rupiah($sald->amount) }}
	            				</b></td>
            				@endif
            				<td align="right">
            					<b>{{ rupiah($sald->sisa) }}</b>
            				</td>
            			</tr>
            			@endforeach
            			@endif
            		</tbody>
            	</table>
            </div>
      	</div>
    </div>
        
@include('layout.footer')

        
</body>

</html>