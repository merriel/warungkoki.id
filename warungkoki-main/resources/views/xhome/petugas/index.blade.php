@include('layout.head')
<style type="text/css">
  .nav2 {
    position: fixed;
    bottom: 0;
    background-color: #2dce89;
    display: flex;
    overflow-x: auto;

    margin-bottom: 75px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 60px;
    margin-left: 5%;
    width: 90%;

}

.nav__link2 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #444444;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}
</style>
  <div class="main-content">
    <!-- Header -->
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 4.8rem;">
      <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
    <div class="ct-page-title">
      <h1 class="ct-title" id="content">On Progress Delivery</h1>
    </div>
    <hr>
    <!-- Card stats -->
    @if($transaksis->count() == '0')
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
      @foreach($transaksis as $trans)

      <a href="/xhome/petugas/detail?uuid={{ $trans->uuid }}"><div class="card shadow-ss menusxx">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td width="25%" rowspan="4">
                  <div class="icon icon-shape bg-kuning text-white rounded-circle shadow-ss">
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
                    <div style="font-size: 10px;color: black;">Transaksi ini mengandung {{ $detailcounts }} barang</div>
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
           
@include('layout.footer')

</body>

</html>