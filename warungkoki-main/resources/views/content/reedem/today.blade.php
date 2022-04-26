@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Transaksi Reedem</h1>
      </div>

      <!-- Card stats -->

      <div style="font-size: 14px;"><b>Transaksi Pembelian :</b></div><hr>
      @if($transs->count() == '0')
        <div class="card shadow-ss">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td><h6>Belum ada Transaksi Reedem Apapun untuk saat ini!</h6></td>
              </tr>
            </table>
          </div>
        </div>
        <br>
      @else
      
      @foreach($transs as $trans)
      <div class="card shadow-ss">
        <div class="card-body">
          <table width="100%" border="0">
            <tr>
              <td width="25%" rowspan="4">
                <div class="icon icon-shape bg-iolo text-white rounded-circle shadow">
                  <i class="fas fa-handshake" style="color: #ffffff"></i>
              </div>
              </td>
              <td><b><div style="font-size: 17px"></div></b></td>
            </tr>

                @php

                  $users = DB::table('transactions')
                  ->select("users.*")
                  ->leftJoin("users", "transactions.user_id", "=", "users.id")
                  ->where("transactions.id", $trans->id)
                  ->first();

                  $details = DB::table('transaction_details')
                  ->select("product.name","transaction_details.qty","posts.name as post_name")
                  ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                  ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                  ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                  ->distinct()
                  ->where("transactions.id", $trans->id)
                  ->get();

                @endphp
                <tr>
                  <td>
                    <div style="font-size: 13px;color: black;padding-bottom: 5px;">
                      <b>{{ date('d M Y', strtotime($trans->created_at)) }} | {{ $details->count() }} Produk</b><br>
                      @if($trans->ket != '' || $trans->ket != NULL)
                        <div style="font-size: 10px;">Keterangan : <b>{{ $trans->ket }}</b></div>
                      @endif
                      @if($trans->plan != '' || $trans->plan != NULL)
                        <div style="font-size: 10px;">Rencana Reedem : <b>{{ date('d F Y H:i', strtotime($trans->plan)) }}</b></div>
                      @endif
                    </div>
                    
                  </td>
                </tr>

            <tr>
              <td>
                    <span class="badge badge-success"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $users->name }}</span>  
              </td>
            </tr>
          </table>
          <hr>
          <table id="customers" width="100%">
            <tr>
              <th>Produk</th>
              <th width="10%">Qty</th>
            </tr>
            @foreach($details as $detail)
            <tr>
              <td style="color: black;">{{ $detail->name }} {{ $detail->post_name }}</td>
              <td style="color: black;">{{ $detail->qty }}</td>
            </tr>
            @endforeach
          </table>
          @if($trans->ready != 'yes')
          <hr>
          <button class="btn btn-info btn-sm btn-block" onclick="Siapkan({{ $trans->id }});"> Sudah Disiapkan</button>
          @else
          <hr>
          <div class="text-success" align="center"><b>Barang sudah READY, Siap untuk Diambil</b></div>
          <br>
          @endif
          <button class="btn btn-success btn-sm btn-block" onclick="Selesai({{ $trans->id }});"><i class="fa fa-check"></i>&nbsp; Selesaikan Transaksi</button>
        </div>
      </div>

      <br>
      @endforeach

      @endif

      <!-- ====== DELIVERY ===== -->

      <div style="font-size: 14px;"><b>Transaksi Delivery :</b></div><hr>
      @if($deliverys->count() == '0')
      <div class="card shadow-ss">
        <div class="card-body">
          <table width="100%" border="0">
            <tr>
              <td><h6>Belum ada Transaksi Delivery Apapun pada Saat ini!</h6></td>
            </tr>
          </table>
        </div>
      </div>
    @else
      @foreach($deliverys as $trans)

      <a href="/xhome/petugas/detail?uuid={{ $trans->uuid }}"><div class="card shadow-ss menusxx">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="4">
                  <div class="icon icon-shape bg-warung text-white rounded-circle shadow-ss">
                    <i class="fas fa-truck" style="color: #ffffff"></i>
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
                ->where("transactions.id", $trans->id)
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
                ->where("transactions.id", $trans->id)
                ->limit(2)
                ->get();

                $detailcounts = DB::table('transaction_details')
                ->select("posts.name","product.name as prod_name")
                ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->distinct()
                ->where("transactions.id", $trans->id)
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
                    <b>{{ date('d M Y', strtotime($trans->created_at)) }} | Rp. {{ $barang ?  number_format($barang->amount,0,',','.') : '' }} {{ $trans->jam == '' ? '' : '| '.$trans->jam }}</b><br>
                    <div style="font-size: 10px;color: black;">Transaksi ini mengandung {{ $detailcounts }} barang, Status Delivery ini yaitu 
                      @if($trans->status == "ALLOCATED" || $trans->status == "CONFIRMED")
                        @if($trans->delivery_code == NULL)
                          <b>Sedang di Proses Oleh Kurir Toko</b>
                        @else
                          <b>Proses Pencarian Driver</b>
                        @endif
                        
                      @elseif($trans->status == "PICKING_UP" || $trans->status == "PICKED")
                        <b>Kurir sedang dalam Proses Penjemputan</b>
                      @elseif($trans->status == "DROPPING_OFF")
                        <b>Barang sedang proses pengantaran ke Pelanggan</b>
                      @else
                        <b>Barang sedang Di Proses </b>
                      @endif
                    </div>
                    </div>

                </td>
              </tr>
            </table>
          </div>
        </div>
      </a>
      <br>
      @endforeach


    @endif
           
  <br><br><br>
  </div>
</div>

@include('content.reedem.modal')       
@include('layout.footer')
<script type="text/javascript">
  
  function Siapkan(id){

    $('#idready').val(id);
    $('#siapkan').modal('show');

  }

  function Selesai(id){

    $('#idselesai').val(id);
    $('#selesai').modal('show');

  }

  $('#yakinready').on('click', function () {

      $.ajax({
        type: 'POST',
        url: "{{ route('reedemready') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idready').val(),  
        },
        success: function(data) {

          $.ajax({        
            type : 'POST',
            url : "https://fcm.googleapis.com/fcm/send",
            headers : {
                Authorization : 'key=' + 'AAAA3hityDc:APA91bHSYyN1RWj8RAjOp87yjp6Z22MskaBe0soUt0cdQKq7XT7Z9hiMACpM1F0XjZ19zOI7M2hnn9T3z2GoTA3iZKpN00gkDTYOU0b69UZnFnbQYO_BvIJ9TgWTKq2duVlbNhgkKyCz'
            },
            contentType : 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                "to": data.fcm, 
                "notification": {
                    "title":"HALO "+data.name+"!",
                    "body":"Barang pesanan Kamu sudah disiapkan oleh Petugas kami Lho, Yuk Ambil Pesanan Kamu sekarang!",
                    "icon": "https://tomxperience.id/assets/icon/96x96.png",
                    "click_action": "https://tomxperience.id/home",
                }
            }),
            success : function(response) {
                console.log(response);
            },
            error : function(xhr, status, error) {
                console.log(xhr.error);                   
            }
          });

          $('#siapkan').modal('hide');

          swal({
              title: "Berhasil!",
              text: "Pesanan sudah diubah status menjadi READY!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/reedemtoday'; }, 1500);

        }

      });

  });

  $('#yakinselesai').on('click', function () {

      $.ajax({
        type: 'POST',
        url: "{{ route('reedemselesai') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idselesai').val(),  
        },
        success: function(data) {

          $('#selesai').modal('hide');

          swal({
              title: "Berhasil!",
              text: "Pesanan sudah diselesaikan!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/reedemtoday'; }, 1500);

        }

      });

  });

</script>   