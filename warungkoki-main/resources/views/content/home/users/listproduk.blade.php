@php $no=0; @endphp
@foreach($products as $produk)
@php
  $no++;

  if($no%2==0){
    $paddings = 'padding-left: 7.5px;';
  } else {
    $paddings = 'padding-right: 7.5px;';
  }

  if($pilihkat == 0){

    if($produk->jenis == null){

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
          ['posts.type', '=', 'Products'],
          ['posts.deleted_at', '=', null],
          ['posts.product_id', '=', $produk->product_id],
          ['posts.jenis', '=', NULL]
      ])
      ->orderByRaw("CAST(posts.harga_act as UNSIGNED) ASC")
      ->first();

    } else {

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
          ['posts.type', '=', 'Products'],
          ['posts.deleted_at', '=', null],
          ['posts.product_id', '=', $produk->product_id],
          ['posts.jenis', '=', 'promo']
      ])
      ->orderByRaw("CAST(posts.harga_act as UNSIGNED) ASC")
      ->first();

    }

  } else {

    if($produk->jenis == null){

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
          ['posts.kategori_id', '=', $pilihkat],
          ['posts.type', '=', 'Products'],
          ['posts.deleted_at', '=', null],
          ['posts.product_id', '=', $produk->product_id],
          ['posts.jenis', '=', NULL]
      ])
      ->orderByRaw("CAST(posts.harga_act as UNSIGNED) ASC")
      ->first();

    } else {

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
          ['posts.kategori_id', '=', $pilihkat],
          ['posts.type', '=', 'Products'],
          ['posts.deleted_at', '=', null],
          ['posts.product_id', '=', $produk->product_id],
          ['posts.jenis', '=', 'promo']
      ])
      ->orderByRaw("CAST(posts.harga_act as UNSIGNED) ASC")
      ->first();

    }

  }

@endphp

<div class="col-6" style="{{ $paddings }}">
  <a href="/users/detail/{{ $post->id }}" class="post">
  <div class="card shadow-sm" style="background-color: {{ $post->harga_crt == null ? '#fff;' : '#ff7383;' }}">
    @if($post->harga_crt != NULL)
    <div class="ribbon red"><span>HOT DEALS</span></div>
    @endif
    <div class="gambar">   
      <!-- === GAMBAR JIKA PROMO ==== -->
      @if($post->harga_crt == null)
      <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap">
      @else
      <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->img }}" alt="Card image cap">
      @endif
      

      @if($post->jenis == null)
        @php
        $ada = DB::table('favorite')
        ->where([
            ['post_id', '=', $post->id],
            ['user_id', '=', $iduser],
        ])
        ->first();

        @endphp

       <!--  @if(!$ada)
        <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
        @else
        <div class="circle4 shadow-ss"><i class="ni ni-favourite-28" style="color: #f5365c"></i></div>
        @endif -->
      @endif
    </div>
    <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
      <h5> <b style="color: black;">{{ $post->prod_name }}</b></h5>
      <div style="font-size: 9px;padding-top: 7px; color: black;">
        Barang ini tersedia dan bisa Anda dapatkan di <b>{{ $post->wilayah_name }}</b>
      </div>
      <hr>
      
      <div class="row">
        <div class="col-12" style="color: {{ $post->harga_crt == null ? '#fb6340;' : '#fff;' }}font-size: 16px;padding-bottom: 5px;">
          <b>{{ rupiah($post->harga_act) }}</b>
        </div>
        <div class="col-12" style="padding-bottom:0px;">
          @if($post->harga_crt != NULL)
            @if($post->harga_act > $post->harga_crt)
              <div style="color: black;font-size: 11px;">
                &nbsp;
              </div>
            @else
              <div style="text-decoration:line-through;color: black;font-size: 11px;">{{ rupiah($post->harga_crt) }} &nbsp;&nbsp;
                <span style="color:black;font-size: 100%;font-weight: 1000" class="badge badge-pill badge-secondary">{{ round((($post->harga_act - $post->harga_crt) / $post->harga_crt) * 100) }}%</span>
            </div>
            @endif
          @else
          &nbsp;
          @endif
        </div>
      </div>
    </div>
  </div>
  </a>
</div> 

@endforeach