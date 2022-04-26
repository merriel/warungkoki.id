@include('layout.headbelumlogin')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style type="text/css">
  .slider .slick-slide {
      
  }

  .slider .slick-slide img {
      width: 100%;
      border-radius: 1rem;
  }

  /* make button larger and change their positions */
  .slick-prev, .slick-next {
      width: 50px;
      height: 50px;
      z-index: 1;
  }
  .slick-prev {
      left: 5px;
  }
  .slick-next {
      right: 5px;
  }
  .slick-prev:before, 
  .slick-next:before {
      font-size: 40px;
      text-shadow: 0 0 10px rgba(0,0,0,0.5);
  }
  
  /* move dotted nav position */
  .slick-dots {
      bottom: -30px;
  }
  /* enlarge dots and change their colors */
  .slick-dots li button:before {
      font-size: 9px;
      color: #fff;
      opacity: 1;
  }
  .slick-dots li.slick-active button:before {
      color: #000;
  }

  /* hide dots and arrow buttons when slider is not hovered */
  
  /* transition effects for opacity */
  .slick-arrow,
  .slick-dots {
      transition: opacity 0.5s ease-out;
  }

  .bottom-left {

    position: absolute;
    bottom: 5px;
    left: 30px;
    font-size: 16px;
    font-weight: bold;
    text-align: left;
    color: white;
  }

  .nav2 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 83px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;
  }

  .nav3 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 125px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav31 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 125px;
    border-radius: 1rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav4 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 175px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav41 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 175px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav5 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 225px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav51 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 225px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav6 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 275px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav61 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 275px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav__link{

    padding-left: 10px;
    padding-right: 10px;
    min-width: 0px;
    color: black;

  }

  .box {
    width: 200px;
    height: 300px;
    position: relative;
    border: 1px solid #bbb;
    background: #eee;
    float: left;
    margin: 20px;
  }
  .ribbon {
    position: absolute;
    right: -5px;
    top: -5px;
    overflow: hidden;
    width: 93px;
    height: 93px;
    text-align: right;
  }
  .ribbon span {
    font-size: 0.7rem;
    color: #fff;
    text-transform: uppercase;
    text-align: center;
    font-weight: bold;
    line-height: 32px;
    transform: rotate(45deg);
    width: 125px;
    display: block;
    background: #79a70a;
    background: linear-gradient(#9bc90d 0%, #79a70a 100%);
    box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
    position: absolute;
    top: 17px; // change this, if no border
    right: -29px; // change this, if no border
  }

  .ribbon span::before {
     content: '';
     position: absolute; 
     left: 0px; top: 100%;
     z-index: -1;
     border-left: 3px solid #79A70A;
     border-right: 3px solid transparent;
     border-bottom: 3px solid transparent;
     border-top: 3px solid #79A70A;
  }
  .ribbon span::after {
     content: '';
     position: absolute; 
     right: 0%; top: 100%;
     z-index: -1;
     border-right: 3px solid #79A70A;
     border-left: 3px solid transparent;
     border-bottom: 3px solid transparent;
     border-top: 3px solid #79A70A;
  }

  .red span {
    background: linear-gradient(#f70505 0%, #8f0808 100%);
  }
  .red span::before {
    border-left-color: #8f0808;
    border-top-color: #8f0808;
  }
  .red span::after {
    border-right-color: #8f0808;
    border-top-color: #8f0808;
  }

  .blue span {
    background: linear-gradient(#2989d8 0%, #1e5799 100%);
  }
  .blue span::before {
    border-left-color: #1e5799;
    border-top-color: #1e5799;
  }
  .blue span::after {
    border-right-color: #1e5799;
    border-top-color: #1e5799;
  }

  .foo {
    clear: both;
  }

  .bar {
    content: "";
    left: 0px;
    top: 100%;
    z-index: -1;
    border-left: 3px solid #79a70a;
    border-right: 3px solid transparent;
    border-bottom: 3px solid transparent;
    border-top: 3px solid #79a70a;
  }

  .baz {
    font-size: 1rem;
    color: #fff;
    text-transform: uppercase;
    text-align: center;
    font-weight: bold;
    line-height: 2em;
    transform: rotate(45deg);
    width: 100px;
    display: block;
    background: #79a70a;
    background: linear-gradient(#9bc90d 0%, #79a70a 100%);
    box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
    position: absolute;
    top: 100px;
    left: 1000px;
  }

  .text-dots {
    overflow: hidden;
        text-overflow: ellipsis;
    white-space: nowrap;
    }

</style>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-md-8" style="padding-bottom: 14rem;padding-top: 0px;">
      <div class="container-fluid" style="padding:0px;">
        <div class="header-body">
        </div>
      </div>
    </div>

    <br>
    <div class="container-fluid" style="margin-top: -10rem;">
      <div class="row">  

        <div class="col-12" style="padding-bottom: 15px;">
            <div style="font-size: 12px" class="text-black">Hello, <b style="font-size:18px;">Pelanggan</b></div>
        </div>
        <div class="col-12">
          <div class="card" style="border-radius:2rem; background-color: #f3fcd3;">
            <div class="card-body" style="font-size:11px;padding: 0.3rem 1.2rem;">
              <div class="row">
                <div class="col-10 text-dots" style="padding-right:0px;padding-bottom: 0px;padding-top: 5px;">
                  <i class="fa fa-map-marker"></i> &nbsp; Toko Pilihanmu : <b>{{ $toko ? $toko->name : 'Belum Pilih Toko' }}</b>
                </div>
                <div class="col-2" style="padding-bottom:0px;word-wrap: break-word;">
                    <a href="/search" class="menusxx"><button class="btn btn-sm btn-success" style="border-radius: 2rem;padding: 0.2rem 0.4rem;">
                      <i class="fa fa-chevron-down"></i>
                    </button></a>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card-body bg-success shadow-ss" style="border-radius: 1rem;padding: 0.3rem 1rem;">    
            <table width="100%">
              <tr>
                <td align="left" width="55%">
                  <a href="/xhome/isisaldo" class="menusxx">
                    <!-- <div style="color: white;" onclick="Maintenance()"> -->
                      <table width="100%" style="color: white;">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/money.png">
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <div style="font-size:10px;">Saldo Warungkoki :</div>
                            <b style="font-size: 13px;">Rp. 0</b>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </a>
                </td>
                <td>&nbsp;</td>
                <td align="left">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/padi.png">
                          </td>
                          
                          <td>
                            <a href='#' style="color: white;">
                            <div style="font-size:10px;">Butiran Padi :</div>
                            <b style="font-size: 13px;">0</b>
                            </a>
                          </td>
                        </tr>
                      </table>
                      
                    </div>
                </td>
              </tr>
            </table> 
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12" style="padding-bottom:0px;">
          <div class="slider">
            @foreach($banners as $ban)
            <div style="padding-left:5px;padding-right: 5px;">
                <a href="/banners/detail?id={{ $ban->id }}">
                    <img src="/assets/img_banners/{{ $ban->photo }}" alt="{{ $ban->judul }}">
                </a>            
            </div>
            @endforeach
          </div>
        </div>
      </div>
      
     
    <hr>

<!-- ====== PRODUK ====== -->
<div class="row pop" id="contentproduk">

<!-- ===== KATEGORI BBM ====== -->

@foreach($kategori as $kat)

  @php
  $products = DB::table('posts')
  ->select("posts.product_id","posts.jenis")
  ->leftJoin("users", "posts.user_id", "=", "users.id")
  ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
  ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
  ->leftJoin("product", "posts.product_id", "=", "product.id")
  ->where([
      ["wilayah.id", $wilayahid],
      ["posts.active", "Y"],
      ['wilayah.active', '=', "Y"],
      ['posts.kategori_id', '=', $kat->id],
      ['posts.type', '=', 'Products'],
      ['posts.deleted_at', '=', null],
  ])
  ->orderBy('posts.jenis', 'desc')   
  ->groupBy("posts.product_id","posts.jenis")
  ->get();

  @endphp

  @if($toko)
    @if($products->count() != 0)
    <div id="category" class="col-12" style="padding-top: 10px;">
      <table width="100%">
        <tr>
          <td align="left" style="font-size: 15px;"><b>{{ strtoupper($kat->name) }}</b></td>
          <td align="right">
           <a class="menusxx" href="/kategori?id={{ $kat->id }}"><div class="text-warning"><b>Lihat Semua</b></div></a>
          </td>
        </tr>
      </table>
    </div>
    @endif
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
          ['posts.kategori_id', '=', $kat->id],
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
          ['posts.kategori_id', '=', $kat->id],
          ['posts.type', '=', 'Products'],
          ['posts.deleted_at', '=', null],
          ['posts.product_id', '=', $produk->product_id],
          ['posts.jenis', '=', 'promo']
      ])
      ->orderByRaw("CAST(posts.harga_act as UNSIGNED) ASC")
      ->first();

    }

  @endphp

  <div class="col-6" style="{{ $paddings }}">
    <a href="/home3/detail/{{ $post->id }}" class="post">
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

@endforeach

</div>
<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('content.home.users.modal2')
@include('layout.footerbelumlogin')
<!-- Slick JS -->    
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">

  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('promo.iklan') }}",
      data: {
          '_token': $('input[name=_token]').val(),
      },
      success: function (data) {

        if(data.status == 1){

          $('#gambar').attr('src','/assets/img_iklan/'+data.img);

           $('#iklan').modal('show'); 

        } 
      }
    });

  });

  async function onShare() {
    const title = document.title;
    const url = document.querySelector("link[rel=canonical]")
      ? document.querySelector("link[rel=canonical]").href
      : document.location.href;
    const text = "Promo Menarik Lainnya di Warungkoki.id yuk!";
    try {
        await navigator
        .share({
          title,
          url,
          text
        })
        
          /*
            Show a message if the user shares something
          */
          alert('Thanks for Sharing!');
      } catch (err) {
         /*
            This error will appear if the user cancels the action of sharing.
          */
         // alert('Couldnt share');
      }
  }

  function Menuss(){

    $('.xx').attr("style","display:flex;");
    $('#first').attr("style","display:none;");

  }

  function Menuss2(){

    $('.xx').attr("style","display:none;");
    $('#first').attr("style","display:flex;");
    
  }

  $(document).ready(function(){
      $('.slider').slick({
          autoplay: true,
          autoplaySpeed: 3000,
          dots: true,
          centerMode: true,
          centerPadding: '60px',
          slidesToShow: 2,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
              }
            },
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
      });
  });
 

  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
   
      return false;
      return true;
  }

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

  function Finish(){

    $.ajax({
      type: 'GET',
      url: "{{ route('selesai.guide') }}",
      success: function(data) {

        $('#guide').modal('hide');

        $('#ktp').modal({backdrop: 'static', keyboard: false}); 

      }
    });

  }

  function Maintenance(){

    $('#maintenances').modal('show');

  }


</script>
</body>

</html>
