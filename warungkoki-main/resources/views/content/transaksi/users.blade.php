@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="row">
        <div class="col">
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Transaksi Anda</h1>
            </div>
            <hr>
            
            <div id="content-in">
              @if($sum == '0')
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
                <a href="/users/transaksi/detail?uuid={{ $transaksin->uuid }}"><div class="card shadow-ss menusxx">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td width="25%" rowspan="4">
                            <div class="icon icon-shape bg-iolo text-white rounded-circle shadow-ss">
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
                                <div style="font-size: 13px;color: black;">
                                  @if($transaksin->type_bayar == 'Saldo Reedem Poin')
                                  <b>{{ date('d M Y', strtotime($transaksin->created_at)) }} | {{ $barang ? round($barang->amount) : 0 }} <img width="25px;" src="/assets/content/img/icons/padi.png"></b><br>
                                  @elseif($transaksin->undian_name != NULL)
                                   <div style="font-size: 10px;color: black;">Pengambilan Hadiah dari Undian {{ $transaksin->undian_name  }}</div>
                                  @else
                                  <b>{{ date('d M Y', strtotime($transaksin->created_at)) }} | Rp. {{ $barang ?  number_format($barang->amount,0,',','.') : '' }}</b><br>
                                  @endif

                                  @if($transaksin->undian_name == NULL)
                                    <div style="font-size: 10px;color: black;">Transaksi ini mengandung {{ $detailcounts }} barang</div>
                                  @endif
                                  </div>
                                  @if($transaksin->alamat_id != null)
                                    @if($transaksin->status == "BELUM BAYAR" || $transaksin->status == "NOT APPROVED" || $transaksin->status == "KADALUARSA")
                                    @else
                                      <div style="font-size: 10px;color: black;">Status pengiriman : <b>
                                        @if($transaksin->status == "DIPROSES" || $transaksin->status == "CONFIRMED" || $transaksin->status == "ALLOCATED")
                                        SEDANG DIPROSES
                                        @elseif($transaksin->status == "PICKING_UP" || $transaksin->status == "PICKED")
                                        PROSES PENJEMPUTAN
                                        @elseif($transaksin->status == "DROPPING_OFF")
                                        PROSES PENGANTARAN
                                        @elseif($transaksin->status == "CANCEL" || $transaksin->status == "CANCELLED")
                                        PENGIRIMAN DIBATALKAN
                                        @else
                                        PENGIRIMAN SELESAI
                                        @endif
                                      </b></div>
                                    </div>
                                    @endif
                                  @endif

                              </td>
                            </tr>

                        <tr>
                          <td>
                              @if($transaksin->status == "BELUM BAYAR")
                                <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> BELUM BAYAR</span>
                              @elseif($transaksin->status == "KADALUARSA")
                                <span class="badge badge-danger"><i class="fa fa-times"></i> KADALUARSA</span>
							                @elseif($transaksin->status == "NOT APPROVED")
                                <span class="badge badge-danger"><i class="fa fa-times"></i> BELUM BAYAR</span>
                              @elseif($transaksin->status == "REEDEM")
                                <span class="badge badge-info"><i class="fa fa-clock"></i> PROSES REEDEM</span>
                              @elseif($transaksin->status == "PENDING")
                                <span class="badge badge-info"><i class="fa fa-clock"></i> MENUNGGU PERSETUJUAN PETUGAS</span> 
                              @elseif($transaksin->undian_name != NULL)
                                <span class="badge badge-success"><i class="fa fa-check"></i> AMBIL HADIAH</span>
                              @else
                                <span class="badge badge-success"><i class="fa fa-check"></i> SELESAI BAYAR</span>
                              @endif

                              <!-- ==== TYPE PEMBELIAN ===== -->

                              @if($transaksin->alamat_id == null)
                                <span class="badge badge-info"><i class="fa fa-box"></i> Ambi di Lokasi</span>
                              @else
                                <span class="badge badge-primary"><i class="fa fa-motorcycle"></i> Delivery</span>
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
  @include('content.transaksi.modal')
  @include('layout.footer')

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

      $('#beli').attr("class","card shadow bg-iolo");
      $('#reedem').attr("class","card shadow");

      $('#textbeli').attr("class","text-white");
      $('#textreedem').attr("class","");

      $('#iconbeli').attr("style","color: #fff;font-size: 32px;");
      $('#iconreedem').attr("style","color: #8a5d3b;font-size: 32px;");

      $('#content-in').attr("style","display: block;");
      $('#content-out').attr("style","display: none;");

    }

    function Reedem(){

      $('#reedem').attr("class","card shadow bg-iolo");
      $('#beli').attr("class","card shadow");

      $('#textreedem').attr("class","text-white");
      $('#textbeli').attr("class","");

      $('#iconreedem').attr("style","color: #fff;font-size: 32px;");
      $('#iconbeli').attr("style","color: #8a5d3b;font-size: 32px;");

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