@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <a href="/home"><button type="button" class='btn btn-sm btn-success'>Kembali</button></a><br>
      <div class="row">
        <div class="col">
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">{{ $kategori->name }}</h1>
            </div>
            <div class="row">
              @if($postnews->count() == '0')
              <div class="col-12">
                <div class="card shadow">
                  <div class="card-body" align="center">
                      <h6>Belum Ada Deals atau Challange Apapun pada Kategori ini!</h6>
                  </div>
                </div>
              </div>

              @else

                @foreach($postnews as $postnew)
                <div class="col-6">
                  <a href="/home/detail/{{ $postnew->id }}" class="post">
                  <div class="card shadow">
                    <div class="type">
                      <span class="badge badge-pill badge-primary">{{ $postnew->type }}</span>
                    </div>
                    <img class="card-img-top" width="50px" height="140px" src="/assets/img_post/{{ $postnew->imgname }}" alt="Card image cap">
        
                    <div class="love2">
                      <div class="circle4"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                    </div>
                    <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                      <h5> <b>{{ $postnew->name }}</b></h5>
                      <a href="/company/profile/{{ $postnew->wilayah_id }}"><span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $postnew->wilayah_name }}</span></a><br><div style="font-size: 8px;padding-top: 12px;">Barang ini tersedia di daerah <b>{{ $postnew->regency_name }}</b></div><hr>
                      @if($postnew->type == 'Deals')
                      <h6 style="text-decoration:line-through;">{{ rupiah($postnew->harga_crt) }}</h6>
                      @endif
                      <h3 style="color: #fb6340;"><b>{{ rupiah($postnew->harga_act) }}</b></h3>
                    </div>
                  </div>
                  </a>
                </div>  
                @endforeach 
              @endif
            </div>
          </div> 
        </div> 
      </div>
    </div>
      
    @include('layout.footer')

</body>

</html>