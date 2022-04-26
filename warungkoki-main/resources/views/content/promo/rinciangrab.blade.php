@include('layout.head2')

<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 17rem;">
  <div class="container-fluid">
    <div class="header-body">

    </div>
  </div>
</div>
<br>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      <section class="container">
        <div class="ct-page-title" style="margin-bottom:0.5rem;">
          <h2 class="ct-title" style="margin-bottom:0px;font-size: 21px;font-weight: bold;" id="content">RINCIAN BAYAR</h2>
          <div style="font-size:11px;">Berikut adalah rincian pembayaran yang harus dilakukan, pembayaran di lakukan di site/toko yang sudah dipilih oleh Driver.</div>
        </div>
        <hr>
    </section>
     @php
    $total = 0;
    @endphp
    @foreach ($keranjangs as $kranjang)
    @php
    $harga = $kranjang->harga_act;
    $totalnya = $kranjang->qty * $harga;

    @endphp
      <div class="row">
        <div class="col-12" style="padding-bottom:0px;">
          <div class="card shadow-ss" style="border-radius:1rem;">
            <div class="card-body">
              <div class="row">
                <div class="col-4" style="padding-bottom: 0px;">
                    <img width="100%" src="/assets/img_post/{{ $kranjang->img }}">
                </div>
                <div class="col-8" align="left" style="padding-bottom: 0px;">
                    <div style="font-size: 11px;"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                    <div style="font-size: 12px;" class="text-warning"><b>{{ rupiah($harga) }} | Qty : {{ $kranjang->qty }}</b>
                    </div> 
                    <!-- <div style="font-size:10px;">Pengambilan barang dapat dilakukan di <b>{{ $kranjang->wilayah_name }}</b></div> -->
                </div>

                <div class="col-12" style="padding-bottom: 0px;">
                  <hr>
                  <table width="100%" style="font-size: 12px;">
                    <tr>
                      <td align="left"><b>TOTAL</b></td>
                      <td align="right">
                        <b>{{ rupiah($totalnya) }}</b>
                      </td>
                    </tr>
                  </table>
                  @if($potongan)  
                    @if($potongan->amount != 0)
                    <hr>
                    <table width="100%" style="font-size: 12px;">
                      <tr>
                        <td align="left"><b>POTONGAN</b></td>
                        <td align="right">
                          <b>- {{ rupiah($potongan->amount) }}</b>
                        </td>
                      </tr>
                    </table>
                    @endif
                  @endif
                </div>

               
                  @php
                    $totalkeseluruhan = $totalnya;
                  @endphp

              </div>
            </div>
          </div>
        </div>    
      </div>
      @php
        $total += $totalkeseluruhan;
      @endphp
    @endforeach

    <hr>

    @if($potongan)   

        @php
        $total = $total - $potongan->amount;
        @endphp

    @endif

      <div class="row">
        <div class="col-12">
          <div class="card  bg-iolo shadow-ss" style="border-radius:1rem;">
            <div class="card-body">
              <div class="row">
                <div class="col-7" style="padding-right:0px;padding-bottom: 0px;">
                  <div style="font-size: 13px" class="text-white"> <b>TOTAL YANG DIBAYAR :</b></div>
                </div>
                <div class="col-5" style="padding-bottom: 0px;" align="right">
                    <div style="font-size: 14px" class="text-white"> <b>{{ rupiah($total) }}</b></div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
            <button style="border-radius:1rem;" onclick="BayarSekarang();" class="btn btn-success btn-block">{{ $total == 0 ? 'Ambil Sekarang' : 'Ambil & Bayar Sekarang' }}</button>
        </div>
    </div>
    </div>
  </div>
</div>
@include('content.promo.modal')     
@include('layout.footer2')

<script type="text/javascript">

    function BayarSekarang(){

        $('#konfirmasibayar').modal('show');
    }
    

    function YakinBayars(){

        $('#konfirmasibayar').modal('hide');
        $('.loading').attr('style','display: block');

        $.ajax({
          type: 'POST',
          url: "{{ route('promo.grab.bayar') }}",
          data: {
              '_token': $('input[name=_token]').val(),
          },
          success: function(data) {

            var uuid = data.uuid;

            setTimeout(function(){ window.location.href = '/promo/grab/transaksi?uuid='+uuid; }, 1500);

          }

        });


    }

</script>
        
</body>

</html>