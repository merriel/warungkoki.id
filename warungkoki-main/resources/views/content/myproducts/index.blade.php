@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-babantos pt-4 pt-md-8" style="padding-bottom: 13rem;">
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
              	<h2 class="text-white">Saldo Produk Anda</h2>
          	</div>
          	<br>
          	<div class="card">
	            <div class="card-body">
	            	<br>
	            	@if($saldosum == 0)
	            	<div class="col-12" >
	                	<table width="100%">
			                <tr>
			                  <td align="center">
			                    <img src="/assets/content/img/theme/produkempty.jpg" width="90%">
			                    <br>
			                    <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
			                    <h6>Anda tidak punya Saldo Produk Apapun saat ini, Kuylah Belanja!</h6>
			                  </td>
			                </tr>
			            </table>
	            	</div>
	            	@else
	            		@if($postdeals->count() == '0')
	            			<div class="col-12" >
			                	<table width="100%">
					                <tr>
					                  <td align="center">
					                    <img src="/assets/content/img/theme/produkempty.jpg" width="90%">
					                    <br>
					                    <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
					                    <h6>Anda tidak punya Saldo Produk Apapun saat ini, Kuylah Belanja!</h6>
					                  </td>
					                </tr>
					            </table>
			            	</div>
	            		@else

	            			@php $hasilnya = 0; @endphp

		            		@foreach ($postdeals as $postdeal)

				            	@php
					                $saldos = DB::table('saldo')
					                ->where([
					                    ['user_id', '=', $userID],
					                    ['post_id', '=', $postdeal->id],
					                    ['status', '=', null]
					                ])
					                ->orderBy('id', 'desc')
					                ->first();

					                $cekreedem = DB::table('reedem')
					                ->where('saldo_id', $saldos ? $saldos->id : '0')
					                ->first();

					                if($cekreedem){
					                	$hasil = $saldos->sisa - $cekreedem->qty;
					            	} else {
					            		$hasil = $saldos ? $saldos->sisa : '0';
					            	}

					            	$hasilnya += $hasil;

					             @endphp

					            @if($hasil != '0')
				              	<div class="col-12" >  
					                <div class="card card-stats mb-2 mb-lg-0">
					                    <div class="card-body shadow-ss">
					                        <div class="row" id="data_{{ $postdeal->id }}" onclick="Buka({{ $postdeal->id }})">
					                          	<div class="col-3">
					                              	<a href="#" class="avatar rounded-circle mr-3">
							                          <img alt="Image placeholder" src="/assets/img_post/{{ $postdeal->imgname }}">
							                        </a>
					                            </div>
					                            <div class="col-9" align="right" style="padding-bottom: 0px;">
					                            	<div class="text-warning" style="font-size: 10px;"><b>Lokasi : {{ $postdeal->wilayah_name }}</b></div>
					                                <h5 class="card-title text-uppercase mb-0">{{ $postdeal->prod_name }} {{ $postdeal->name }}</h5>
					                                <div style="font-size: 10px;">@ {{ rupiah($postdeal->harga_act) }}</div>
					                                
					                                <h2 class="text-warning">{{ $hasil >= 1000 ? rupiah($hasil) : $hasil }}</h2>
					                            </div>
					                            <div class="col-12" align="center" style="padding-bottom: 0px;">
					                            	<div style="padding-bottom: 8px;" align="right">
					                            		@if($postdeal->deliver == 'yes')
						                            	<span class="badge badge-pill badge-info" style="font-size: 8px;"><i class="fa fa-truck"></i> Delivery</span>
						                            	@endif

						                            	@if($postdeal->po == 'yes')
									                    <span class="badge badge-pill badge-primary" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
									                    @endif
						                            </div>
					                            	<div class="text-warning" style="font-size: 10px;">
					                            		@php
					                            			$tanggals = date('Y-m-d', strtotime('+15 day', strtotime($saldos->created_at)));
					                            			$tgl = strtotime($tanggals);
					                            			$hariini = time();

					                            			$diff   = $tgl - $hariini;

					                            		@endphp

					                            		<i>Produk ini Akan Kadaluarsa {{ floor($diff / (60 * 60 * 24)) }} Hari lagi</i>
					                            	</div>
					                            </div>
					                        </div>
					                        <div id="reedem_{{ $postdeal->id }}" style="display: none">
						                        <hr>
						                        <div class="row">
						                        	<div class="col-12" align="center">
						                        		<table width="100%">
						                        			<tr>
						                        				<td>
						                        					<h6>Nilai yang Akan di Ambil :</h6>
						                        					<input type="number" id="nilaireedem_{{ $postdeal->id }}" onkeyup="angka(this);" value="{{ $hasil }}" class="form-control">
						                        				</td>
						                        			</tr>
						                        			<tr>
						                        				<td align="center">
						                        					<br>
						                        					<button type="button" onclick="Reedem({{ $postdeal->id }})" class="btn btn-success"><i class="fa fa-truck"></i>  Ambil</button>
						                        					@if($postdeal->deliver == 'yes')
						                        					<hr>
						                        					<button type="button" onclick="ReedemDelivery({{ $postdeal->id }})" class="btn btn-primary"><i class="fa fa-truck"></i>  Reedem Delivery</button>
						                        					@endif
						                        				</td>
						                        			</tr>
						                        		</table>
						                        		
						                        	</div>
						                        </div>
						                    </div>
					                    </div>
					                </div>
				              	</div>
				              	@endif
				            @endforeach

				            @if($hasilnya == 0)

				            	<div class="col-12" >
				                	<table width="100%">
						                <tr>
						                  <td align="center">
						                    <img src="/assets/content/img/theme/produkempty.jpg" width="90%">
						                    <br>
						                    <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
						                    <h6>Anda tidak punya Saldo Produk Apapun saat ini, Kuylah Belanja!</h6>
						                  </td>
						                </tr>
						            </table>
				            	</div>

				            @endif

			            @endif
	            	@endif
	            	
	            </div>
          	</div>
        </div>
        
      	@include('content.myproducts.modal')
        @include('layout.footer')

        <script type="text/javascript">

        	function angka(e) {
	          if (!/^[0-9]*\.?[0-9]*$/.test(e.value)) {
	            e.value = e.value.substring(0,e.value.length-1);
	          }
	        }
        
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

	        	var empty = false;
		        $('#nilaireedem_'+id).each(function() {
		            if ($(this).val() == '') {
		                empty = true;
		            }
		        });
		        if (empty) {

		        	swal({
			            title: "Perhatikan",
			            text: "Data Tidak Boleh Kosong!",
			            icon: "error",
			            buttons: false,
			            timer: 2000,
			         });


		        } else {

		        	$.ajax({
			            type: 'POST',
			            url: "{{ route('lihatsaldo') }}",
			            data: {
			                '_token': $('input[name=_token]').val(),
			                'post_id': id,  
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

				        		$('#tab').val('cod');

				        		$('#yakin_reedem').modal('show');
				        	}

			            }

			        });

		        }
			}

			function ReedemDelivery(id){

	        	var reedem = $('#nilaireedem_'+id).val();

	        	$('#ids').val(id);
	        	$('#qty').val(reedem);

	        	var empty = false;
		        $('#nilaireedem_'+id).each(function() {
		            if ($(this).val() == '') {
		                empty = true;
		            }
		        });
		        if (empty) {

		        	swal({
			            title: "Perhatikan",
			            text: "Data Tidak Boleh Kosong!",
			            icon: "error",
			            buttons: false,
			            timer: 2000,
			         });


		        } else {

		        	$.ajax({
			            type: 'POST',
			            url: "{{ route('lihatsaldo') }}",
			            data: {
			                '_token': $('input[name=_token]').val(),
			                'post_id': id,  
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

				        		$('#tab').val('delivery');

				        		$('#yakin_reedem').modal('show');
				        	}

			            }

			        });

		        }
			}

			$('#reedemsekarang').on('click', function () {

				$('.loading').attr('style','display: block');

				$.ajax({
		            type: 'POST',
		            url: "{{ route('keranjangreedem') }}",
		            data: {
		                '_token': $('input[name=_token]').val(),
		                'post_id': $('#ids').val(), 
		                'qty': $('#qty').val(),  
		                'tab': $('#tab').val(),
		            },
		            success: function(data) {

		            	$('#yakin_reedem').modal('hide');

		            	swal({
				              title: "Berhasil",
				              text: "Produk Anda Berhasil Masuk Ke Keranjang Reedem!",
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