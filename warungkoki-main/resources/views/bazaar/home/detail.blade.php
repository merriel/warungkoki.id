@include('bazaar.layouts.head')

<body class="">
<div class="main-content">
    <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 5.5rem;">
  <!-- Card stats -->
  <table width="100%">
    <tr>
      <td width="10%">
        <a href="/home"><i style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-chevron-left"></i></a>
      </td>
      <td align="right">
        <div>
          
          &nbsp;&nbsp;&nbsp;
          @if($tour->detailprod != 1)
            <i onclick="onShare()" style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-share pop" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Untuk Share Produk ini Disini"></i>
          @else
            <i onclick="onShare()" style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-share"></i>
          @endif
        </div>
      </td>
    </tr>
  </table>
  <br>

<div class="row">
  <div class="col-12">
    <div class="card shadow-sm">

      <div class="gambar">
        <img class="card-img-top" id="imgpost" src="{{ asset('assets/img_post/') }}/{{ $postnews->img }}" alt="Card image cap">
      </div>
        
      <div class="card-body">
        <table width="100%">
          <tr>
            <td align="left">
              <div style="font-size: 16px; color: black;padding-bottom: 10px;"> <b>{{ $postnews->prod_name }}</b> <b id="text">{{ $postnews->name }}</b></div>
            </td>
          </tr>
        </table>
       
      
       <h5 style="text-decoration:line-through;" id="coret">{{ $postnews->type == 'Products' ? '' : rupiah($postnews->harga_crt + ceil($postnews->harga_crt * (float)$service->biaya / 100)) }}</h5>
        <table width="100%">
          <tr>
            <td align="left">
              <h2 style="color: #fb6340;"><b id="harga">{{ rupiah($postnews->harga_act + ceil($postnews->harga_act * (float)$service->biaya / 100)) }}</b></h2>

            </td>
            <td align="right" width="35%">
              @if($tour->detailprod != 1)
              <button class="btn btn-block btn-kuning pop" id="beli" onclick="Beli({{ $postnews->id }})" type="button"  data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Kamu bisa beli produk ini disini!">BELI </button>
              @else
              <button class="btn btn-block btn-kuning" style="background-color: #c34468;border-color: #c34468;" id="beli" onclick="Beli({{ $postnews->id }})" type="button">BELI</button>

              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">
            <div style="font-size: 9px;padding-top: 10px;">
              <i>*Harga produk di aplikasi sudah termasuk biaya layanan</i>
            </div>
          </td>
          </tr>
        </table>
        
        <!-- ======== VARIAN ===== -->

        @php
          $varian = DB::table('posts')
          ->select("posts.name","posts.img","posts.id")
          ->join("product", "posts.product_id", "=", "product.id")
          ->join("users", "posts.user_id", "=", "users.id")
          ->where([
            ['users.wilayah_id', '=', $postnews->wilayah_id],
            ['posts.product_id', '=', $postnews->prod_id],
            ['posts.active', '=', 'Y'],
            ['posts.deleted_at', '=', null],
            ['posts.type', '=', 'Bazaar'],
          ])
          ->get();

        @endphp

        @if($varian->count() > 1)
        <hr>
        <h4><b>Pilih Varian :</b></h4>
        @if($tour->detailprod != '1')
        <div class="row pop" style="padding-top: 12px;" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Pilih Varian Produk yang Kamu suka disini">
        @else
        <div class="row" style="padding-top: 12px;">
        @endif
         @foreach($varian as $var)
            @php
            if($var->id != $postnews->id){
              $notselect = 'opacity: 0.6;';
            } else {
              $notselect = '';
            }

            @endphp
            <div class="col-4" onclick="Varian({{ $var->id }})">
              <div class="card shadow-ss">
                <div class="card-body" style="padding: 0.5px;">
                   <img id="var_{{ $var->id }}" class="vars" style="{{ $notselect  }}" width="100%" src="{{ asset('assets/img_post/') }}/{{ $var->img }}">
                </div>
              </div>
            </div>

         @endforeach
        </div>
        @endif

        <!-- =========== END VARIAN ========= -->

        <!-- ======= TOKO ======= -->
        <hr>
          <table width="100%" >
            <tr>
              <td rowspan="3" width="30%"><img class="shadow-ss" width="100%" src="/assets/img_company/{{ $postnews->photo }}"></td>
              <td width="5%"></td>
              <td style="font-size: 16px;"><a href="#"><b style="color: #1d8ee5;">{{ $postnews->wilayah_name }}</b></a></td>
            </tr>
            <tr>
              <td></td>
              <td><h6>{{ $postnews->alamat }}</h6></td>
            </tr>
            <tr>
              <td></td>
              <td><span class="badge badge-pill badge-success">{{ $postnews->regency_name }}</span></td>
            </tr>
            
          </table>
          <br>
          @php
            $ada = DB::table('follow')
            ->where([
              ['wilayah_id', '=', $postnews->wilayah_id],
              ['user_id', '=', $userid],
            ])
            ->first();
          @endphp
          <table width="100%">
            <tr align="center">
              <td>
                @if(!$ada)
                  @if($tour->detailprod != '1')
                  <button onclick="Follow({{ $postnews->wilayah_id }})" class="btn btn-kuning btn-sm btn-block pop" type="button" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Follow Toko ini disini"><i class="fa fa-plus"></i> Follow</button>
                  @else
                  <button onclick="Follow({{ $postnews->wilayah_id }})" class="btn btn-kuning btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Follow</button>
                  @endif
                @else
                  <button onclick="Unfollow({{ $postnews->wilayah_id }})" class="btn btn-danger btn-sm btn-block" type="button"><i class="fa fa-minus"></i> Unfollow</button>
                @endif
              </td>
              
            </tr>
          </table>
        <hr>


        <!-- ==== Produk Detail ===== -->
        <div id="produkdetails" class="contentmenu" style="display: block;">
          
          <div align="justify" style="font-size: 12px;">{{ $postnews->desc }}</div><hr>

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
                        barang ini hanya bisa di ambil/reedem di <b>{{ $postnews->wilayah_name }}</b>, {{ $postnews->alamat }} - {{ $postnews->regency_name }}
                      </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>

            
        </div>
        <!-- ==== End Of Product Detail ===== -->

      </div>
    </div>
  </div>    
</div>

@include('content.home.users.modal')
@include('bazaar.layouts.footer')
@include('script.userdetails')

<script type="text/javascript">

  async function onShare() {
    const title = document.title;
    const url = document.querySelector("link[rel=canonical]")
      ? document.querySelector("link[rel=canonical]").href
      : document.location.href;
    const text = "Promo Menarik Lainnya di Tomxperience.id yuk!";
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


  function Varian(id){

    var service = $('#serv').val();

    $.ajax({
      type: 'GET',
      url: "{{ route('product.varian') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
      },
      success: function(data) {

        var persen = parseFloat(service) / 100;
        var tambahan = parseInt(data.harga_act) * persen;
        var total = parseInt(data.harga_act) + tambahan;

        var number_string = total.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#harga').html('Rp. '+rupiah);

        var tambahan2 = parseInt(data.harga_crt) * persen;
        var total2 = parseInt(data.harga_crt) + tambahan;

        var number_string2 = total2.toString(),
          sisa  = number_string2.length % 3,
          rupiah2  = number_string2.substr(0, sisa),
          ribuan  = number_string2.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah2 += separator + ribuan.join('.');
        }

        $('#coret').html('Rp. '+rupiah2);

        $('.vars').attr("style","opacity: 0.6;");
        $('#var_'+id).attr("style","");

        $('#beli').attr("onclick", "Beli("+id+")");

        $('#text').html(data.name);

        $('#imgpost').attr("src","/assets/img_post/"+data.img);

      }

    });
  }

</script>
      
</body>

</html>