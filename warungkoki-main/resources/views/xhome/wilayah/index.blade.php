@include('xhome.layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-deliver pb-9 pt-6 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-1 mb-xl-0">
          <div class="card card-profile shadow-ss">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="/assets/img_company/{{ $companies->photo }}" class="rounded-circle">
                  </a>
                  <input type="hidden" id="uuidwilayah" value="{{ $wilayah->uuid }}">
                </div>
              </div>
            </div>
            <div class="card-header border-0 pt-5 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
                
                
                <!-- <a href="#" class="btn btn-sm btn-success float-right">Message</a> -->
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5" style="padding-bottom: 0px;">
                    <div>
                      <span class="heading">{{ $countfollow }}</span>
                      <span class="description" style="font-size: 0.7rem;">Followers</span>
                    </div>
                    <div>
                      <br><br>
                      @php
                        $ada = DB::table('follow')
                        ->where([
                          ['wilayah_id', '=', $wilayah_id],
                          ['user_id', '=', $iduser],
                        ])
                        ->first();
                      @endphp

                      @if(!$ada)
                        <button onclick="Follow({{ $wilayah_id }})" class="btn btn-sm btn-info mr-4">Follow</button>
                      @else
                        <button onclick="Unfollow({{ $wilayah_id }})" class="btn btn-sm btn-warning mr-4">Unfollow</button>
                      @endif
                    </div>
                    <div>
                      <span class="heading">{{ $countprod->count() }}</span>
                      <span class="description" style="font-size: 0.7rem;">Produk</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-center">
                <div style="font-size: 15px;padding-bottom: 7px;"><b>{{ $companies->name }}</b></div>
                <input type="hidden" value="{{ $wilayah_id }}" id="outletid">
                <div style="font-size: 10px;" align="center">
                 {{ $companies->alamat }} - {{ $companies->regency_name }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row isikategori">
        <div class="col-12">
          <input type="text" id="cariproduk" class="form-control" placeholder="Cari Produk di Toko ini">
        </div>
        <br>
        <div id="hasilcari">


        </div>
      </div>

      <!-- ====== KATEGORI ======== -->

      <div class="row isikategori" id="kategorinya">
        <div id="category" class="col-12">
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
          if($kat->id == '10' || $kat->id == '13' || $kat->id == '16'){
            $style = 'padding-right:3px';
          } else if($kat->id == '11' || $kat->id == '14' || $kat->id == '17'){
            $style = 'padding-left: 7.5px;padding-right: 7.5px;';
          } else {
            $style = 'padding-left:3px';
          }

          $ada = DB::table('posts')
          ->select('posts.kategori_id','posts.product_id')
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->where([
              ["wilayah.id", $wilayah_id],
              ["posts.active", "Y"],
              ['wilayah.active', '=', "Y"],
              ['kategori_id', '=', $kat->id],
              ['type', '=', 'Delivery'],
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

      <hr>

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
              ["wilayah.id", $wilayah_id],
              ["posts.active", "Y"],
              ['wilayah.active', '=', "Y"],
              ['posts.kategori_id', '=', $kat->id],
              ['posts.type', '=', 'Delivery'],
              ['posts.deleted_at', '=', null],
          ])
          ->orderBy('posts.id', 'desc')
          ->limit(6)
          ->groupBy("posts.product_id")
          ->get();

          @endphp

          
          @if($products->count() != 0)
          <div id="category" class="col-12" style="padding-top: 10px;">
            <table width="100%">
              <tr>
                <td align="left" style="font-size: 15px;"><b>KATEGORI {{ strtoupper($kat->name) }}</b></td>
                <td align="right">
                 <a class="menusxx" href="/xhome/wilayah/kategori?id={{ $kat->id }}&wilayah={{ $wilayah->uuid }}"><div class="text-warning"><b>Lihat Semua</b></div></a>
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
                ["wilayah.id", $wilayah_id],
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
              <div class="type">
                <span class="badge badge-pill badge-primary">{{ $post->type }}</span>
              </div>
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
      
      
      
    @include('xhome.layout.footer')
    <script type="text/javascript">

      $('#deals').on('click', function () {

          $('.menu').attr("class","btn btn-sm btn-secondary menu");
          $('#deals').attr("class","btn btn-sm btn-success menu");

          $('.contents').attr("style","display: none;");
          $('.dealscontent').attr("style","display: block;");
          $('.isikategori').attr("style","display: none;");

      });

      $('#challanges').on('click', function () {

          $('.menu').attr("class","btn btn-sm btn-secondary menu");
          $('#challanges').attr("class","btn btn-sm btn-success menu");

          $('.contents').attr("style","display: none;");
          $('.challangecontent').attr("style","display: block;");
          $('.isikategori').attr("style","display: none;");

      });

      $('#loyalty').on('click', function () {

          $('.menu').attr("class","btn btn-sm btn-secondary menu");
          $('#loyalty').attr("class","btn btn-sm btn-success menu");

          $('.contents').attr("style","display: none;");
          $('.loyaltycontent').attr("style","display: block;");
          $('.isikategori').attr("style","");

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

      function Lihat(){

        $('.lihatcontent').attr("style","display: block;");
        $('#lihat').attr("onclick","Tutup()");
        $('#lihat').attr("class", "btn btn-sm btn-danger");
        $('#lihat').html("Tutup");

      }

      function Tutup(){

        $('.lihatcontent').attr("style","display: none;");
        $('#lihat').attr("onclick","Lihat()");
        $('#lihat').attr("class", "btn btn-sm btn-success");
        $('#lihat').html("Lihat Semua");

      }

      

      $('#cariproduk').on('keyup', function () {

        $('#kategorinya').attr("style", "display: none;");

        var prod = $(this).val();

        if(prod == ''){
          $('#kategorinya').attr("style", "");
        } else {
          $('#kategorinya').attr("style", "display: none;");
        }

        $.ajax({
          type: 'POST',
          url: "{{ route('xhome.wilayah.cariproduk') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'outletid': $('#outletid').val(),
              'produk': prod,
              
          },
          success: function(data) {

            var content_data="";
            var no = -1;

            if (data.length == '0'){

              content_data += "<div class='col-12 loyaltycontent contents' style='display: block;'>";
              content_data += "<div class='alert alert-putih shadow-ss' role='alert'>";
              content_data += "<table width='100%'>";
              content_data += "<tr>";
              content_data += "<td align='center'>";
              content_data += "<img src='/assets/content/img/theme/produkempty.jpg' width='90%'>";
              content_data += "<br>";
              content_data += "<div style='font-size: 14px;color: black;padding-bottom: 6px;'><b>Kosong!</b></div>";
              content_data += "<h6>Tidak ada Produk Apapun disini cari di Tab lainnya!</h6>";
              content_data += "</td>";
              content_data += "</tr>";
              content_data += "</table>";
              content_data += "</div>";
              content_data += "</div>";

                $('#contentproduk').html(content_data);

            } else {

              $.each(data, function() {

                no++;
                var id = data[no]['id'];
                var type = data[no]['type'];
                var imgname = data[no]['prod_img']; 
                var name = data[no]['name'];
                var prodname = data[no]['prod_name'];
                var wilayah_id = data[no]['wilayah_id'];
                var uuid = data[no]['uuid'];
                var wilayah_name = data[no]['wilayah_name'];
                var regency_name = data[no]['regency_name'];
                var harga_act = data[no]['harga_act'];

                var number_string = harga_act.toString(),
                  sisa  = number_string.length % 3,
                  rupiah  = number_string.substr(0, sisa),
                  ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                    
                if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
                }

                content_data += "<div class='col-6 loyaltycontent contents' style='display: block;'>";
                content_data += "<a href='/xhome/detail/"+id+"'>";
                content_data += "<div class='card shadow-ss'>";
                content_data += "<img class='card-img-top' width='50px' src='/assets/img_post/"+imgname+"' alt='Card image cap'>";
      
                content_data += "<div class='love2'>";
                content_data += "<div class='circle4'><i class='ni ni-favourite-28' style='color: #fff'></i></div>";
                content_data += "</div>";
                content_data += "<div class='card-body' style='padding-right: 1rem;padding-left: 1rem;'>";
                content_data += "<h5> <b>"+prodname+" "+name+"</b></h5>";

                content_data += "<a href='/company/profile?id="+uuid+"'><span class='badge badge-pill badge-success' style='font-size: 8px;'><i class='fa fa-map-marker'></i> "+wilayah_name+"</span></a><br><div style='font-size: 8px;padding-top: 12px;'>Barang ini tersedia di daerah <b>"+regency_name+"</b></div><hr>";
                content_data += "<h3 style='color: #fb6340;'><b>Rp. "+rupiah+"</b></h3>";
                content_data += "</div>";
                content_data += "</div>";
                content_data += "</a>";
                content_data += "</div>";

              });

              $('#contentproduk').html(content_data);

            }

          }

        });

      });

function Kategory(id){

  var uuid = $('#uuidwilayah').val();

  setTimeout(function(){ window.location.href = '/xhome/wilayah/kategori?id='+id+'&wilayah='+uuid+''; }, 1500);

}
</script>
</body>

</html>