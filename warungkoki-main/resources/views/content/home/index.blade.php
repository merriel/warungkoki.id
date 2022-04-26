@include('layout.head')
  <div class="main-content">
    <!-- Header -->
<div class="container-fluid pb-4 pt-4 pt-md-8">
    <div class="row">
      <div class="col">
        <div class="card shadow">
          <div class="card-header bg-iolo-blue">
            <h6 class="text-uppercase text-white ls-1 mb-1">CATEGORIES</h6>
          </div>
          
          <div class="card-body bg-white" id="menu_icons" style="display: block;"> 
            <table border="0" align="center" width="100%">
              <tr>
                <td align="center" width="25%">
                  <a href="/kategori/home/1" class="kategori">
                    <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow kategori">
                        <i class="fas fa-medkit" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/2" class="kategori">
                    <div id="pengemudi" class="icon icon-shape bg-green text-white rounded-circle shadow kategori">
                        <i class="fas fa-motorcycle" style="color: #ffffff"></i>
                        <input type="hidden" id="selesai" value="0">
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/3" class="kategori">
                    <div id="keluhan" class="icon icon-shape bg-red text-white rounded-circle shadow kategori">
                        <i class="fas fa-futbol" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/4" class="kategori">
                    <div id="keluhan" class="icon icon-shape bg-orange text-white rounded-circle shadow kategori">
                        <i class="fas fa-desktop" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                
              </tr>
              <tr>
                 <td height="10px" colspan="7"></td> 
              </tr>
              <tr>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Kesehatan</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Otomotif</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Olahraga</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Hobby</h6>
                </td>
                
              </tr>
            </table>
            <br>
            <table border="0" align="center" width="100%">
              <tr>
                <td align="center" width="25%">
                  <a href="/kategori/home/5" class="kategori">
                    <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                        <i class="fas fa-mobile" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/6" class="kategori">
                    <div id="pengemudi" class="icon icon-shape bg-orange text-white rounded-circle shadow kategori">
                        <i class="fas fa-beer" style="color: #ffffff"></i>
                        <input type="hidden" id="selesai" value="0">
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/7" class="kategori">
                    <div id="keluhan" class="icon icon-shape bg-iolo-blue text-white rounded-circle shadow kategori">
                        <i class="fas fa-male" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                <td align="center" width="25%">
                  <a href="/kategori/home/8" class="kategori">
                    <div id="keluhan" class="icon icon-shape bg-blue text-white rounded-circle shadow kategori">
                        <i class="fas fa-tint" style="color: #ffffff"></i>
                    </div>
                  </a>
                </td>
                
              </tr>
              <tr>
                 <td height="10px" colspan="7"></td> 
              </tr>
              <tr>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Makanan</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Minuman</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Pakaian</h6>
                </td>
                <td align="center">
                  <h6 class="text-uppercase ls-1 mb-1">Cemilan</h6>
                </td>
                
              </tr>
            </table>
          </div>
        </div>
      </div>    
    </div>
          <!-- <div class="row">
            <div class="col-12">
              <img width="100%" src="/assets/img_banners/banner.jpg">
            </div>
          </div> -->
    <div class="ct-page-title">
      <h2 class="ct-title" id="content"><b>Toko Terbaru</b></h2>
    </div>
    <div class="row">
      @foreach($companies as $company)
        <div class="col-6">
          <div class="card shadow">
            <a href="/company/profilehome/{{ $company->id }}">
            <img class="card-img-top" width="50px" height="140px" src="/assets/img_company/{{ $company->photo }}" alt="Card image cap">
            <div class="card-body" style="padding-left: 1.2rem;padding-right: 1.2rem;">
              <h5> <b>{{ $company->name }}</b></h5>
              <div style="font-size: 8px; color: black;">Berlokasi di daerah <b>{{ $company->regency_name }}</b></div>
            </div>
            </a>

            <div align="center">
              <a href="/login"><button class="btn btn-sm btn-info">Follow Me</button> </a> 
            </div>
            <br>
          </div>
          
        </div>  
      @endforeach 
    </div>
          <!-- <div class="row">
            <div class="col-12">
              <img width="100%" src="/assets/img_banners/banner4.jpg">
            </div>
          </div> -->
    <div class="ct-page-title">
      <h2 class="ct-title" id="content"><b>Produk Terbaru</b></h2>
    </div>
    <div class="row">
      @foreach($productnews as $productnew)
      <div class="col-6">
        <a href="/home/detail/{{ $productnew->id }}" class="post">
        <div class="card shadow">
          <div class="type">
            <span class="badge badge-pill badge-primary">{{ $productnew->type }}</span>
          </div>
          <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $productnew->imgname }}" alt="Card image cap">

          <div class="love2">
            <div class="circle4"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
          </div>
          <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
            <h5> <b>{{ $productnew->name }}</b></h5>
            <a href="/company/profile/{{ $productnew->wilayah_id }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $productnew->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $productnew->regency_name }}</b></div><hr>
            @if($productnew->type == 'Deals')
            <h6 style="text-decoration:line-through;">{{ rupiah($productnew->harga_crt) }}</h6>
            @endif
            <h3 style="color: #fb6340;"><b>{{ rupiah($productnew->harga_act) }}</b></h3>
          </div>
        </div>
        </a>
      </div> 
    @endforeach 
    </div>
    <br>

@include('layout.footer')

<script type="text/javascript">
  
  $('.kategori').on('click', function () {

      $('.loading').attr('style','display: block');

  });

  $('.post').on('click', function () {

      $('.loading').attr('style','display: block');

  });
        
</script>
</body>

</html>