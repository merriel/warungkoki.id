@include('layout.head')
<div class="main-content">
    <input type="hidden" id="userzid" value="{{ Auth::user()->id }}">
  <!-- Header -->
<div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
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
                  <td nowrap align="right">- {{ rupiah($potongan->amount) }}</td>
                </tr>
                @endif
              </tbody>
              <tr>
                <td colspan="3"><b>TOTAL BAYAR</b></td>
                <td nowrap><b>{{ rupiah($trans->amount) }}</b></td>
              </tr>
          </table>
    </div>
  </div>
  
  <hr>
  
  <br><br><br><hr>
@include('content.home.petugas.modal')
@include('layout.footer')
<script type="text/javascript">
  
  function View(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('petugas.lihattransaksi') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': id,
      },
      success: function(data) {

        var no = -1;
        var nos = 0;
        $('#user').html(data[0]['username']);
        $('#periode').html(data[0]['created_at']);

        var content_data = "";

        $.each(data, function() {

          no++;
          nos++;
          var post_name = data[no]['post_name'];
          var prod_name = data[no]['prod_name'];
          var qty = data[no]['qty'];

          content_data += "<tr>";
          content_data += "<td>"+nos+"</td>";
          content_data += "<td>"+prod_name+" "+post_name+"</td>";
          content_data += "<td>"+qty+"</td>";
          content_data += "<tr>";


        });
        
        $('#prodx').html(content_data);
      }

    });

    $('#melihat').modal('show');
  }

  function ViewDelivery(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('petugas.lihattransaksi') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': id,
      },
      success: function(data) {

        var no = -1;
        var nos = 0;
        $('#user').html(data[0]['username']);
        $('#periode').html(data[0]['created_at']);


        var content_data = "";
        var content_datas = "";

        content_data += "<tr>";
        content_data += "<td>"+nos+"</td>";
        content_data += "<td>"+prod_name+" "+post_name+"</td>";
        content_data += "<td>"+qty+"</td>";
        content_data += "<tr>";

        $.each(data, function() {

          no++;
          nos++;
          var post_name = data[no]['post_name'];
          var prod_name = data[no]['prod_name'];
          var qty = data[no]['qty'];

          content_data += "<tr>";
          content_data += "<td>"+nos+"</td>";
          content_data += "<td>"+prod_name+" "+post_name+"</td>";
          content_data += "<td>"+qty+"</td>";
          content_data += "<tr>";


        });
        
        $('#prodx').html(content_data);
      }

    });

    $('#melihatdelivery').modal('show');
  }

</script>

</body>

</html>
