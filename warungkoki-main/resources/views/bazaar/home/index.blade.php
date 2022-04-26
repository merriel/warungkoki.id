@include('bazaar.layouts.head')
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
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-bazaar pt-2 pt-md-8" style="padding-bottom: 14rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid" style="margin-top: -10rem;">

          <div class="col-12" style="padding-bottom: 20px;padding-left: 0px;">
              <div style="font-size: 12px" class="text-white">Selamat Datang di X-Bazaar,</div>
              <div style="font-size: 21px" class="text-white"><b>{{ Auth::user()->name }}</b></div>
          </div>

          <!-- ============== CEK ADA TRANSAKSI REEDEM IOLO ============= -->
          @if($reedems->count() != 0)
          <div class="row">
            <div class="col">
              <div class="card-header bg-white shadow-sm">
                  <h6 class="text-uppercase ls-1 mb-1">Transaksi Ambil Pesanan Tomxperience</h6>
              </div>
              <div class="card-body bg-biru-muda shadow-ss">
                <div style="font-size: 11px;color: black;">Klik Transaksi Berikut, Tunjukan Barcode Tersebut kepada Petugas Kami !</div>
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
                                  <div style="font-size: 10px;">Transaksi Reedem ini harus dilakukan pada Outlet <b>{{ $barang2->wilayah_name }}</b></div>
                                  @if($reedem->ket != '' || $reedem->ket != NULL)
                                    <div style="font-size: 10px;">Keterangan : <b>{{ $reedem->ket }}</b></div>
                                  @endif
                                  @if($reedem->plan != '' || $reedem->plan != NULL)
                                    <div style="font-size: 10px;">Rencana Reedem : <b>{{ date('d F Y H:i', strtotime($reedem->plan)) }}</b></div>
                                  @endif
                                </div>
                                
                              </td>
                            </tr>
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

          <!-- ====== TOKO PILIHAN ===== -->

          <div class="row">
            <div class="col">
              <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
                @if(!$toko)

                  <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;">
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
                      <img class="card-img-top" width="100%" alt="Image placeholder" src="/assets/content/img/theme/shell-dashboard-min.jpeg">
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
                <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;background-color: #f3d9e0;">
                  <div class="row">
                      <div class="col-3">
                          <a href="#" class="avatar rounded-circle mr-3">
                        <img alt="Image placeholder" src="/assets/img_company/{{ $toko->photo }}">
                      </a>
                      </div>
                      <div class="col-6" style="padding-left: 0px;padding-right: 0px;">
                        <div style="font-size: 11px;">
                          {{ $toko->alamat }} - {{ $toko->regency_name }}
                        </div>
                      </div>
                      <div class="col-3">
                          <a href="/search" class="menusxx"><button class="btn btn-info btn-block" style="padding-right: 1rem;padding-left: 0.8rem;background-color: #c34468;border-color: #c34468;">
                            <i class="fa fa-home"></i>
                          </button></a>
                      </a>
                      </div>
                  </div> 
                </div>

                @endif
              </div>
            </div>    
          </div>


         <!--  ======= PENCARIAN =========== -->

         <div class="row">
          <div class="col-10">
            <input type="text" id="cari" placeholder="Cari Produk di Toko ini" class="form-control">
          </div>
          <div class="col-2" style="padding-left: 0px;">
            <button onclick="Cari();" id="myBtn" class="btn btn-info btn-block" style="padding-right: 1rem;padding-left: 0.8rem;background-color: #c34468;border-color: #c34468;">
              <i class="fa fa-search"></i>
            </button>
          </div>
         </div>

          <!-- ======== KATEGORI ======= -->

          <div class="row isikategori" id="kategorinya">
            @if(!$sudahtour)
            <div id="category" class="col-12 pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Anda bisa pilih kategori produk disini">
            @else
            <div id="category" class="col-12">
            @endif

              <table width="100%">
                <tr>
                  <td align="left" style="font-size: 15px;"><b>KATEGORI PRODUK</b></td>
                  <td align="right">
                    <!-- <button onclick="Lihat();" id="lihat" class="btn btn-sm btn-success" type="button">Lihat Semua</button> -->
                  </td>
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
                  ['type', '=', 'Bazaar'],
                  ['posts.deleted_at', '=', null],
              ])
              ->distinct()
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
                  ['posts.type', '=', 'Bazaar'],
                  ['posts.deleted_at', '=', null],
              ])
              ->orderBy('posts.id', 'desc')
              ->limit(4)
              ->groupBy("posts.product_id")
              ->get();

              @endphp

              @if($toko)
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
                    ['posts.type', '=', 'Bazaar'],
                    ['posts.deleted_at', '=', null],
                    ['posts.product_id', '=', $produk->product_id],
                ])
                ->first();

              @endphp

              <div class="col-6" style="{{ $paddings }}">
                <a href="/bazaar/detail/{{ $post->id }}" class="post">
                <div class="card shadow-sm">
                  <!-- <div class="type">
                    <span class="badge badge-pill badge-primary">{{ $post->type }}</span>
                  </div> -->
                  <div class="gambar">
                    <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap">
                    
                  </div>
                  <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <h5> <b>{{ $post->prod_name }}</b></h5>
                    <!-- <a href="/company/profile?id={{ $post->uuid }}">
                      <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $post->wilayah_name }}</span>
                    </a><br> -->
                    <div style="font-size: 9px;padding-top: 7px; color: black;">
                      Barang ini tersedia dan bisa Anda dapatkan di Booth Bazaar <b>{{ $post->wilayah_name }}</b>
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
                    <h6 style="text-decoration:line-through;">{{ rupiah($post->harga_crt + ceil($post->harga_crt * (float)$service->biaya / 100)) }}</h6>
                    <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act + ceil($post->harga_act * (float)$service->biaya / 100)) }}</b></h3>
                  </div>
                </div>
                </a>
              </div> 
              @endforeach 

            @endforeach

          </div>

<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('content.home.users.modal2')
@include('bazaar.layouts.footer')
@include('script.home')

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

</script>
</body>

</html>