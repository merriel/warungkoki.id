@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-5 pt-md-8">
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
                </div>
              </div>
            </div>
            <div class="card-header border-0 pt-5 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
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
                
                <a href="#" class="btn btn-sm btn-success float-right">Message</a>
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    <div>
                      <span class="heading">{{ $countfollow }}</span>
                      <span class="description" style="font-size: 0.6rem;">Followers</span>
                    </div>
                    <div>
                      <span class="heading">{{ $countdeals }}</span>
                      <span class="description" style="font-size: 0.6rem;">Deals</span>
                    </div>
                    <div>
                      <span class="heading">{{ $countchallanges }}</span>
                      <span class="description" style="font-size: 0.6rem;">Challanges</span>
                    </div>
                    <div>
                      <span class="heading">{{ $countprod }}</span>
                      <span class="description" style="font-size: 0.6rem;">Produk</span>
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="text-center">
                <h3>{{ $companies->name }}</h3>
                <input type="hidden" value="{{ $wilayah_id }}" id="outletid">
                <div class="h5 font-weight-300" align="center">
                 {{ $companies->alamat }} - {{ $companies->regency_name }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="alert alert-putih shadow-ss" role="alert">
              <button id="loyalty" class="btn btn-sm btn-success menu" type="button">PRODUK</button>

              <button id="challanges" class="btn btn-sm btn-secondary menu" type="button">CHALLANGES</button>
              
              <button id="deals" class="btn btn-sm btn-secondary menu" type="button">DEALS</button>
              
          </div>
        </div>
      </div>

      <div class="row isikategori">
        <div class="col-12">
          <input type="text" id="cariproduk" class="form-control" placeholder="Cari Produk di Outlet ini">
        </div>
        <br>
        <div id="hasilcari">


        </div>
      </div>
      <div class="row isikategori" id="kategorinya">
        <div id="category" class="col-12">
          <table width="100%">
            <tr>
              <td align="left" style="font-size: 14px;"><b>Category</b></td>
              <td align="right">
                <!-- <button onclick="Lihat();" id="lihat" class="btn btn-sm btn-success" type="button">Lihat Semua</button> -->
              </td>
            </tr>
          </table>
        </div>

        <div class="col-3" onclick="Kategory(2)" style="padding-right: 3px;">
          <div id="color_2" class="card bg-iolo shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-car kategoriicon" id="icon_2" style="font-size: 23px; color: #ffffff"></i></td>
                </tr>
                <tr>
                  <td height="7px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b id="text_2" class="kategoritext" style="color: white;">Otomotif</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3" onclick="Kategory(1)" style="padding-left: 12px;padding-right: 7.5px;">
          <div id="color_1" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-medkit kategoriicon" id="icon_1" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_1">Kesehatan</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3" onclick="Kategory(5)" style="padding-left: 7.5px;padding-right: 12px;">
          <div id="color_5" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-gift kategoriicon" id="icon_5" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_5">Makanan</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3" onclick="Kategory(6)" style="padding-left: 3px;">
          <div id="color_6" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-coffee kategoriicon" id="icon_6" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_6">Minuman</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3 lihatcontent" onclick="Kategory(8)" style="padding-right: 3px;">
          <div id="color_8" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-tint kategoriicon" id="icon_8" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="7px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_8">Cemilan</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3 lihatcontent" onclick="Kategory(3)" style="padding-left: 12px;padding-right: 7.5px;">
          <div id="color_3" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-futbol kategoriicon" id="icon_3" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_3">Olahraga</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3 lihatcontent" onclick="Kategory(4)" style="padding-left: 7.5px;padding-right: 12px;">
          <div id="color_4" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-desktop kategoriicon" id="icon_4" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_4">Hobi</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-3 lihatcontent" onclick="Kategory(7)" style="padding-left: 3px;">
          <div id="color_7" class="card shadow-ss kategori">
            <div class="card-body" style="padding: 15px 5px 5px 5px;">
              <table width="100%" border="0">
                <tr>
                  <td align="center"><i class="fa fa-male kategoriicon" id="icon_7" style="font-size: 23px; color: #01497f"></i></td>
                </tr>
                <tr>
                  <td height="5px"></td>
                </tr>
                <tr>
                  <td align="center"><h6><b class="kategoritext" id="text_7">Gaya</b></h6></td>
                </tr>
              </table>
            </div>
          </div>
        </div>

      </div>
      <div class="row" id="contentproduk">
        <!-- ============= PRODUK ============== -->

          @if($companyproducts->count() == '0')
            <div class="col-12 loyaltycontent contents" style="display: block;">
              <div class="alert alert-putih shadow-ss" role="alert">
                  <table width="100%">
                    <tr>
                      <td align="center">
                        <img src="/assets/content/img/theme/produkempty.jpg" width="90%">
                        <br>
                        <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                        <h6>Tidak ada Produk Apapun disini cari di Tab lainnya!</h6>
                      </td>
                    </tr>
                  </table>
              </div>
            </div>
          @else
          @foreach($companyproducts as $companyproduct)
          <div class="col-6 loyaltycontent contents" style="display: block;">
            <a href="/users/detail/{{ $companyproduct->id }}">
            <div class="card shadow-ss">
              <div class="type">
                <span class="badge badge-pill badge-primary">{{ $companyproduct->type }}</span>
              </div>
              <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $companyproduct->imgname }}" alt="Card image cap">
              @php
                $ada = DB::table('favorite')
                ->where([
                    ['post_id', '=', $companyproduct->id],
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
                <h5> <b>{{ $companyproduct->name }}</b></h5>

                <a href="/company/profile?id={{ $companyproduct->uuid }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $companyproduct->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $companyproduct->regency_name }}</b></div><hr>
                <h3 style="color: #fb6340;"><b>{{ rupiah($companyproduct->harga_act) }}</b></h3>


              </div>
            </div>
            </a>
          </div> 
          @endforeach 
          @endif

        </div>

        <div class="row">

          <!-- ============= DEALS ============== -->

          @if($companyprofiles->count() == '0')
            <div class="col-12 dealscontent contents" style="display: none;">
              <div class="alert alert-putih shadow-ss" role="alert">
                <table width="100%">
                  <tr>
                    <td align="center">
                      <img src="/assets/content/img/theme/dealempty.jpg" width="90%">
                      <br>
                      <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                      <h6>Tidak ada Deals Apapun disini cari di Tab lainnya!</h6>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          @else
          @foreach($companyprofiles as $companyprofile)
          <div class="col-6 dealscontent contents" style="display: none;">
            <a href="/users/detail/{{ $companyprofile->id }}">
            <div class="card shadow-ss">
              <div class="type">
                <span class="badge badge-pill badge-primary">{{ $companyprofile->type }}</span>
              </div>
              <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $companyprofile->imgname }}" alt="Card image cap">
              @php
                $ada = DB::table('favorite')
                ->where([
                    ['post_id', '=', $companyprofile->id],
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
                <h5> <b>{{ $companyprofile->name }}</b></h5>

                <a href="/company/profile?id={{ $companyprofile->uuid }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $companyprofile->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $companyprofile->regency_name }}</b></div><hr>
                <h6 style="text-decoration:line-through;">{{ rupiah($companyprofile->harga_crt) }}</h6>
                <h3 style="color: #fb6340;"><b>{{ rupiah($companyprofile->harga_act) }}</b></h3>


              </div>
            </div>
            </a>
          </div> 
          @endforeach 
          @endif

          <!-- ========== Challanges ================ -->

          @if($companychallanges->count() == '0')
            <div class="col-12 challangecontent contents" style="display: none;">
              <div class="alert alert-putih shadow-ss" role="alert">
                  <table width="100%">
                    <tr>
                      <td align="center">
                        <img src="/assets/content/img/theme/challangeempty.jpg" width="90%">
                        <br>
                        <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                        <h6>Tidak ada Challange Apapun disini cari di Tab lainnya!</h6>
                      </td>
                    </tr>
                  </table>
              </div>
            </div>
          @else
          @foreach($companychallanges as $companychallange)
          <div class="col-12 challangecontent contents" style="display: none;">
            <a href="/users/challanges/{{ $companychallange->id }}">
              <div class="card shadow-ss">
                <div class="card-body">
                  <table width="100%" border="0">
                    <tr>
                      <td width="25%" rowspan="4">
                        <a href="#" class="avatar rounded-circle mr-3">
                          <img alt="Image placeholder" src="/assets/img_post/{{ $companychallange->imgname }}">
                        </a>
                      </td>
                      <td><h4><b>{{ $companychallange->name }}</b></h5></td>
                    </tr>
                    <tr>
                      <td style="font-size: 9px; color: black;"> <div style="padding-bottom: 2px;">Periode Challange :</div>
                        <div style="font-size: 14px;"><b>{{  date('d M Y', strtotime($companychallange->dari)) }} - {{  date('d M Y', strtotime($companychallange->sampai)) }}</b></div>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-size: 9px; color: black;"><br> <div style="padding-bottom: 2px;">
                        Batas Reedem Hadiah : </div>  
                        <div style="font-size: 14px;"><b>{{ date('d M Y', strtotime($companychallange->dari_reward)) }} - {{ date('d M Y', strtotime($companychallange->sampai_reward)) }}</b></div>
                      </td>
                    </tr>
                  </table>
                  <hr>
                  <div style="font-size: 10px; color: black; padding-bottom: 5px;">Lokasi Challange :</div>
                    <span class="badge badge-pill badge-info" style="font-size: 9px;"><i class="fas fa-map-marker"></i>  {{ $companychallange->wilayah_name }} - {{ $companychallange->regency_name }}</span>
                  <hr>
                  <h6>HADIAH YANG DIDAPAT :</h6>
                  @php

                  $details = DB::table('post_rewards')
                  ->select('product.*', 'post_rewards.qty')
                  ->leftJoin('product', 'post_rewards.product_id', '=', 'product.id')
                  ->where('post_id', $companychallange->id)
                  ->get();

                  @endphp
                  <table id="customers">
                    <tr>
                      <th>Nama Produk</th>
                      <th>Qty</th>
                    </tr>
                    @foreach($details as $detail)
                    <tr>
                      <td style="color: black;">{{ $detail->name }}</td>
                      @if($detail->qty >= 1000)
                        <td style="color: black;">{{ rupiah($detail->qty) }}</td>
                      @else
                        <td style="color: black;">{{ $detail->qty }} Pcs</td>
                      @endif
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </a>
          </div> 
          @endforeach 
          @endif
        </div>

        <!-- ============ END Challanges ================ -->

        </div>
      </div>
    </div>
      
    @include('layout.footer')
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

      function Kategory(id){

        $('.kategoriicon').attr("style", "font-size: 23px; color: #01497f;");
        $('.kategori').attr("class", "card shadow-ss kategori");
        $('.kategoritext').attr("style", "");

        $('#icon_'+id).attr("style", "font-size: 23px; color: #ffffff;");
        $('#text_'+id).attr("style", "color: white;");
        $('#color_'+id).attr("class", "card bg-iolo shadow-ss kategori");

        $.ajax({
          type: 'POST',
          url: "{{ route('company.kategori') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': id,
              'outletid': $('#outletid').val(),
              
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
                var imgname = data[no]['imgname']; 
                var name = data[no]['name'];
                var wilayah_id = data[no]['wilayah_id'];
                var wilayah_name = data[no]['wilayah_name'];
                var uuid = data[no]['uuid'];
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
                content_data += "<a href='/users/detail/"+id+"'>";
                content_data += "<div class='card shadow-ss'>";
                content_data += "<div class='type'>";
                content_data += "<span class='badge badge-pill badge-primary'>"+type+"</span>";
                content_data += "</div>";
                content_data += "<img class='card-img-top' width='50px' src='/assets/img_post/"+imgname+"' alt='Card image cap'>";
      
                content_data += "<div class='love2'>";
                content_data += "<div class='circle4'><i class='ni ni-favourite-28' style='color: #fff'></i></div>";
                content_data += "</div>";
                content_data += "<div class='card-body' style='padding-right: 1rem;padding-left: 1rem;'>";
                content_data += "<h5> <b>"+name+"</b></h5>";

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
          url: "{{ route('company.cariproduk') }}",
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
                var imgname = data[no]['imgname']; 
                var name = data[no]['name'];
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
                content_data += "<a href='/users/detail/"+id+"'>";
                content_data += "<div class='card shadow-ss'>";
                content_data += "<div class='type'>";
                content_data += "<span class='badge badge-pill badge-primary'>"+type+"</span>";
                content_data += "</div>";
                content_data += "<img class='card-img-top' width='50px' src='/assets/img_post/"+imgname+"' alt='Card image cap'>";
      
                content_data += "<div class='love2'>";
                content_data += "<div class='circle4'><i class='ni ni-favourite-28' style='color: #fff'></i></div>";
                content_data += "</div>";
                content_data += "<div class='card-body' style='padding-right: 1rem;padding-left: 1rem;'>";
                content_data += "<h5> <b>"+name+"</b></h5>";

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
    </script>
</body>

</html>