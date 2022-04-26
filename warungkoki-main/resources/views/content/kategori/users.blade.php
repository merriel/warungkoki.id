@include('layout.head')
  <div class="main-content">  
  <style type="text/css">
    .bottom-left {

      position: absolute;
      top: 12px;
      left: 20px;
      font-size: 21px;
      font-weight: bold;
      text-align: left;
    }
  </style> 
    <div class="container-fluid pb-4 pt-9 pt-md-8">
      <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br> -->
      <div class="row">
        <div class="col">
            <div class="row">
              <div class="col-12">
                <div class="card shadow-ss" style="border-radius: 1rem;">
                  <div class="card-body" style="padding: 0px;" align="center">
                    <img style="border-radius: 1rem;" src="/assets/content/img/theme/kategori-min.jpg" width="100%">
                    <div class="bottom-left">
                      <div style="font-size: 11px;">
                        Kategori :
                      </div>
                      {{ $kategori->name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              @if($products->count() == '0')
                <div class="col-12">
                  <div class="card shadow-sm">
                    <div class="card-body" align="center">
                        <table width="100%">
                          <tr>
                            <td align="center">
                              <img src="/assets/content/img/theme/challangeempty.jpg" width="90%">
                              <br>
                              <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                              <h6>Tidak ada Produk apapun di Kategori ini!</h6>
                            </td>
                          </tr>
                        </table>
                    </div>
                  </div>
                </div>

              @else

                @php $no=0; @endphp
                @foreach($products as $produk)
                @php
                  $no++;

                  if($no%2==0){
                    $paddings = 'padding-left: 7.5px;';
                  } else {
                    $paddings = 'padding-right: 7.5px;';
                  }

                  $post = DB::table('posts')
                  ->select("posts.*","product.name as prod_name","wilayah.name as wilayah_name","regencies.name as regency_name","product.img as prod_img","wilayah.uuid")
                  ->leftJoin("users", "posts.user_id", "=", "users.id")
                  ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                  ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
                  ->leftJoin("product", "posts.product_id", "=", "product.id")
                  ->where([
                      ["wilayah.id", $wilayahid],
                      ["posts.active", "Y"],
                      ['wilayah.active', '=', "Y"],
                      ['posts.kategori_id', '=', $kategori->id],
                      ['posts.type', '=', 'Products'],
                      ['posts.deleted_at', '=', null],
                      ['posts.product_id', '=', $produk->product_id],
                  ])
                  ->first();
                @endphp

                <div class="col-6" style="{{ $paddings }}">
                  <a href="/users/detail/{{ $post->id }}" class="post">
                  <div class="card shadow-sm">
                    
                    <div class="gambar">
                      <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap">
                      @php
                      $ada = DB::table('favorite')
                      ->where([
                          ['post_id', '=', $produk->id],
                          ['user_id', '=', $iduser],
                      ])
                      ->first();

                      @endphp

                      @if(!$ada)
                      <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                      @else
                      <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #f5365c"></i></div>
                      @endif
                    </div>
                    <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                      <h5> <b>{{ $post->prod_name }}</b></h5>
                      <div style="font-size: 9px;padding-top: 7px; color: black;">
                        Barang ini tersedia dan bisa Anda dapatkan di <b>{{ $post->wilayah_name }}</b>
                      </div>
                      <div style="padding-top: 8px;">
                        @if($post->deliver == 'yes')
                        <span class="badge badge-pill badge-warning" style="font-size: 8px;"><i class="fa fa-truck"></i> Delivery</span>
                        @endif

                        @if($post->po == 'yes')
                        <span class="badge badge-pill badge-info" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
                        @endif
                      </div>
                      <hr>
                      @if($post->type == 'Deals')
                      <h6 style="text-decoration:line-through;">{{ rupiah($post->harga_crt) }}</h6>
                      @endif
                      <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act) }}</b></h3>
                    </div>
                  </div>
                  </a>
                </div> 
                @endforeach 
              @endif
            </div>
          </div> 
        </div> 
      </div>
    </div>
      
    @include('layout.footer')

</body>

</html>