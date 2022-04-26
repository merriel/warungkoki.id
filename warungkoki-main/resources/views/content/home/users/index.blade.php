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
          <input type="hidden" id="ktps" value="{{ Auth::user()->token }}">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
        </div>
      </div>
    </div>

    <br>
    <div class="container-fluid" style="margin-top: -10rem;">
      <div class="row">  

        <div class="col-12" style="padding-bottom: 15px;">
            <div style="font-size: 12px" class="text-black">Hello, <b style="font-size:18px;">{{ Auth::user()->name }}</b></div>
        </div>
        <div class="col-12">
          <div class="card" style="border-radius:2rem; background-color: #f3fcd3;">
            <div class="card-body" style="font-size:11px;padding: 0.{{ $toko ? '3' : '6' }}rem 1.2rem;">
              <div class="row">
                <div class="col-{{ $toko ? '10' : '8' }} text-dots" style="padding-right:0px;padding-bottom: 0px;padding-top: 5px;">
                  <i class="fa fa-map-marker"></i> &nbsp; Toko Pilihanmu : <b>{{ $toko ? $toko->name : 'Belum Pilih Toko' }}</b>
                </div>
                <div class="col-{{ $toko ? '2' : '4' }}" style="padding-bottom:0px;word-wrap: break-word;">
                  @if($toko)
                    <a href="/search" class="menusxx"><button class="btn btn-sm btn-success" style="border-radius: 2rem;padding: 0.2rem 0.4rem;">
                      <i class="fa fa-chevron-down"></i>
                    </button></a>
                  @else
                    <a href="/search" class="menusxx"><button class="btn btn-sm btn-danger" style="border-radius: 2rem;padding: 0.3rem 0.6rem;">
                      Pilih Toko
                    </button></a>
                  @endif
                </div>
              </div>
              
            </div>
          </div>
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
      @if($cekvoucher)
      <div class="row">
        <div class="col">
          <div class="card-body bg-biru-muda shadow-ss" style="border-radius: 1rem;">
            <div style="font-size: 11px;color: black;">Selamat Anda mendapatkan Voucher Undian <b>{{ strtoupper($cekvoucher->name) }}</b> dan berkesempatan mendapatkan banyak hadiah. Voucher undian bisa cek disini!</div>
            <div style="padding-top:10px;">
              <a href="/voucherundian"><button class="btn btn-block btn-sm btn-primary">Lihat Voucher</button></a>
              </div>

          </div>
        </div>
      </div>
      @endif
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
                            <b style="font-size: 13px;">{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
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
                            <b style="font-size: 13px;">{{ $saldopoin ? $saldopoin->sisa : '0' }}</b>
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


     <!--  <div class="row">
        <div class="col-12">
          <div class="card-body bg-success shadow-ss" style="border-radius: 1rem;padding: 0.5rem 0.5rem 0.5rem 1rem;">    
            <table width="100%">
              <tr>
                <td align="left">
                  <a href="/xhome/isisaldo" class="menusxx">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="80%" src="/assets/content/img/icons/dompet.png">
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <div style="font-size:10px;">Saldoku :</div>
                            <b style="font-size: 13px;">{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
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
                            <img width="120%" src="/assets/content/img/icons/beras1.png">
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <a href='/reedem_point/produk' style="color: white;">
                            <div style="font-size:10px;">Butir Padi :</div>
                            <b style="font-size: 13px;">{{ $saldopoin ? $saldopoin->sisa : '0' }}</b>
                            </a>
                          </td>
                        </tr>
                      </table>
                      
                    </div>
                </td>
                <td>&nbsp;</td>
                <td align="left">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/hadiah.png">
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <a href='/reedem_point/produk' style="color: white;">
                            <div style="font-size:10px;">Hadiahku :</div>
                            <b style="font-size: 13px;">1</b>
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
      </div> -->


      @if(isset($mission) && !empty($mission))
        @include('content.mission.layouts.collection',['mission',$mission])
      @endif

      <!-- ============== CEK ADA TRANSAKSI REEDEM IOLO ============= -->
      @if($reedems->count() != 0)
      <div class="row">
        <div class="col">
          <div class="card-header bg-white shadow-sm">
              <h6 class="text-uppercase ls-1 mb-1">Transaksi Berlangsung</h6>
          </div>
          <div class="card-body bg-biru-muda shadow-ss">
            <div style="font-size: 11px;color: black;">Berikut Transaksi yang sedang berlangsung :</div>
            <br >
            @foreach($reedems as $reedem)
            @php

              $barang = DB::table('transaction_details')
              ->select("product.name","transactions.created_at","transaction_details.qty as amount","transactions.ready")
              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
              ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
              ->where("transactions.id", $reedem->id)
              ->first();

              $cekhadiah = DB::table('undian_hadiahs')
              ->leftJoin("undians", "undian_hadiahs.undian_id", "=", "undians.id")
              ->where("undian_hadiahs.transaction_id", $reedem->id)
              ->where("due_date",">=", date('Y-m-d'))
              ->first();

            @endphp

            <a href="/users/transaksi/detail?uuid={{ $reedem->uuid }}">
              @if(!$cekout)
              <div class="card shadow-ss menusxx pop" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Transaksi Pengambilan yang sedang on proses disini, Klik Transaksi dan Tunjukan ke Petugas saat Pengambilan">
              @else
              <div class="card shadow-ss menusxx">
              @endif
                <div class="card-body" style="padding-left: 1rem;padding-right: 1rem;">
                  <table width="100%" border="0">
                    <tr>
                      <td width="25%" rowspan="4">
                        <div class="icon icon-shape bg-iolo text-white rounded-circle shadow-ss">
                          <i class="fas fa-handshake" style="color: #ffffff"></i>
                      </div>
                      </td>
                      <td><b><div style="font-size: 17px"></div></b></td>
                    </tr>

                    @php

                      $barang2 = DB::table('transaction_details')
                      ->select("product.name","transactions.created_at","transaction_details.qty","wilayah.name as wilayah_name")
                      ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                      ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                      ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                      ->leftJoin("users", "posts.user_id", "=", "users.id")
                      ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                      ->where("transactions.id", $reedem->id)
                      ->first();

                      $details = DB::table('transaction_details')
                      ->select("product.name","posts.name as post_name")
                       ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                      ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                      ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                      ->distinct()
                      ->where("transactions.id", $reedem->id)
                      ->limit(2)
                      ->get();

                      $detailcounts = DB::table('transaction_details')
                      ->select("product.name","posts.name as post_name")
                       ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                      ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                      ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                      ->distinct()
                      ->where("transactions.id", $reedem->id)
                      ->count();

                    @endphp

                    @if($cekhadiah)

                    <tr>
                      <td>
                        <div class="text-warning" style="font-size: 12px; color: black;">
                          <b>SELAMAT Anda Dapat Hadiah!</b>
                        </div>
                      </td>
                    </tr>
                    <td>
                        <div style="font-size: 12px;color: black;padding-bottom: 5px;">
                          <b > @foreach($details as $detail) {{ $detail->name }} {{ $detail->post_name }}, @endforeach</b><br>
                          <div style="font-size: 10px;">Anda memenangkan Undian {{ $cekhadiah->name  }}, Pengambilan Hadiah ini harus dilakukan pada Outlet <b>{{ $barang2->wilayah_name }}</b> sebelum tanggal <b class="text-danger">{{ date('d F Y', strtotime($cekhadiah->due_date)) }}</b></div>
                        </div>
                      </td>
                    @else
                    <tr>
                      <td>
                        <div class="text-warning" style="font-size: 12px; color: black;">
                          <b>@foreach($details as $detail) {{ $detail->name }} {{ $detail->post_name }}, @endforeach</b>
                          @if($detailcounts > 2)
                          <b style="color: black; font-size: 11px;">+ {{ $detailcounts - 2 }} Produk</b>
                          @endif
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div style="font-size: 12px;color: black;padding-bottom: 5px;">
                          <b >{{ $detailcounts }} Produk</b><br>
                          <div style="font-size: 10px;">Transaksi ini harus dilakukan pada Outlet <b>{{ $barang2->wilayah_name }}</b></div>
                          @if($reedem->ket != '' || $reedem->ket != NULL)
                            <div style="font-size: 10px;">Keterangan : <b>{{ $reedem->ket }}</b></div>
                          @endif
                          @if($reedem->plan != '' || $reedem->plan != NULL)
                            <div style="font-size: 10px;">Rencana Reedem : <b>{{ date('d F Y H:i', strtotime($reedem->plan)) }}</b></div>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @endif
                  </table>
                  @if($barang->ready == 'yes')
                  <hr style="margin-top: 0.5rem;margin-bottom: 0.5rem;">
                  <div style="font-size: 14px;" class="text-success"><b>Pesanan Anda Ready</b></div>
                  <div style="font-size: 10px; color: black;">Barang Anda sudah siap diambil, barang sudah di siapkan oleh Petugas kami</div>
                  @endif
                </div>
              </div>
            </a>
            <br>
            @endforeach

          </div>
        </div>
      </div>
      @endif

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
      
      <!-- ====== TOKO PILIHAN ===== -->

      <!-- <div class="row">
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
                <div class="col-12" style="padding-bottom: 0px;">
                  
                  <img class="card-img-top" width="100%" alt="Image placeholder" src="/assets/img_wilayah/{{ $toko->img }}">
                  
                  @if(!$sudahtour)
                  <div class="bottom-left pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Informasi Toko/Site yang Anda Pilih">
                  @else
                  <div class="bottom-left">
                  @endif

                    <div style="font-size: 11px;color: white;">
                      Toko Pilihan Anda :
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
      </div> -->

     <!--  ======= PENCARIAN =========== -->

    <!-- <div class="row">
      <div class="col-10" style="padding-bottom:0px;">
        <input type="text" id="cari" placeholder="Cari Produk di Toko ini" class="form-control">
      </div>
      <div class="col-2" style="padding-left: 0px;padding-bottom:0px;">
        <button onclick="Cari();" id="myBtn" class="btn btn-info btn-block" style="padding-right: 1rem;padding-left: 0.8rem;">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </div> -->

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
    <!-- <div class="row">
      <div class="col-4">
        <div onclick="PembayaranInfo();" class="card shadow-ss" style="border-radius: 0.8rem;">
          <div class="card-body" style="padding:12px;" align="center">
            <img src="/assets/content/img/icons/secure.png">
            <br>
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
    </div> -->

    <!-- ====== PRODUK  REEDEM ====== -->
    @if(isset($bracket_reedem) && !empty($bracket_reedem))
        @include('content.reedem_point.layouts.carousel-product',['bracket_reedem' => $bracket_reedem])
    @endif

  <!-- ====== PRODUK ====== -->
  <div class="row pop" id="contentproduk">

    <!-- ===== KATEGORI BBM ====== -->
    <div id="category" class="col-12" style="padding-top: 10px;">
        <div class="variable-width">
          <button type="button" onclick="Kategori(0,{{ $wilayahid }})" class="btn btn-warning kat" id="kate_0" style="border-radius:1.2rem;">All</button>
        @foreach($kategori as $kat)

          @if($toko)
            @if($products->count() != 0)
              <button type="button" onclick="Kategori({{ $kat->id }},{{ $wilayahid }})" id="kate_{{ $kat->id }}" class="btn btn-outline-warning kat" style="border-radius:1.2rem;">{{ strtoupper($kat->name) }}</button>            
            @endif
          @endif
        @endforeach
      </div>
    </div>

  </div>
  <div class="row" id="links_container">

        @include('content.home.users.listproduk')  

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

  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('promo.iklan') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'loc': $('#location').val()
      },
      success: function (data) {

        if(data.status == 1){

          $('#gambar').attr('src','/assets/img_iklan/'+data.img);

           $('#iklan').modal('show'); 

        } 
      }
    });

  });

  function Kategori(id,wilayah) {

      $.get('/home/produk?kategori='+id+'&wilayah='+wilayah+'', function(data) {
          document.getElementById('links_container').innerHTML = data;
      })

      $('.kat').attr("class","btn btn-outline-warning kat");
      $('#kate'+id).attr("class","btn btn-warning kat");

  }

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

      $('.variable-width').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        centerMode: false,
        variableWidth: true,
        arrows: false,
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

  function Maintenance(){

    $('#maintenances').modal('show');

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

  // var input = document.getElementById("cari");

  // input.addEventListener("keyup", function(event) {
  //   if (event.keyCode === 13) {
  //    event.preventDefault();
  //    document.getElementById("myBtn").click();
  //   }
  // });

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
