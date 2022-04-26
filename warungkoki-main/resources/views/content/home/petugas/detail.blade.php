@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
  <div class="ct-title" style="font-size: 24px;margin-bottom: 8px;margin-top: 0.5rem;line-height: 1.2">Transaksi Penjualan dengan KodeInv : {{ $trans->uuid }}</div>
  <hr>
  <div class="card card-stats mb-4 mb-lg-0" style="border-radius: 1rem;">
    <div class="card-body" style="padding: 1rem;">
        <div style="font-size: 11px;"> Nama Pelanggan :</div>
        <div style="font-size: 15px;font-weight: bold;">{{ $trans->username }} </div>
        <hr>
        <div style="font-size: 11px;"> Waktu :</div>
        <div style="font-size: 15px;font-weight: bold;">{{ date('d F Y H:i', strtotime($trans->created_at)) }} </div>
        <hr>
        @if($trans->alamat_id != null)
        <div style="font-size: 11px;"> Dikirim ke :</div>
        <div style="font-size: 15px;font-weight: bold;">{{ $trans->alamat }} ({{ $trans->judul }})</div>
        <hr>
        <div style="font-size: 11px;"> Penerima :</div>
        <div style="font-size: 15px;font-weight: bold;">{{ $trans->penerima }}</div>
        <hr>
        @endif
        <div style="font-size: 11px;padding-bottom: 10px;"> Produk Yang Dibeli :</div>
        <table id="customers">
          <tr>
              <th>#</th>
              <th>Produk</th>
              <th>Qty</th>
              <th>Total</th>
          </tr>
            <tbody>
              @php $no=0; $total=0; @endphp
              @foreach($details as $det)
              @php 

              $harga = DB::table('order_details')
              ->select("order_details.*")
              ->join("orders", "order_details.order_id", "=", "orders.id") 
              ->where([
                  ['orders.transaction_id', '=', $trans->id],
                  ['order_details.post_id', '=', $det->post_id],
              ])
              ->first();

              $no++; 

              $total += $harga->amount;

              @endphp
              <tr>
                <td>{{ $no }}</td>
                <td>{{ $det->prod_name }} {{ $det->post_name }}</td>
                <td>{{ $det->qty }}</td>
                <td nowrap align="right">{{ rupiah($harga->amount) }}</td>
              </tr>
              @endforeach
              @if($trans->alamat_id != null)
              <tr>
                <td colspan="3">Pengiriman dengan {{ $trans->delivery_name }} {{ $trans->delivery_type }}</td>
                <td nowrap align="right">{{ rupiah($trans->delivery) }}</td>
              </tr>
              @endif
              @if($potongan)
              <tr>
                <td colspan="3">Potongan Vouchers</td>
                @if($potongan->amount == NULL)
                  <td nowrap align="right">- {{ rupiah($total * ($potongan->percent/100)) }}</td>
                @else
                  <td nowrap align="right">- {{ rupiah($potongan->amount) }}</td>
                @endif
                
              </tr>
              @endif
            </tbody>
            <tr>
              <td colspan="3"><b>TOTAL BAYAR</b></td>
              <td nowrap><b>{{ rupiah($trans->amount) }}</b></td>
            </tr>
        </table>
        @if($trans->cash == "yes")
        <hr>
        <div class="col-12" style="padding-right:0px;padding-left: 0px;">
          <div align="center">
            <button onclick="Konfirm()" type="button" class='btn btn-block btn-success'>Bayar QRIS SEKARANG</button>
          </div>
        </div>
        @endif
    </div>
  </div>
  
  <hr>
  
  <br><br><br><hr>
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            
            <div class="modal-header" style="padding-bottom:0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding-top:0px;">
                <img src="/assets/splash/images/oogitu.jpg" width="100%">
                <div style="font-size:18px;padding-top: 10px;" class="text-danger"><b>HARAP DI PERHATIKAN!</b></div>
                <div style="font-size:12px;">
                  Jika ingin melakukan Pembayaran diharapkan dilakukan secara langsung yaitu muncul QRIS langsung dibayarkan <i>(tidak disarankan download beberapa QRIS baru dibayarkan)</i>, karena kode QRIS akan kadaluarsa dalam <b>5 menit</b>.
                </div>
                <hr>
                <div class="row">
                  <div class="col-12">
                    <a class="menusxx" href="/reedem/showqris?uuid={{ $trans->uuid }}"><button type="button" id="reedem_yakin" class="btn btn-block btn-primary">BAYAR SEKARANG</button></a>
                  </div>
                </div>
            </div>
            
            
            
        </div>
    </div>
</div>
@include('layout.footer')
<script type="text/javascript">
  
  function Konfirm(){

    $('#konfirmasi').modal('show');
  }

</script>

</body>

</html>
