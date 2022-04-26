@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-4 pt-md-8">
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
              	<h2 class="text-white">Saldo Deals Anda</h2>
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
                          <img src="/assets/content/img/theme/dealempty.jpg" width="90%">
                          <br><br>
                          <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                          <h6>Anda tidak punya Saldo Deals Apapun saat ini, Kuylah Belanja!</h6>
                        </td>
                      </tr>
                  </table>
                </div>
                @else

  	            	@foreach ($postdeals as $postdeal)
  	              	<div class="col-12" >
                          @if($postdeals->count() >= 1)
  		                <div class="card card-stats mb-2 mb-lg-0" onclick="Detail({{ $postdeal->id }})">
  		                    <div class="card-body shadow">
  		                        <div class="row">
  		                          	<div class="col-3">
  		                              	<a href="#" class="avatar rounded-circle mr-3">
  				                          <img alt="Image placeholder" src="/assets/img_post/{{ $postdeal->imgname }}">
  				                        </a>
  		                            </div>
  		                            <div class="col-9" align="right">
  		                            	<div class="text-warning" style="font-size: 10px;"><b>Lokasi : {{ $postdeal->wilayah_name }}</b></div>
  		                                <div style="font-size: 12px; color: black;" class=" text-uppercase"><b>{{ $postdeal->name }}</b></div>
  		                                <div style="font-size: 8px">Deals ini akan kadaluarsa pada :</div>
  		                                <div style="font-size: 15px;" class="text-warning">{{  date('d M Y', strtotime($postdeal->sampai)) }}</div>
  		                            </div>
  		                        </div>  
  		                    </div>
  		                </div>
  		                @else

  		                <h5 align="center">Anda Belum Memiliki Saldo Deals untuk saat ini!</h5>
  		                @endif
  	              	</div>
  	              @endforeach
                @endif
	            </div>
          	</div>
        </div>
        
      	<!-- @include('content.myproducts.modal') -->
        @include('layout.footer')
        <script type="text/javascript">
        	
        	function Detail(id){

        		$('.loading').attr('style','display: block');

        		window.location.href = '/users/deals/'+id;

        	}

        </script>
</body>

</html>