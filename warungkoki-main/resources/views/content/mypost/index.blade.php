@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          @if($user->role_id == 5)
          <a href="/outlet"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          @else
          <a href="/principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          @endif
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">My Post</h1>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="card bg-iolo-blue shadow" id="dealss" onclick="Deals();">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td align="center"><i class="fa fa-handshake" id="icondeals" style="font-size: 30px; color: #ffffff"></i></td>
                  </tr>
                  <tr>
                    <td height="7px"></td>
                  </tr>
                  <tr>
                    <td align="center"><h6 id="textdeals" class="text-white"><b>Deals</b></h6></td>
                  </tr>
                </table>
              </div>
          </div>
        </div>
        <div class="col-4" style="padding-left: 0px;">
          <div class="card shadow" id="challangess" onclick="Challanges();">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td align="center"><i class="fa fa-gamepad" id="iconchallanges" style="font-size: 30px; color: #01497f"></i></td>
                  </tr>
                  <tr>
                    <td height="7px"></td>
                  </tr>
                  <tr>
                    <td align="center"><h6 id="textchallenges"><b>Challanges</b></h6></td>
                  </tr>
                </table>
              </div>
          </div>
        </div>

        <div class="col-4" style="padding-left: 0px;">
          <div class="card shadow" id="produk" onclick="Produk();">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td align="center"><i class="fa fa-coffee" id="iconproduk" style="font-size: 30px; color: #01497f"></i></td>
                  </tr>
                  <tr>
                    <td height="7px"></td>
                  </tr>
                  <tr>
                    <td align="center"><h6 id="textproduk"><b>Produk</b></h6></td>
                  </tr>
                </table>
              </div>
          </div>
        </div>

      </div>

      <hr>
      <div id="content-deals" style="display: block;">

        @if($getpostdeals->count() == '0')
          <div class="card shadow">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td><h6>Belum ada Posting Apapun pada Tab ini!</h6></td>
              </tr>
            </table>
          </div>
        </div>
        @else
        @foreach($getpostdeals as $deals)

        <div class="card shadow">
          <div class="card-body" id="bukadeal_{{ $deals->id }}" onclick="BukaDeal({{ $deals->id }});">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="3">
                  <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/assets/img_post/{{ $deals->img_name }}">
                  </a>
                </td>
                <td><b><div style="font-size: 17px">{{ $deals->name }}</div></b></td>
              </tr>
              <tr>
                <td>
                  <h6>{{ date('d M Y', strtotime($deals->dari)) }} - {{ date('d M Y', strtotime($deals->sampai)) }} | {{ rupiah($deals->harga_act) }}</h6>
                  @if($deals->active == 'N')
                    <div style="font-size: 10px;color: red;">
                      <i>Produk ini tidak aktif atau stock tidak ada</i>
                    </div>
                  @endif
                </td>
              </tr>
            </table>
          </div>
          <div id="deal_{{ $deals->id }}" style="display: none;">
            <hr>
            <div class="row">
              <div class="col-12" align="center">
                <table width="100%">
                  <tr>
                    <td align="center">
                      <a href="/mypost/edit?id={{ $deals->id }}"><button class="btn btn-sm btn-info menusxx">Edit </button></a>&nbsp;&nbsp;
                      <button class="btn btn-sm btn-danger" onclick="Hapus({{ $deals->id }})">Hapus </button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br>

        @endforeach

        @endif
      </div>

      <div id="content-challanges" style="display: none;">
        @if($getpostchallanges->count() == '0')
          <div class="card shadow">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td><h6>Belum ada Posting Apapun pada Tab ini!</h6></td>
              </tr>
            </table>
          </div>
        </div>
        @else
        @foreach($getpostchallanges as $challanges)

        <div class="card shadow">
          <div class="card-body" id="bukachallange_{{ $challanges->id }}" onclick="BukaChallange({{ $challanges->id }});">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="3">
                  <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/assets/img_post/{{ $challanges->img_name }}">
                  </a>
                </td>
                <td><b><div style="font-size: 17px">{{ $challanges->name }}</div></b></td>
              </tr>
              <tr>
                <td>
                  <h6>{{ date('d M Y', strtotime($challanges->dari)) }} - {{ date('d M Y', strtotime($challanges->sampai)) }} </h6>
                  @if($challanges->active == 'N')
                    <div style="font-size: 10px;color: red;">
                      <i>Produk ini tidak aktif atau stock tidak ada</i>
                    </div>
                  @endif
                </td>
              </tr>
            </table>
          </div>
          <div id="challange_{{ $challanges->id }}" style="display: none;">
            <hr>
            <div class="row">
              <div class="col-12" align="center">
                <table width="100%">
                  <tr>
                    <td align="center">
                      <a href="/mypost/edit?id={{ $challanges->id }}"><button class="btn btn-sm btn-info menusxx">Edit </button></a>&nbsp;&nbsp;
                      <button class="btn btn-sm btn-danger" onclick="Hapus({{ $challanges->id }})">Hapus </button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <br>

        @endforeach
        @endif
      </div>

      <div id="content-product" style="display: none;">
        @if($getpostproducts->count() == '0')
          <div class="card shadow">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td><h6>Belum ada Posting Apapun pada Tab ini!</h6></td>
              </tr>
            </table>
          </div>
        </div>
        @else
        @foreach($getpostproducts as $product)

        <div class="card shadow">
          <div class="card-body" id="bukaproduct_{{ $product->id }}" onclick="BukaProduct({{ $product->id }});">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="3">
                  <a href="#" class="avatar rounded-circle mr-3">
                    <img alt="Image placeholder" src="/assets/img_post/{{ $product->img_name }}">
                  </a>
                </td>
                <td><b><div style="font-size: 17px">{{ $product->name }}</div></b></td>
              </tr>
              <tr>
                <td>
                  <h6>{{ rupiah($product->harga_act) }} </h6>
                  @if($product->active == 'N')
                    <div style="font-size: 10px;color: red;">
                      <i>Produk ini tidak aktif atau stock tidak ada</i>
                    </div>
                  @endif
                </td>
              </tr>
            </table>
          </div>
          <div id="product_{{ $product->id }}" style="display: none;">
            <hr>
            <div class="row">
              <div class="col-12" align="center">
                <table width="100%">
                  <tr>
                    <td align="center">
                      <a href="/mypost/edit?id={{ $product->id }}"><button class="btn btn-sm btn-info menusxx">Edit </button></a>&nbsp;&nbsp;
                      <button class="btn btn-sm btn-danger" onclick="Hapus({{ $product->id }})">Hapus </button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br>

        @endforeach
        @endif
      </div>
    </div>

  </div>
      @include('content.mypost.modal')
      @include('layout.footer')
      @include('script.mypost')

      <script type="text/javascript">
        
        function Deals(){

          $("#content-deals").attr("style","display: block;");
          $("#content-challanges").attr("style","display: none;");
          $("#content-product").attr("style","display: none;");

          $("#dealss").attr("class","card bg-iolo-blue shadow");
          $("#challangess").attr("class","card shadow");
          $("#produk").attr("class","card shadow");

          $("#textchallenges").attr("class","");
          $("#textproduk").attr("class","");
          $("#textdeals").attr("class","text-white");

          $("#icondeals").attr("style","font-size: 30px; color: #ffffff;");
          $("#iconchallanges").attr("style","font-size: 30px; color: #01497f;");
          $("#iconproduk").attr("style","font-size: 30px; color: #01497f;");


        }

        function Challanges(){

          $("#content-deals").attr("style","display: none;");
          $("#content-product").attr("style","display: none;");
          $("#content-challanges").attr("style","display: block;");

          $("#dealss").attr("class","card shadow");
          $("#produk").attr("class","card shadow");
          $("#challangess").attr("class","card bg-iolo-blue shadow");

          $("#textchallenges").attr("class","text-white");
          $("#textdeals").attr("class","");
          $("#textproduk").attr("class","");

          $("#icondeals").attr("style","font-size: 30px; color: #01497f;");
          $("#iconproduk").attr("style","font-size: 30px; color: #01497f;");
          $("#iconchallanges").attr("style","font-size: 30px; color: #ffffff;");

        }

        function Produk(){

          $("#content-deals").attr("style","display: none;");
          $("#content-challanges").attr("style","display: none;");
          $("#content-product").attr("style","display: block;");

          $("#dealss").attr("class","card shadow");
          $("#challangess").attr("class","card shadow");
          $("#produk").attr("class","card bg-iolo-blue shadow");


          $("#textproduk").attr("class","text-white");
          $("#textdeals").attr("class","");
          $("#textchallenges").attr("class","");

          $("#iconchallanges").attr("style","font-size: 30px; color: #01497f;");
          $("#icondeals").attr("style","font-size: 30px; color: #01497f;");
          $("#iconproduk").attr("style","font-size: 30px; color: #ffffff;");

        }

        function BukaChallange(id){

            $('#challange_'+id).attr("style","display: block");
            $('#bukachallange_'+id).attr("onclick","CloseChallange("+id+")");

        }

        function CloseChallange(id){

            $('#challange_'+id).attr("style","display: none");
            $('#bukachallange_'+id).attr("onclick","BukaChallange("+id+")");

        }

        function BukaDeal(id){

            $('#deal_'+id).attr("style","display: block");
            $('#bukadeal_'+id).attr("onclick","CloseDeal("+id+")");

        }

        function CloseDeal(id){

            $('#deal_'+id).attr("style","display: none");
            $('#bukadeal_'+id).attr("onclick","BukaDeal("+id+")");

        }

        function BukaProduct(id){

            $('#product_'+id).attr("style","display: block");
            $('#bukaproduct_'+id).attr("onclick","CloseProduct("+id+")");

        }

        function CloseProduct(id){

            $('#product_'+id).attr("style","display: none");
            $('#bukaproduct_'+id).attr("onclick","BukaProduct("+id+")");

        }

        function Hapus(id){

          $('#ids').val(id);
          $('#hapuspost').modal('show');
        }

        $(document).on('click', '#hapusnow', function() {

            $('#hapuspost').modal('hide');
            $('.loading').attr('style','display: block');

            $.ajax({
               type: 'POST',
               url: "{{ route('hapuspost') }}",
               data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('#ids').val()
                },
               success: function(data) {

                  swal("Data berhasil terhapus!", {
                       icon: "success",
                       buttons: false,
                       timer: 2000,
                  });
                  setTimeout(function(){ window.location.reload() }, 1500);
               }
           });


        });

      </script>

</body>

</html>