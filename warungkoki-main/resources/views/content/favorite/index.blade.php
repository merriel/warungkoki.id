@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
          <!-- Card stats -->
          <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Favorite Anda</h1>
          </div>
          @php
            if($ada >= 1){
          @endphp
          <div class="row">
            @foreach($favs as $fav)
              
              <div class="col-6">
                <a href="/users/detail/{{ $fav->id }}" class="post">
                <div class="card shadow-ss">
                  
                  <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $fav->prod_img }}" alt="Card image cap">
                  @php
                  $ada = DB::table('favorite')
                  ->where([
                      ['post_id', '=', $fav->id],
                      ['user_id', '=', $iduser],
                  ])
                  ->first();

                  @endphp
      
                  <div class="love2">
                    @if(!$ada)
                    <div class="circle4"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                    @else
                    <div class="circle4"><i class="ni ni-favourite-28" style="color: #f5365c"></i></div>
                    @endif
                  </div>
                  <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <h5> <b>{{ $fav->prod_name }}</b></h5>
                    
                    <div style="font-size: 9px;padding-top: 7px; color: black;">
                      Barang ini tersedia dan bisa Anda dapatkan di <b>{{ $fav->wilayah_name }}</b>
                    </div><hr>
                    @if($fav->harga_crt != 0 || $fav->harga_crt != null)
                    <h6 style="text-decoration:line-through;">{{ rupiah($fav->harga_crt) }}</h6>
                    @endif
                    <h3 style="color: #fb6340;"><b>{{ rupiah($fav->harga_act - ceil($fav->harga_act * (float)$diskon / 100)) }}</b></h3>
                  </div>
                </div>
                </a>
              </div> 
            @endforeach
          </div>
          @php
          } else {
          @endphp
          <div class="row">
            <div class="col-12">
              <div class="card shadow-ss">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                        <table width="100%">
                          <tr>
                            <td align="center">
                              <img src="/assets/content/img/theme/produkempty.jpg" width="90%">
                              <br>
                              <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                              <h6>Anda Belum Memiliki Barang Favorite!</h6>
                            </td>
                          </tr>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
          @php
          }
          @endphp

      @include('layout.footer')
</body>
</html>