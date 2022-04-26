@include('xhome.layout.head')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<style type="text/css">
  .bottom-left {

    position: absolute;
    bottom: 5px;
    left: 30px;
    font-size: 19px;
    font-weight: bold;
    text-align: left;
    color: white;
  }

  .swiper-container {
    width: 100%;
    height: 100%;
  }

  .swiper-slide {
    text-align: center;
    font-size: 18px;

    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
  }

  .photosx{
      width: 100%;
      padding-left: 10px;
      padding-right: 10px;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-gradient-deliver pt-2 pt-md-8" style="padding-bottom: 17rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
<div class="container-fluid" style="margin-top: -13rem;">

  <div class="col-12" style="padding-bottom: 20px;padding-left: 0px;">
      <div style="font-size: 12px" class="text-white">Selamat Datang di X-Delivery,</div>
      <div style="font-size: 21px" class="text-white"><b>{{ Auth::user()->name }}</b></div>
  </div>
  <div class="row">
    <div class="col">
      <div class="card-body shadow-ss bg-secondary" style="border-radius: 2rem;">
                  
        <div style="font-size: 11px;">
            <i class="fa fa-money"></i>
            Saldo TOMX Anda sebesar : <b>{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="swiper-container" id="ka-swiper1">
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <a class="menusxx" href="/promo/detail?id=1">
              <div class="container-home">
                
                <img class="photosx shadow" src="/assets/img_banners/banner1.jpg">
                
              </div>
            </a>
          </div>

          <div class="swiper-slide">
            <a class="menusxx" href="/promo/detail?id=2">
              <div class="container-home">
                
                <img class="photosx shadow" src="/assets/img_banners/banner2.jpg">
                
              </div>
            </a>
          </div>

          <div class="swiper-slide">
            <a class="menusxx" href="/promo/detail?id=3">
              <div class="container-home">
                
                <img class="photosx shadow" src="/assets/img_banners/banner5.jpg">
                
              </div>
            </a>
          </div>

          <div class="swiper-slide">
            <a class="menusxx" href="/promo/detail?id=4">
              <div class="container-home">
                
                <img class="photosx shadow" src="/assets/img_banners/banner6.jpg">
                
              </div>
            </a>
          </div>

        </div>
        <br><br>
        <div class="swiper-pagination"></div>
    </div>  
  </div>
  

 <!--  ======= PENCARIAN =========== -->
 <hr>
 <div class="row">
  <div class="col-10">
    <input type="text" id="cari" placeholder="Cari Produk disini" class="form-control">
  </div>
  <div class="col-2" style="padding-left: 0px;">
    <button onclick="Cari();" id="myBtn" class="btn btn-success btn-block" style="padding-right: 1rem;padding-left: 0.8rem;">
      <i class="fa fa-search"></i>
    </button>
  </div>
 </div>


 <!-- ========= TOP TOKO ======== -->
 <div class="row">
    <div class="col-12" style="padding-top: 10px;">
      <table width="100%">
        <tr>
          <td align="left" style="font-size: 15px;"><b>TOP TOKO</b></td>
        </tr>
      </table>
    </div>

    @php $no=0; @endphp
    @foreach($wilayahs as $wilayah)
    @php
      $no++;

      if($no%2==0){
        $paddings = 'padding-left: 7.5px;';
      } else {
        $paddings = 'padding-right: 7.5px;';
      }

    @endphp

    <div class="col-6" style="{{ $paddings }}">
      
      <div class="card shadow-sm">
        <a href="/xhome/wilayah?id={{ $wilayah->uuid }}" class="post">
          <div class="gambar">
            <img class="card-img-top" width="50px" src="/assets/img_company/shell.jpg" alt="Card image cap">
          </div>
        </a>
        <a href="/xhome/wilayah?id={{ $wilayah->uuid }}" class="post">
        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;">
          <div style="font-size: 11px;color: black;padding-bottom: 5px;"><b>{{ $wilayah->name }}</b></div>
          <div style="font-size: 10px;color: black;padding-bottom: 5px;">{{ $wilayah->alamat }}</div>
          @php

          $banyak = DB::table('posts')
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->where("users.wilayah_id", $wilayah->id)
          ->where([
              ["users.wilayah_id", '=', $wilayah->id],
              ['posts.active', '=', 'Y'],
              ['posts.type', '=', 'Delivery'],
          ])
          ->count();

          @endphp
          <div style="font-size: 10px;" class="text-warning">
            <b>Terdapat {{ $banyak }} Produk</b>
          </div>
          @php
            $ada = DB::table('follow')
            ->where([
              ['wilayah_id', '=', $wilayah->id],
              ['user_id', '=', $iduser],
            ])
            ->first();
          @endphp
        </div>
        </a>
        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;padding-top: 0px;">
          <hr>
          <table width="100%">
            <tr>
              <td align="center">
                @if(!$ada)
                  <button onclick="Follow({{ $wilayah->id }})" class="btn btn-success btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Follow Toko</button>
                @else
                  <button onclick="Unfollow({{ $wilayah->id }})" class="btn btn-danger btn-sm btn-block" type="button"><i class="fa fa-minus"></i> Unfollow</button>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div> 
    @endforeach 

  </div>
  
  <!-- ======= END TOP TOKO ===== -->


  <!-- ====== PRODUK ====== -->
  <div class="row pop" id="contentproduk">

    @foreach($kategori as $kat)

      @php
      $products = DB::table('posts')
      ->select("posts.product_id")
      ->leftJoin("users", "posts.user_id", "=", "users.id")
      ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
      ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
      ->leftJoin("product", "posts.product_id", "=", "product.id")
      ->where([
          ["posts.active", "Y"],
          ['wilayah.active', '=', "Y"],
          ['posts.kategori_id', '=', $kat->id],
          ['posts.type', '=', 'Delivery'],
          ['posts.deleted_at', '=', null],
      ])
      ->orderBy('posts.id', 'desc')
      ->limit(4)
      ->groupBy("posts.product_id")
      ->get();

      @endphp

      @if($products->count() != 0)
      <div id="category" class="col-12" style="padding-top: 10px;">
        <table width="100%">
          <tr>
            <td align="left" style="font-size: 15px;"><b>KATEGORI {{ strtoupper($kat->name) }}</b></td>
            <td align="right">
             <a class="menusxx" href="/kategori?id={{ $kat->id }}"><div class="text-warning"><b>Lihat Semua</b></div></a>
            </td>
          </tr>
        </table>
      </div>
      @endif
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
            ["posts.active", "Y"],
            ['wilayah.active', '=', "Y"],
            ['posts.kategori_id', '=', $kat->id],
            ['posts.type', '=', 'Delivery'],
            ['posts.deleted_at', '=', null],
            ['posts.product_id', '=', $produk->product_id],
        ])
        ->first();

      @endphp

      <div class="col-6" style="{{ $paddings }}">
        <a href="/xhome/detail/{{ $post->id }}" class="post">
        <div class="card shadow-sm">
          <div class="gambar">
            <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap">
            @php
            $ada = DB::table('favorite')
            ->where([
                ['post_id', '=', $post->id],
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
            <a href="/xhome/wilayah?id={{ $wilayah->uuid }}"><span class="badge badge-success" style="font-size: 7.5px;"><i class="fa fa-check"></i> {{ $post->wilayah_name }}</span></a>
            <div style="font-size: 9px;padding-top: 7px; color: black;">
              Barang ini Tersedia dan siap dikirim dari <b>{{ $post->regency_name }}</b>
            </div>
            <hr>
            <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act) }}</b></h3>
          </div>
        </div>
        </a>
      </div> 
      @endforeach 

    @endforeach

  </div>

<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('xhome.layout.footer')
@include('script.home')
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script type="text/javascript">
 
  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('user.guides') }}",
      success: function (data) {

        if(data != '1'){

           $('#guide').modal({backdrop: 'static', keyboard: false}); 

        } 
      }
    });

    $.ajax({
      type: 'GET',
      url: "{{ route('alamat.cek') }}",
      success: function (data) {

        if(data.length == 0){

          swal({
              title: "Perhatian!",
              text: "Harap Tentukan Alamat Anda terlebih Dahulu!",
              icon: "warning",
              buttons: false,
              timer: 2000,
          });

           setTimeout(function(){ window.location.href='/alamatuser'; }, 2000);

        } 
      }
    });

  });

  function Next(id){

  $('.content').attr("style","display: none;");
  $('.tombol').attr("style","display: none;");

  $('#tombol'+id).attr("style","display: block;");
  $('#content'+id).attr("style","display: block;");

  }

  function Back(id){

    $('.content').attr("style","display: none;");
    $('.tombol').attr("style","display: none;");

    $('#tombol'+id).attr("style","display: block;");
    $('#content'+id).attr("style","display: block;");

  }

  function Finish(id){

    $.ajax({
      type: 'GET',
      url: "{{ route('selesai.guide') }}",
      success: function(data) {

        $('#guide').modal('hide');

      }
    });

  }

  var input = document.getElementById("cari");

  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     event.preventDefault();
     document.getElementById("myBtn").click();
    }
  });

  function Cari(){

    var cari = $('#cari').val();

    if(cari == ''){

      swal("Isi Keyword yang diinginkan!", {
         icon: "error",
         buttons: false,
         timer: 2000,
      });

    } else {

      $('.loading').attr('style','display: block');

      setTimeout(function(){ window.location.href='/cari?value='+cari+''; }, 1000);

    }

    
  }

  var swiper = new Swiper('.swiper-container', {
    pagination: {
      el: '.swiper-pagination',    
      dynamicBullets: true,
    },
  });

  function Follow(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('followcompany') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Anda Berhasil Follow Toko!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });

  }

  function Unfollow(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('unfollowcompany') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
          
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Anda Berhasil Unfollow Toko!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

      }

    });

  }

</script>
</body>

</html>