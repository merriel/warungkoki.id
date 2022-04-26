<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>INVOICE Warungkoki.id</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="https://warungkoki.id/assets/splash/images/waungkoki.png" style="width: 100%; max-width: 300px" />
								</td>

								<td width="50%">
									<div style="padding-top:18px;">
										Invoice #: {{ $transaction->uuid }}<br />
										Tanggal : {{ date('d F Y', strtotime($transaction->updated_at)) }}<br />
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Warungkoki.id<br />
									Jl. Peta Barat No.9a Pegadungan<br />
									Kalideres Jakarta Barat
								</td>

								<td>
									{{ $transaction->user_name }}<br />
									{{ $transaction->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Metode Pembayaran</td>

					<td>Nominal #</td>
				</tr>

				<tr class="details">
					<td>{{ $transaction->type_bayar }}</td>
					<td>Rp. {{ number_format($transaction->amount,0,',','.') }}</td>
				</tr>

				<tr class="heading">
					<td>Item</td>

					<td>Price</td>
				</tr>
				@php $grandtotal=0; @endphp
				@foreach($detailtransaction as $det)
				@php
				$harga = $det->amount / $det->qty;
				$grandtotal += $det->amount;
				@endphp
				<tr class="item">
					<td>{{ $det->prod_name }} {{ $det->post_name }} ({{ $det->qty }})</td>
					@if($harga == 55000)
					<td>Rp. 64.000</td>
					@else
					<td>Rp. {{ number_format($harga) }}</td>
					@endif
					
				</tr>
				@endforeach

				@php
				if($grandtotal == 55000){

					$grandtotal == 64000;
				} else {

					$grandtotal == $grandtotal;
				}

				@endphp

				<!-- ====== JIKA PENGIRIMAN ===== -->
				@if($transaction->alamat_id != null)
				<tr class="item">
					<td>Pengiriman {{ $transaction->delivery_name }} {{ $transaction->delivery_type }}</td>

					<td>Rp. {{ number_format($transaction->delivery,0,',','.') }}</td>
				</tr>
				@endif

				<!-- ======= JIKA ADA DISKON ===== -->
				@if($transaction->diskon != null)
				<tr class="total">
					<td></td>
					@if($transaction->alamat_id != null)
						<td>Total:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal + $transaction->delivery,0,',','.') }}</td>
					@else
						<td>Total:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal,0,',','.') }}</td>
					@endif
				</tr>

				<tr class="total">
					<td></td>
					<td>Diskon ({{ $transaction->diskon }}):&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal * ((int)$transaction->diskon/100),0,',','.') }}</td>
				</tr>
				@endif

				<!-- ===== JIKA ADA VOUCHERS ===== -->

				@if($transaction->voucherdet_id != null)
				<tr class="total">
					<td></td>
					@if($transaction->alamat_id != null)
						<td>Total:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal + $transaction->delivery,0,',','.') }}</td>
					@else
						@if($transaction->voucherid == 3)
						<td>Total:&nbsp;&nbsp;&nbsp; Rp. 64.000</td>
						@else
						<td>Total:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal,0,',','.') }}</td>
						@endif
					@endif
				</tr>
					@if($transaction->voucher_amount == NULL)

						@php
						$potxx = $grandtotal * ($transaction->percent/100);

						@endphp
						<tr class="total">
							<td></td>
							<td>Potongan Voucher :&nbsp;&nbsp;&nbsp; Rp. {{ number_format($potxx,0,',','.') }}</td>
						</tr>
					@else
						<tr class="total">
							<td></td>
							<td>Potongan Voucher :&nbsp;&nbsp;&nbsp; Rp. {{ number_format($transaction->voucherid == 3 ? 20000 : $transaction->voucher_amount) }}</td>
						</tr>
					@endif
				@endif

				<tr class="total">
					<td></td>
					@if($transaction->alamat_id != null)
						@if($transaction->voucherdet_id != null)
							@if($transaction->voucher_amount == NULL)
								<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal + $transaction->delivery - $potxx) }}</td>
							@else
								<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal + $transaction->delivery - $transaction->voucher_amount) }}</td>
							@endif
						@else

							<td>Total Bayar :&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal + $transaction->delivery,0,',','.') }}</td>
						@endif
					@else 
						@if($transaction->diskon != null)
							<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal - ($grandtotal * ((int)$transaction->diskon/100)),0,',','.') }}</td>

						@elseif($transaction->voucherdet_id != null)
							@if($transaction->voucherid == 3)
							<td>Total:&nbsp;&nbsp;&nbsp; Rp. 44.000</td>
							@else

								@if($transaction->voucher_amount == NULL)
									<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal - $potxx) }}</td>
								@else
									<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal - $transaction->voucher_amount) }}</td>
								@endif
							
							@endif
							
						@else
							<td>Total Bayar:&nbsp;&nbsp;&nbsp; Rp. {{ number_format($grandtotal,0,',','.') }}</td>
						@endif
					@endif
				</tr>
			</table>
		</div>
	</body>
</html>