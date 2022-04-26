@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-4 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          	@if($paket->type == 'Deals')
	      	<a href="/users/deals"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Back</button></a>
	      	@else
	      	<a href="/users/myproducts"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Back</button></a>
	      	@endif
          
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid mt--9">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          	<div class="row justify-content-center">
          		@if($paket->type == 'Deals')
              	<h2 class="text-white">Deals {{ $paket->name }}</h2>
              	@else
              	<h2 class="text-white">Produk {{ $paket->name }}</h2>
              	@endif
          	</div>
          	<br>
          	<div class="card">
	            <div class="card-body">
	            	<br>
	            	@foreach($saldos as $saldo)
	              	<div class="col-12" >
	              		@php
                        	$details = DB::table('saldo')
                        	->select("product.name", "saldo.id", "saldo.sisa")
                        	->join("product", "saldo.product_id", "=", "product.id")
                            ->where([
                                ['user_id', '=', $saldo->user_id],
                                ['post_id', '=', $saldo->post_id],
                                ['product_id', '=', $saldo->product_id],
                            ])
                            ->orderBy('id', 'desc')
                            ->first();

                        @endphp
                        @if($details->sisa >= 1)
		                <div class="card card-stats mb-4 mb-lg-0">
		                    <div class="card-body shadow">
		                        <div class="row" id="data_{{ $details->id }}" onclick="Buka({{ $details->id }})">
		                          	<div class="col-3">
		                              <div class="icon icon-shape bg-iolo text-white rounded-circle shadow">
		                                  <i class="fas fa-car"></i>
		                              </div>
		                            </div>
		                            <div class="col-9" align="right">
		                            	<div class="text-warning" style="font-size: 10px;"><b>Lokasi : {{ $paket->wilayah_name }}</b></div>
		                                <h5 class="card-title text-uppercase mb-0">{{ $details->name }}</h5>
		                                <h2 class="text-warning">{{ number_format($details->sisa,0,'.',',') }}</h2>
		                            </div>
		                        </div>
		                        <div id="reedem_{{ $details->id }}" style="display: none">
			                        <hr>
			                        <div class="row">
			                        	<div class="col-12" align="center">
			                        		<table width="100%">
			                        			<tr>
			                        				<td>
			                        					<h6>Nilai yang Akan di Reedem :</h6>
			                        					<input type="number" id="nilaireedem_{{ $details->id }}" value="{{ $details->sisa }}" class="form-control">
			                        				</td>
			                        			</tr>
			                        			<tr>
			                        				<td align="center">
			                        					<br>
			                        					<button type="button" onclick="Reedem({{ $details->id }})" class="btn btn-sm btn-success">Reedem</button>
			                        				</td>
			                        			</tr>
			                        		</table>
			                        	</div>
			                        </div>
			                    </div>
		                    </div>
		                </div>
		                @else

		                <h5 align="center">Saldo Anda untuk Deals ini Sudah Habis, Ayo Beli Lagi Deals ini!</h5>
		                @endif
	              	</div>
	              	@endforeach
	            </div>
          	</div>
        </div>
        
      	@include('content.deals.modal')
        @include('layout.footer')

        <script type="text/javascript">
        
	        function Buka(id){

	        	$('#reedem_'+id).attr('style', 'display: block;');
	        	$('#data_'+id).attr('onclick', 'Tutup('+id+')');

	        }

	        function Tutup(id){

	        	$('#reedem_'+id).attr('style', 'display: none;');
	        	$('#data_'+id).attr('onclick', 'Buka('+id+')');

	        }

	        function Reedem(id){

	        	var reedem = $('#nilaireedem_'+id).val();

	        	$('#ids').val(id);
	        	$('#qty').val(reedem);

	        	$.ajax({
		            type: 'POST',
		            url: "{{ route('lihatsaldo') }}",
		            data: {
		                '_token': $('input[name=_token]').val(),
		                'saldo_id': id,  
		            },
		            success: function(data) {

		            	if(parseInt(reedem) > parseInt(data.sisa)){

			        		swal({
					              title: "Warning",
					              text: "Pastikan Reedem Anda Tidak lebih besar dari Saldo!",
					              icon: "error",
					              buttons: false,
					              timer: 2000,
					         });

			        	} else {

			        		$('#yakin_reedem').modal('show');
			        	}

		            }

		        });
			    
			}

			$('#reedemsekarang').on('click', function () {

				$('.loading').attr('style','display: block');

				$.ajax({
		            type: 'POST',
		            url: "{{ route('keranjangreedemdeals') }}",
		            data: {
		                '_token': $('input[name=_token]').val(),
		                'saldo_id': $('#ids').val(), 
		                'qty': $('#qty').val(),  
		            },
		            success: function(data) {

		            	$('#yakin_reedem').modal('hide');

		            	swal({
				              title: "Berhasil",
				              text: "Produk dari Deals Anda Berhasil Masuk Ke Keranjang Reedem!",
				              icon: "success",
				              buttons: false,
				              timer: 2000,
				         });

		            	setTimeout(function(){ window.location.reload() }, 1500);
		            }

		        });

			});

      </script>
</body>

</html>