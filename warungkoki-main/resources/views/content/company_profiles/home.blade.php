@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <a href="/home"><button type="button" class='btn btn-sm btn-success'>Kembali</button></a><br><br>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-1 mb-xl-0">
          <div class="card card-profile shadow">
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
                <a href="/login"><button class="btn btn-sm btn-info mr-4">Follow</button></a>
                <a href="/login" class="btn btn-sm btn-success float-right">Message</a>
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
                <div class="h5 font-weight-300" align="center">
                 {{ $companies->alamat }} - {{ $companies->regency_name }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="alert alert-putih shadow" role="alert">
              <button id="deals" class="btn btn-sm btn-success menu" type="button">DEALS</button>
              <button id="challanges" class="btn btn-sm btn-secondary menu" type="button">CHALLANGES</button>
              <button id="loyalty" class="btn btn-sm btn-secondary menu" type="button">PRODUK</button>
          </div>
        </div>

        <!-- ============= PRODUK ============== -->

          @if($companyproducts->count() == '0')
            <div class="col-12 loyaltycontent contents" style="display: none;">
              <div class="alert alert-putih shadow" role="alert">
                  <h6>Belum Ada Produk Apapun untuk saat ini!</h6>
              </div>
            </div>
          @else
          @foreach($companyproducts as $companyproduct)
          <div class="col-6 loyaltycontent contents" style="display: none;">
            <a href="/users/detail/{{ $companyproduct->id }}">
            <div class="card shadow">
              <div class="type">
                <span class="badge badge-pill badge-primary">{{ $companyproduct->type }}</span>
              </div>
              <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $companyproduct->imgname }}" alt="Card image cap">
  
              <div class="love2">
                <div class="circle4"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
              </div>
              <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                <h5> <b>{{ $companyproduct->name }}</b></h5>

                <a href="/company/profilehome/{{ $companyproduct->wilayah_id }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $companyproduct->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $companyproduct->regency_name }}</b></div><hr>
                <h3 style="color: #fb6340;"><b>{{ rupiah($companyproduct->harga_act) }}</b></h3>


              </div>
            </div>
            </a>
          </div> 
          @endforeach 
          @endif

          <!-- ============= DEALS ============== -->

          @if($companyprofiles->count() == '0')
            <div class="col-12 dealscontent contents" style="display: block;">
              <div class="alert alert-putih shadow" role="alert">
                  <h6>Belum Ada Deals Apapun untuk saat ini!</h6>
              </div>
            </div>
          @else
          @foreach($companyprofiles as $companyprofile)
          <div class="col-6 dealscontent contents" style="display: block;">
            <a href="/users/detail/{{ $companyprofile->id }}">
            <div class="card shadow">
              <div class="type">
                <span class="badge badge-pill badge-primary">{{ $companyprofile->type }}</span>
              </div>
              <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $companyprofile->imgname }}" alt="Card image cap">
              <div class="love2">
                <div class="circle4"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
              </div>
              <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                <h5> <b>{{ $companyprofile->name }}</b></h5>

                <a href="/company/profilehome/{{ $companyprofile->wilayah_id }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $companyprofile->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $companyprofile->regency_name }}</b></div><hr>
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
              <div class="alert alert-putih shadow" role="alert">
                  <h6>Belum Ada Challanges untuk saat ini!</h6>
              </div>
            </div>
          @else
          @foreach($companychallanges as $companychallange)
          <div class="col-12 challangecontent contents" style="display: none;">
            <a href="/users/challanges/{{ $companychallange->id }}">
              <div class="card shadow">
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

      });

      $('#challanges').on('click', function () {

          $('.menu').attr("class","btn btn-sm btn-secondary menu");
          $('#challanges').attr("class","btn btn-sm btn-success menu");

          $('.contents').attr("style","display: none;");
          $('.challangecontent').attr("style","display: block;");

      });

      $('#loyalty').on('click', function () {

          $('.menu').attr("class","btn btn-sm btn-secondary menu");
          $('#loyalty').attr("class","btn btn-sm btn-success menu");

          $('.contents').attr("style","display: none;");
          $('.loyaltycontent').attr("style","display: block;");

      });

    </script>
</body>

</html>