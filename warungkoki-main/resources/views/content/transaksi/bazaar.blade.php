@include('bazaar.layouts.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5.5rem;">
      <div class="row">
        <div class="col">
          <!-- <table width="100%">
            <tr>
              <td align="left">
                <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Back</button></a>
              </td>
              <td align="left">
                <button type="button" onclick="Download()" class='btn btn-sm btn-info'><i class="fa fa-download"></i> Download</button>
              </td>
            </tr>
          </table> -->
          <table width="100%">
            <tr>
              <td width="10%">
                <a href="/bazaar/home"><i style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-chevron-left"></i></a>
              </td>
            </tr>
          </table>
          
            <div class="ct-page-title" style="border-left: 2px solid #c34468">
              <h1 class="ct-title" id="content">Transaksi Bazaar</h1>
            </div>
            <div class="row">
              <div class="col-6" style="padding-right: 7.5px;">
                @if($tour->transaksi != 1)
                <div id="beli" class="card shadow-ss bg-bazaar pop" onclick="Pembelian();" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Lihat Transaksi Pembelian Anda disini">
                @else
                <div id="beli" class="card shadow-ss bg-bazaar" onclick="Pembelian();">
                @endif
                  <div class="card-body" style="padding-right: 13px; padding-left: 13px;">
                    <table width="100%">
                      <tr>
                        <td align="left">
                          <i class="fas fa-shopping-basket" id="iconbeli" style="color: #fff;font-size: 32px;"></i>
                        </td>
                        <td width="12px"></td>
                        <td align="right"><div style="font-size: 12px" id="textbeli" class="text-white"><b>Transaksi Pembelian</b></div></td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-6" style="padding-left: 7.5px;">
                @if($tour->transaksi != 1)
                <div id="reedem" class="card shadow-ss pop" onclick="Reedem();" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Lihat Transaksi Pengambilan Pesanan Anda disini">
                @else
                <div id="reedem" class="card shadow-ss" onclick="Reedem();">
                @endif
                  <div class="card-body" style="padding-right: 13px; padding-left: 13px;">
                    <table width="100%">
                      <tr> 
                        <td align="left"><div id="textreedem" style="font-size: 12px"><b>Transaksi Ambil</b></div></td>
                        <td width="12px"></td>
                        <td align="right">
                          <i class="fas fa-handshake" id="iconreedem" style="color: #c34468;font-size: 32px;"></i>
                        </td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <hr>

            <div id="content-in">
                @if($sumin == '0')
                <div class="card shadow-ss">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td><h6>Belum ada Transaksi Pembelian Apapun pada Saat ini!</h6></td>
                      </tr>
                    </table>
                  </div>
                </div>
              @else
                @foreach($transaksins as $transaksin)
                <!-- @php

                  $barang = DB::table('transaction_details')
                  ->select("posts.name","transactions.created_at","orders.amount","orders.type_bayar","product.name as prod_name")
                  ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                  ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                  ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                  ->leftJoin("product", "posts.product_id", "=", "product.id")
                  ->where("transactions.id", $transaksin->id)
                  ->first();

                @endphp
 -->
                <a href="/bazaar/transaksi/detail?uuid={{ $transaksin->uuid }}"><div class="card shadow-ss menusxx">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td width="25%" rowspan="4">
                            <div class="icon icon-shape bg-bazaar text-white rounded-circle shadow-ss">
                              <i class="fas fa-shopping-basket" style="color: #ffffff"></i>
                          </div>
                          </td>
                          <td><b><div style="font-size: 17px"></div></b></td>
                        </tr>

                            @php

                              $barang = DB::table('transaction_details')
                              ->select("posts.name","transactions.created_at","orders.amount","orders.type_bayar","wilayah.name as wilayah_name")
                              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                              ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                              ->leftJoin("users", "posts.user_id", "=", "users.id")
                              ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                              ->where("transactions.id", $transaksin->id)
                              ->first();

                              if($barang->type_bayar == "CASH"){
                                $btns = 'primary';
                                $icons = 'gift';
                              } else {
                                $btns = 'info';
                                $icons = 'laptop';
                              }

                              $details = DB::table('transaction_details')
                              ->select("posts.name","product.name as prod_name")
                              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                              ->leftJoin("product", "posts.product_id", "=", "product.id")
                              ->distinct()
                              ->where("transactions.id", $transaksin->id)
                              ->limit(2)
                              ->get();

                              $detailcounts = DB::table('transaction_details')
                              ->select("posts.name","product.name as prod_name")
                              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                              ->leftJoin("product", "posts.product_id", "=", "product.id")
                              ->distinct()
                              ->where("transactions.id", $transaksin->id)
                              ->count();


                            @endphp
                            <tr>
                              <td>
                                <div class="text-warning" style="font-size: 14px; color: black;">
                                  <b>@foreach($details as $detail) {{ $detail->prod_name }} {{ $detail->name }}, @endforeach</b>
                                  @if($detailcounts > 2)
                                  <b style="color: black; font-size: 11px;">+ {{ $detailcounts - 2 }} Produk</b>
                                  @endif
                                </div>
                                
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div style="font-size: 13px;color: black;padding-bottom: 3px;">
                                  <b>{{ date('d M Y', strtotime($transaksin->created_at)) }} | Rp. {{ $barang ?  number_format($barang->amount,0,',','.') : '' }}</b><br>
                                  <!-- @if($barang->type_bayar == "CASH")
                                  <div style="font-size: 10px;">Pembayaran CASH ini harus dilakukan pada Outlet <b>{{ $barang->wilayah_name }}</b></div>
                                  @endif -->
                                  <div style="font-size: 10px;color: black;">Transaksi ini mengandung {{ $detailcounts }} barang</div>
                                  </div>

                              </td>
                            </tr>

                        <tr>
                          <td>
                              @if($transaksin->status == "NOT APPROVED")
                                <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> BELUM BAYAR</span>
                              @elseif($transaksin->status == "KADALUARSA")
                                <span class="badge badge-danger"><i class="fa fa-times"></i> KADALUARSA</span>
                              @else
                                <span class="badge badge-success"><i class="fa fa-check"></i> SELESAI BAYAR</span>
                              @endif

                              <!-- <span class="badge badge-{{ $btns }}"><i class="fa fa-{{ $icons }}"></i> BAYAR {{ $barang->type_bayar }}</span> -->
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </a>
                <br>
                @endforeach


              @endif
            </div>

            <div id="content-out" style="display: none;">

              <!-- <div class="row" >
                <div class="col-12">
                  <div class="card shadow-ss bg-iolo">
                    <div class="card-body" style="padding-bottom: 1rem;padding-top: 1rem;">
                      <div class="row">
                        <div class="col-12" style="padding-bottom: 0px;">
                          <table width="100%">
                            <tr>
                              <td align="left">
                                <button onclick="Reedems();" id="reedems" class="btn btn-sm btn-success reedemx" style="padding-bottom: 0.5rem; padding-top: 0.5rem;">
                                  <i class="fa fa-gift"></i>  Reedem
                                </button>
                                <button onclick="ReedemDelivery();" id="reedemdelivery" class="btn btn-sm btn-secondary reedemx" style="padding-bottom: 0.5rem; padding-top: 0.5rem;">
                                   <i class="fa fa-truck"></i>  Reedem Delivery
                                </button>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->

<!-- ===================REEDEM BIASA========================= --> 

              <div id="content-reedem" style="display: block;">
              @if($sumout == '0')
                <div class="card shadow-ss">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td><h6>Belum ada Transaksi Ambil Apapun pada Saat ini!</h6></td>
                      </tr>
                    </table>
                  </div>
                </div>
              @else
              
                @foreach($transaksouts as $transaksout)
                @php

                  $barang = DB::table('transaction_details')
                  ->select("product.name","transactions.created_at","transaction_details.qty as amount")
                  ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                  ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                  ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                  ->where("transactions.id", $transaksout->id)
                  ->first();

                @endphp

                <a href="/bazaar/transaksi/detail?uuid={{ $transaksout->uuid }}"><div class="card shadow-ss menusxx">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td width="25%" rowspan="4">
                            <div class="icon icon-shape bg-bazaar text-white rounded-circle shadow-ss">
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
                              ->where("transactions.id", $transaksout->id)
                              ->first();

                              
                              $details = DB::table('transaction_details')
                              ->select("posts.name","product.name as prod_name")
                              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                              ->leftJoin("product", "posts.product_id", "=", "product.id")
                              ->distinct()
                              ->where("transactions.id", $transaksout->id)
                              ->limit(2)
                              ->get();

                              $detailc = DB::table('transaction_details')
                              ->select("posts.name","product.name as prod_name")
                              ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                              ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                              ->leftJoin("product", "posts.product_id", "=", "product.id")
                              ->distinct()
                              ->where("transactions.id", $transaksout->id)
                              ->count();

                            @endphp
                            <tr>
                              <td>
                                <div class="text-warning" style="font-size: 14px; color: black;">
                                  <b>@foreach($details as $detail) {{ $detail->prod_name }} {{ $detail->name }}, @endforeach</b>
                                  @if($detailc > 2)
                                  <b style="color: black; font-size: 11px;">+ {{ $detailc - 2 }} Produk</b>
                                  @endif
                                </div>

                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div style="font-size: 13px;color: black;padding-bottom: 5px;">
                                  <b>{{ date('d M Y', strtotime($transaksout->created_at)) }} | {{ $detailc }} Barang</b><br>
                                  <div style="font-size: 10px;">Transaksi Ambil ini harus dilakukan pada Outlet <b>{{ $barang2 ? $barang2->wilayah_name : '' }}</b></div>
                                  @if($transaksout->ket != '' || $transaksout->ket != NULL)
                                    <div style="font-size: 10px;">Keterangan : <b>{{ $transaksout->ket }}</b></div>
                                  @endif
                                  @if($transaksout->plan != '' || $transaksout->plan != NULL)
                                    <div style="font-size: 10px;">Rencana Reedem : <b>{{ date('d F Y H:i', strtotime($transaksout->plan)) }}</b></div>
                                  @endif
                                </div>
                                
                              </td>
                            </tr>

                        <tr>
                          <td>
                              @if($transaksout->status == "REEDEM" || $transaksout->status == "REEDEMREWARD")
                                <span class="badge badge-warning"><i class="fa fa-exclamation-triangle"></i> BELUM REDEEM</span>
                              @elseif($transaksout->status == "KADALUARSA")
                                <span class="badge badge-danger"><i class="fa fa-times"></i> KADALUARSA</span>
                              @else
                                <span class="badge badge-success"><i class="fa fa-check"></i> SELESAI REDEEM</span>
                              @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </a>
                <br>
                @endforeach

                @endif
              </div>
            </div>
        </div> 
      </div> 
    </div>
  </div>
  @include('content.transaksi.modal')
  @include('bazaar.layouts.footer')

  <script type="text/javascript">
    function TidakLihat(){

      swal("Transaksi ini Sudah Selesai!", {
           icon: "warning",
           buttons: false,
           timer: 2000,
      });

    }

    function LihatTransaksi(id){

      setTimeout(function(){ $('.loading').attr('style','display: block'); }, 1000);

      $.ajax({
        type: 'POST',
        url: "{{ route('gettransaksi') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          $('#img_barcode').html("<img width='100%' alt='barcode' src='https://iolosmart.com/assets/barcode/barcode.php?codetype=Code128&size=85&text="+data.uuid+"'><br> <div style='padding-top: 15px;font-size: 15px;' align='center'><u><b>"+data.uuid+"</b></u></div>");
          
          $('.loading').attr('style','display: none');
          $('#barcode').modal({backdrop: 'static', keyboard: false});
          $('#barcode').modal('show');

        }
      });
    }

    function Pembelian(){

      $('#beli').attr("class","card shadow bg-bazaar");
      $('#reedem').attr("class","card shadow");

      $('#textbeli').attr("class","text-white");
      $('#textreedem').attr("class","");

      $('#iconbeli').attr("style","color: #fff;font-size: 32px;");
      $('#iconreedem').attr("style","color: #c34468;font-size: 32px;");

      $('#content-in').attr("style","display: block;");
      $('#content-out').attr("style","display: none;");

    }

    function Reedem(){

      $('#reedem').attr("class","card shadow bg-bazaar");
      $('#beli').attr("class","card shadow");

      $('#textreedem').attr("class","text-white");
      $('#textbeli').attr("class","");

      $('#iconreedem').attr("style","color: #fff;font-size: 32px;");
      $('#iconbeli').attr("style","color: #c34468;font-size: 32px;");

      $('#content-in').attr("style","display: none;");
      $('#content-out').attr("style","display: block;");

    }

    function Download(){

      $('#download').modal('show');

    }

    $('#downloaddata').on('click', function () {

        swal("Transaksi Berhasil di Download!", {
             icon: "success",
             buttons: false,
             timer: 2000,
        });

        $('#download').modal('hide');

        var dari = $('#daritanggal').val();
        var sampai = $('#sampaitanggal').val();
        var type = $('#type').val();


        setTimeout(function(){ window.location.href = '/users/transaksi/printexcel?dari='+dari+'&sampai='+sampai+'&type='+type+''; }, 500);

    });

    function Reedems(){

      $('.reedemx').attr("class","btn btn-sm btn-secondary reedemx");

      $('#reedems').attr("class","btn btn-sm btn-success reedemx"); 
      $('#content-reedem').attr("style","display: block;");
      $('#content-deliver').attr("style","display: none;");

    }

    function ReedemDelivery(){

      $('.reedemx').attr("class","btn btn-sm btn-secondary reedemx");

      $('#reedemdelivery').attr("class","btn btn-sm btn-success reedemx"); 
      $('#content-reedem').attr("style","display: none;");
      $('#content-deliver').attr("style","display: block;");

    }

  </script>

</body>

</html>