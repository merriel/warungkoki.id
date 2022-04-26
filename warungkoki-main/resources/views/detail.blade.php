@include('layout.headbelumlogin')
<style type="text/css">
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
    z-index: 1;
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
    top: 17px; 
    right: -29px; 
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
</style>
<body class="">
<div class="main-content">
    <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
  <!-- Card stats -->
  <table width="100%">
    <tr>
      <td width="10%">
        <i style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-chevron-left" onclick="history.back()"></i>
      </td>
      <td align="right">
        <div>
          
          &nbsp;&nbsp;&nbsp;
            <i onclick="onShare()" style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-share"></i>
        </div>
      </td>
    </tr>
  </table>
  <br>

<div class="row">
  <div class="col-12">
    <div class="card shadow-sm">
      @if($postnews->harga_crt != NULL)
        <div class="ribbon red"><span>HOT DEALS</span></div>
      @endif
      <!-- @if(strtotime(date('H:i')) >= strtotime($toko->jam_masuk) && strtotime(date('H:i')) <= strtotime($toko->jam_tutup))
      @else
        <div class="type">
          <span class="badge badge-pill badge-danger">TOKO TUTUP!</span>
        </div>
      @endif  -->
      <div class="gambar">
          @if($postnews->harga_crt == null)
            <img class="card-img-top" id="imgpost" src="{{ asset('assets/img_post/') }}/{{ $postnews->prod_img }}" alt="Card image cap">
          @else
            <img class="card-img-top" id="imgpost" src="{{ asset('assets/img_post/') }}/{{ $postnews->img }}" alt="Card image cap">
          @endif
        
      </div>
        
      <div class="card-body">
        <table width="100%">
          <tr>
            <td align="left">
              <div style="font-size: 16px; color: black;padding-bottom: 10px;"> <b>{{ $postnews->prod_name }}</b> <b id="text">{{ $postnews->name }}</b></div>
            </td>
          </tr>
        </table>

       <div class="row">
          <div class="col-12" style="padding-bottom:0px;">
            @if($postnews->harga_crt != NULL)
              @if($postnews->harga_act > $postnews->harga_crt)
                <div style="color: black;font-size: 11px;">
                  &nbsp;
                </div>
              @else
                <div id="coretnya" style="text-decoration:line-through;color: black;font-size: 11px;">{{ rupiah($postnews->harga_crt) }} &nbsp;&nbsp;
                  <span style="color:black;font-size: 100%;font-weight: 1000" class="badge badge-pill badge-danger" id="persen">{{ round((($postnews->harga_act - $postnews->harga_crt) / $postnews->harga_crt) * 100) }}%</span>
                </div>
              @endif
            @else
            &nbsp;
            @endif
          </div>
        </div>
        <table width="100%">
          <tr>
            <td align="left">
              <!-- <h2 style="color: #fb6340;"><b id="harga">{{ rupiah($postnews->harga_act) }}</b></h2> -->
              <h2 style="color: #fb6340;"><b id="harga">{{ rupiah($postnews->harga_act) }}</b></h2>

              @if($postnews->min_qty != NULL)
              <div style="font-size:10px;" id="min"><i>Minimal Pembelian {{ $postnews->min_qty }} Karung</i></div>
              @endif
            </td>
            <td align="right" width="35%">
              <a href="/login" class="menusxx"><button class="btn btn-block btn-kuning" id="beli" type="button">BELI</button></a>
            <input type="hidden" id="prods" value="{{ $postnews->id }}">
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
            ['posts.type', '=', 'Products'],
          ])
          ->get();

        @endphp

        @if($varian->count() > 1)
        <hr>
        <h5><b>Pilih Ukuran Produk / Varian Rasa :</b></h5>
        <div class="row" style="padding-top: 12px;">
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
              <div style="padding-bottom:10px;padding-top: 10px;font-size: 11px;" align="center">{{ $var->name }}</div>
            </div>

         @endforeach
        </div>
        @endif

        <!-- =========== END VARIAN ========= -->

        <!-- ======= TOKO ======= -->
        <hr>
          <table width="100%" >
            <tr>
              <td rowspan="3" width="20%"><img class="shadow-ss" width="100%" src="/assets/icon/512x512.png"></td>
              <td width="5%"></td>
              <td style="font-size: 16px;"><a href="#"><b style="color: #1d8ee5;">{{ $postnews->wilayah_name }}</b></a></td>
            </tr>
            <tr>
              <td></td>
              <td><h6>{{ $postnews->alamat }}</h6></td>
            </tr>
            
          </table>
          <br>
          
        <hr>

        <!-- ======== END TOKO ========= -->
        

        <!-- ==== Produk Detail ===== -->
        <div id="produkdetails" class="contentmenu" style="display: block;">
          
          @if($postnews->desc != null)
          <div align="justify" style="font-size: 12px;">{!! $postnews->desc !!}</div><hr>
          @endif

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
        </div>

      </div>
    </div>
  </div>    
</div>

@include('content.home.users.modal')
@include('layout.footerbelumlogin')
@include('script.userdetails')

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
        var total = parseInt(data.harga_act);

        var number_string = total.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('.vars').attr("style","opacity: 0.6;");
        $('#var_'+id).attr("style","");

        $('#beli').attr("onclick", "Beli("+id+")");

        $('#harga').html('Rp. '+rupiah);

        $('#text').html(data.name);

        $('#imgpost').attr("src","/assets/img_post/"+data.img);
      

        if(data.harga_crt != null){

          $('#min').html('<i>Minimal Pembelian '+data.min_qty+ ' Karung</i>');

          var persen =  parseInt(data.harga_act) - parseInt(data.harga_crt);
          var jumlah = (persen / parseInt(data.harga_crt)) * 100;

          $('#coretnya').attr("style", "display:block;text-decoration:line-through;color: black;font-size: 11px;");

          $('#persen').html(Math.round(jumlah)+'%');

        } else {

          $('#coretnya').attr("style", "display:none;text-decoration:line-through;color: black;font-size: 11px;");
          $('#min').html('');

        }

      }

    });
  }


</script>
      
</body>

</html>