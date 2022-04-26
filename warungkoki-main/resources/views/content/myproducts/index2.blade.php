@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">My Products</h1>
            </div>
            <div id="contentyourdeals" style="display: block;">
              @if($postdeals->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <h6>Anda Belum Memiliki Produk Apapun untuk saat ini!</h6>
                  </div>
                </div>
              @else

              @foreach ($postdeals as $postdeal)

              @php
                $saldos = DB::table('saldo')
                ->where([
                    ['user_id', '=', $userID],
                    ['post_id', '=', $postdeal->id]
                ])
                ->orderBy('id', 'desc')
                ->first();

              @endphp

              @if($saldos->sisa > 0)

              <a href="/users/deals/{{ $postdeal->id }}"><div class="card shadow">
                <div class="card-body">
                  <table width="100%" border="0">
                    <tr>
                      <td width="25%" rowspan="2">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="/assets/img_post/{{ $postdeal->imgname }}">
                        </a>
                      </td>
                      <td style="color: black;font-size: 14px;"><b>{{ $postdeal->name }}</b></td>
                    </tr>
                    
                    <tr>
                      <td><span class="badge badge-pill badge-primary" style="font-size: 9px;"><i class="fas fa-calendar"></i> Qty : {{ $saldos->sisa >= 1000 ? rupiah($saldos->sisa) : $saldos->sisa }}</span></td> 
                    </tr>  
                  </table>
                </div>
<!--                 <div id="ambil_{{ $postdeal->id }}" style="display: none;">
                  <hr>
                  <div class="row">
                    <div class="col-12" align="center">
                      <button type="button" class="btn btn-sm btn-success">Ambil Produk</button>
                    </div>
                  </div>
                </div> -->
              </div></a>
              <br>
              @endif
              @endforeach
              @endif
            </div>
        </div> 
      </div> 
    </div>
  </div>
      
      @include('layout.footer')

      <script type="text/javascript">

        // function Buka(id){

        //     $('#ambil_'+id).attr('style', 'display: block;');
        //     $('#data_'+id).attr('onclick', 'Tutup('+id+')');

        //   }

        //   function Tutup(id){

        //     $('#ambil_'+id).attr('style', 'display: none;');
        //     $('#data_'+id).attr('onclick', 'Buka('+id+')');

        //   }

        $('.kadaluarsa').on('click', function () {

          swal({
              title: "Warning",
              text: "Deals Anda sudah Kadaluarsa!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

        });

        $('.lihat').on('click', function () {

            $('.loading').attr('style','display: block');

        });

      </script>

</body>

</html>