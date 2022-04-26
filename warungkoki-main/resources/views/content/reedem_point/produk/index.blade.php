@include('layout.head')
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
      bottom: 15px;
  }
  /* enlarge dots and change their colors */
  .slick-dots li button:before {
      font-size: 12px;
      color: #fff;
      text-shadow: 0 0 10px rgba(0,0,0,0.5);
      opacity: 1;
  }
  .slick-dots li.slick-active button:before {
      color: #dedede;
  }

  /* hide dots and arrow buttons when slider is not hovered */
  .slider:not(:hover) .slick-arrow,
  .slider:not(:hover) .slick-dots {
      opacity: 0;
  }
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

    margin-bottom: 75px;
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
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-2 pt-md-8" style="padding-bottom: 22rem;">
      <div class="container-fluid">
        <div class="header-body">
          <input type="hidden" id="ktps" value="{{ Auth::user()->token }}">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid" style="margin-top: -14rem;">
      <div class="row">
        <div class="col-12" style="padding-bottom: 20px;">
            <div style="font-size: 12px" class="text-black">Hello, <b style="font-size:18px;">{{ Auth::user()->name }}</b></div>
        </div>
        <!-- <div class="col-6" style="padding-bottom: 20px;padding-left: 0px;">
            <div style="font-size: 12px" align="right" class="text-black">Butiran Padi Anda,</div>
            <div style="font-size: 28px" align="right" class="text-warning"><b>{{ $saldopoin ? $saldopoin->sisa : 0 }}</b><b style="font-size:12px;"> Poin</b></div>
        </div> -->
      </div>
      <!-- <div class="row">
        <div class="col">
          <div class="card-body shadow-ss bg-secondary" style="border-radius: 2rem;">
            <table width="100%">
              <tr>
                <td>
                  <div style="font-size: 11px;">
                      <i class="fa fa-money"></i>
                      Saldo Anda sebesar : <b>{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
                  </div>
                </td>
                <td>
                  <a href="/xhome/isisaldo" class="menusxx"><button class="btn btn-success btn-sm">Isi Saldo</button></a>
                </td>
              </tr>
            </table>        
            
          </div>
        </div>
      </div> -->

      <!-- ====== TOKO PILIHAN ===== -->

      <div class="row">
        <div class="col">
          <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
            @if(!$toko)

              <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">
                <table width="100%">
                  <tr>
                    <td width="40%">
                      <img class="card-img-top" alt="Image placeholder" width="100%" src="/assets/content/img/theme/sad.png">
                    </td>
                    <td>
                      <div class="text-warning" style="font-size: 14px;"><b>BELUM PILIH TOKO</b></div>
                      <div style="font-size: 11px; padding-bottom: 8px;">Anda Belum Memilih Toko, Pilih toko untuk melanjutkan transaksi dan rasakan keuntungannya</div>
                      <a href="/search" class="menusxx"><button class="btn btn-sm btn-success">
                        <i class="fa fa-search"></i> Pilih Toko
                      </button></a>
                    </td>
                  </tr>
                </table>
              </div> 

            @else
            <div class="card-body shadow-ss" style="padding: 0px;">
              <div class="row">
              <!-- @if(strtotime(date('H:i')) >= strtotime($toko->jam_masuk) && strtotime(date('H:i')) <= strtotime($toko->jam_tutup))
                <div class="type">
                  <span class="badge badge-pill badge-success">TOKO BUKA!</span>
                </div>
              @else
                <div class="type">
                  <span class="badge badge-pill badge-danger">TOKO TUTUP!</span>
                </div>
              @endif  --> 
                <div class="col-12" style="padding-bottom: 0px;">
                  
                  <img class="card-img-top" width="100%" alt="Image placeholder" src="/assets/img_wilayah/{{ $toko->img }}">
                  
                  @if(!$sudahtour)
                  <div class="bottom-left pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Informasi Toko/Site yang Anda Pilih">
                  @else
                  <div class="bottom-left">
                  @endif

                    <div style="font-size: 11px;color: white;">
                      Toko Pilihan Anda -:
                    </div>
                    {{ $toko->name }}
                  </div>
                </div>
                <br>
              </div>
            </div>
            <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;background-color: #EAFCB8;">
              <div class="row">
                  <div class="col-3">
                      <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/assets/icon/144x144.png">
                  </a>
                  </div>
                  <div class="col-9" style="padding-left: 0px;padding-right: 15px;">
                    <i class="fa fa-check" style="color: #11cdef;"></i> <b style="font-size: 10px;">Grosir</b> &nbsp;<i class="fa fa-check" style="color: #11cdef;"></i> <b style="font-size: 10px;">Eceran</b>
                    <div style="font-size: 11px;">
                      {{ $toko->alamat }} - {{ $toko->regency_name }}
                    </div>
                    @if($alamat)
                    <div style="font-size:10px; padding-top: 6px;" class="text-warning">
                      <i>Perkiraan : <br>Jarak Toko {{ $distance }}, Durasi Pengiriman {{ $time }}</i>
                    </div>
                    @endif
                    <div style="font-size:10px; padding-top: 2px;" class="text-warning">
                      <i>Toko Buka : {{ $toko->jam_masuk }} - {{ $toko->jam_tutup }}</i>
                    </div>
                  </div>
                
                  <div class="col-12">
                      <a href="/search" class="menusxx"><button class="btn btn-sm btn-success btn-block" style="padding-right: 1rem;padding-left: 0.8rem;">
                        Ganti Toko Pilihan
                      </button></a>
                  </a>
                  </div>
              </div> 
            </div>

            @endif
          </div>
          @if($toko)
            @if(strtotime(date('H:i')) >= strtotime($toko->jam_masuk) && strtotime(date('H:i')) <= strtotime($toko->jam_tutup))
            @else
            <div class="card shadow-ss" style="background-color: #fb6340;">
              <div class="card-body">
                <table>
                  <tr>
                    <td>
                      <i class="fa fa-exclamation-triangle" style="font-size: 24px;color: white;"></i>
                    </td>
                    <td width="3%">&nbsp;</td>
                    <td>
                        <div style="font-size: 13px;" class="text-white">
                          <b>PERHATIAN!!</b>
                        </div>
                        <div style="font-size: 10px;" class="text-white">
                          Saat ini Toko sedang <b>TUTUP!</b>, Anda tetap bisa membeli barang di aplikasi ini, namun akan di proses saat toko buka kembali. Terimakasih
                        </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            @endif
          @endif
        </div>    
      </div>

     <!--  ======= PENCARIAN =========== -->

    <div class="row">
      <div class="col-10" style="padding-bottom:0px;">
        <input type="text" id="cari" placeholder="Cari Produk di Toko ini" class="form-control">
      </div>
      <div class="col-2" style="padding-left: 0px;padding-bottom:0px;">
        <button onclick="Cari();" id="myBtn" class="btn btn-info btn-block" style="padding-right: 1rem;padding-left: 0.8rem;">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div>

          <!-- ======== KATEGORI ======= -->

          <!-- <div class="row isikategori" id="kategorinya">
            @if(!$sudahtour)
            <div id="category" class="col-12 pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Anda bisa pilih kategori produk disini">
            @else
            <div id="category" class="col-12">
            @endif

              <table width="100%">
                <tr>
                  <td align="left" style="font-size: 15px;"><b>KATEGORI PRODUK</b></td>
                </tr>
              </table>
            </div>
            @foreach($kategori as $kat)

            @php
              if($kat->id == '1' || $kat->id == '4' || $kat->id == '7'){
                $style = 'padding-right:3px';
              } else if($kat->id == '2' || $kat->id == '5' || $kat->id == '8'){
                $style = 'padding-left: 7.5px;padding-right: 7.5px;';
              } else {
                $style = 'padding-left:3px';
              }

              $ada = DB::table('posts')
              ->select('posts.kategori_id','posts.product_id')
              ->leftJoin("users", "posts.user_id", "=", "users.id")
              ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
              ->where([
                  ["wilayah.id", $wilayahid],
                  ["posts.active", "Y"],
                  ['wilayah.active', '=', "Y"],
                  ['kategori_id', '=', $kat->id],
                  ['type', '=', 'Products'],
                  ['posts.deleted_at', '=', null],
              ])
              ->get();

              if($ada->count() == '0'){
                $disabled = 'bg-hitam';
                $kate = '';
                $click = 'DisabledKategory';
              } else {
                $disabled = '';
                $kate = 'kategori';
                $click = 'Kategory';
              }

            @endphp
            <div class="col-4" onclick="{{ $click }}({{ $kat->id }})" style="{{ $style }}">
              <div id="color_{{ $kat->id }}" class="card {{ $disabled }} shadow-sm {{ $kate }}">
                <div class="card-body" style="padding: 15px 5px 5px 5px;">
                  <table width="100%" border="0">
                    <tr>
                      <td align="center">
                        <img width="50%" src="/assets/content/img/icons/{{ $kat->icon }}">
                      </td>
                    </tr>
                    <tr>
                      <td height="7px"></td>
                    </tr>
                    <tr>
                      <td align="center"><h6><b> {{ $kat->name }} ({{ $ada->count() }})</b></h6></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            @endforeach

          </div> -->
    <hr>
    <div class="row">
      <div class="col-4">
        <div onclick="PembayaranInfo();" class="card shadow-ss" style="border-radius: 0.8rem;">
          <div class="card-body" style="padding:12px;" align="center">
            <img src="/assets/content/img/icons/secure.png">
            
            <div style="font-size:11px;padding-top: 10px;"><b>Bayar <br>Aman</b></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div onclick="Garansi()" class="card shadow-ss" style="border-radius: 0.8rem;">
          <div class="card-body" style="padding:12px;" align="center">
            <img src="/assets/content/img/icons/warranty.png">
            <br>
            <div style="font-size:11px;padding-top: 10px;"><b>Garansi <br>1x24 Jam</b></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div onclick="PelayananInfo();" class="card shadow-ss" style="border-radius: 0.8rem;">
          <div class="card-body" style="padding:12px;" align="center">
            <img src="/assets/content/img/icons/cs.png">
            <br>
            <div style="font-size:11px;padding-top: 10px;"><b>CS <br>24 Jam</b></div>
          </div>
        </div>
      </div>
    </div>

          <!-- ====== PRODUK ====== -->
          <div class="row pop" id="contentproduk">

            <!-- ===== KATEGORI BBM ====== -->

            @foreach($kategori as $kat)

              @php
              $products = DB::table('posts')
              ->select("posts.product_id")
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
              ->orderBy('posts.id', 'desc')   
              ->groupBy("posts.product_id")
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
                    <!-- <a href="/company/profile?id={{ $post->uuid }}">
                      <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $post->wilayah_name }}</span>
                    </a><br> -->
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
                    <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act - ceil($post->harga_act * (float)$diskon / 100)) }}</b></h3>
                    <!-- <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act) }}</b></h3> -->
                  </div>
                </div>
                </a>
              </div> 
              @endforeach 

            @endforeach

          </div>
<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('content.home.users.modal2')
@include('layout.footer')
<!-- Slick JS -->    
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<nav class="nav2" id="first" onclick="Menuss()">
  <div class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/smile.png">
  </div>
</nav>

<nav class="nav2 xx" onclick="Menuss2()" style="display:none;">
  <div href="#" align-items="center" class="nav__link menusxx">
    <img width="70%" src="/assets/content/img/icons/x.png">
  </div>
</nav>

<nav class="nav3 xx" style="display:none;">
  <a href="#" onclick="onShare()" class="nav__link">
    <img width="90%" src="/assets/content/img/icons/share.png">
  </a>
</nav>

<nav class="nav31 xx" style="display:none;">
  <a href="#" onclick="onShare()" class="nav__link" style="padding-left:20px;">
    <div align="left">Bagikan Link Warungkoki</div>
  </a>
</nav>

<nav class="nav4 xx" style="display:none;">
  <a href="https://wa.me/6281808800550" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/wa.png">
  </a>
</nav>

<nav class="nav41 xx" style="display:none;">
  <a href="https://wa.me/6281808800550" class="nav__link menusxx" style="padding-left:20px;">
    Customer Service Warungkoki
  </a>
</nav>

<nav class="nav5 xx" style="display:none;">
  <a href="https://www.instagram.com/warungkoki.id" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/ig.png">
  </a>
</nav>

<nav class="nav51 xx" style="display:none;">
  <a href="https://www.instagram.com/warungkoki.id" class="nav__link menusxx" style="padding-left:20px;">
    Instagram Warungkoki
  </a>
</nav>

<nav class="nav6 xx" style="display:none;">
  <a href="https://www.facebook.com/warungkoki.id" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/fb.png">
  </a>
</nav>

<nav class="nav61 xx" style="display:none;">
  <a href="https://www.facebook.com/warungkoki.id" class="nav__link menusxx" style="padding-left:20px;">
    Facebook Warungkoki
  </a>
</nav>
@include('script.home')

<script type="text/javascript">

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
          dots: true
      });
  });
 
  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('user.guides') }}",
      success: function (data) {

        if(data != '1'){

           $('#guide').modal({backdrop: 'static', keyboard: false}); 

        } else {

          var ktp = $('#ktps').val();

          if(ktp == ''){

            $('#ktp').modal({backdrop: 'static', keyboard: false}); 
          }

        }
      }
    });

    // $.ajax({
    //   type: 'GET',
    //   url: "{{ route('alamat.cek') }}",
    //   success: function (data) {

    //     if(data.length == 0){

    //       swal({
    //           title: "Perhatian!",
    //           text: "Harap Tentukan Alamat Anda terlebih Dahulu!",
    //           icon: "warning",
    //           buttons: false,
    //           timer: 2000,
    //       });

    //        setTimeout(function(){ window.location.href='/alamatuser'; }, 2000);

    //     } 
    //   }
    // });

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

  function SimpanPengaturan(){

    var pin = $('#pin').val();
    var pin2 = $('#pin2').val();
    var ktp = $('#ktpx').val();
    var nohp = $('#nohp').val();

    if(pin == pin2){

      if(pin.length == 6){
          $.ajax({
            type: 'POST',
            url: "{{ route('selesai.pengaturan') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'ktp': ktp,
                'pin': $('#pin').val(),
                'nohp': $('#nohp').val(),
            },
            success: function(data) {

              swal("Terimakasih, Selamat Datang di Warungkoki.id", {
                 icon: "success",
                 buttons: false,
                 timer: 2000,
              });

              $('#ktp').modal('hide');

            }
          });

      } else {

        swal("PIN Harus 6 Digit!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

      }

    } else {

      swal("PIN dan PIN Konfirmasi diharuskan SAMA!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

    }

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

  function IsiSaldo(){

    $('#isi').modal('show');

  }

  function PembayaranInfo(){

    $('#pembayaran').modal('show');

  }

  function PelayananInfo(){

    $('#pelayanan').modal('show');

  }

  function Garansi(){

    $('#garansi').modal('show');

  }

</script>
</body>

</html>
