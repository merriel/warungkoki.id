@include('layout.head2')
@if($trans->status == "APPROVED")
<style type="text/css">
  
  body{

    background-color: white;
  }
</style>
@endif
  <div class="main-content">
    <!-- Header -->
    <div class="header pt-4 pt-md-8" style="padding-bottom: 19rem;color: white;">
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="row justify-content-center">
            @if($trans->status == "APPROVED")
               <h2 style="margin-bottom:0.1rem;"><b>TRANSAKSI BERHASIL!</b></h2>  
               <div align="center" style="font-size:11px;">Pastikan Anda mengambil barangnya pada petugas kami.</div>
            @else
              <h3>Rincian Transaksi Pembelian</h3>   
            @endif
          </div>
          <br>
          @if($trans->status == "APPROVED")

            @if($user->google_id == NULL)

              <img width="100%" src="/assets/content/img/theme/happy2.png">
              <div style="font-size:12px;padding-top: 10px;" align="center">
                Tertarik untuk manfaat lebih ? Daftar di warungkoki.id dengan klik di sini
              </div>
              <div style="padding-top: 10px;">
                <a href="{{ url('auth/google') }}?page=1">
                  <button style="border-radius: 2rem;" class="btn btn-secondary btn-block"><img src="{{ asset ('assets/content/img/theme/google.png') }}" width="10%"> &nbsp;&nbsp;Daftar dengan Google</button>
                </a>
                <br>
                <a href="/promo/grab/daftar">
                  <button style="border-radius: 2rem;" class="btn btn-success btn-block"><i class="fa fa-phone"></i> &nbsp;&nbsp;Daftar dengan No Handphone</button>
                </a>
              </div>

            @else

              <img width="100%" src="/assets/content/img/theme/happy2.png">
              <div style="font-size:12px;padding-top: 10px;" align="center">
                Yey, Transaksi Kamu Berhasil, Terimakasih sudah menggunakan warungkoki.id
              </div>
              <div style="padding-top: 10px;">
                <a href="/home">
                  <button style="border-radius: 2rem;" class="btn btn-success btn-block"><i class="fa fa-phone"></i> &nbsp;&nbsp;Masuk ke Aplikasi</button>
                </a>
              </div>

            @endif

          @else
          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Status :</b>
                <br> 
                  <div class="text-warning" style="padding-top: 5px;"><b> BELUM BAYAR</b></div>
                <hr>
                <b>Tanggal Pembelian :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y H:i', strtotime($trans->created_at)) }}</div>
                <hr>

                <!-- <b>Tempat Pengambilan :</b>
                <br>
                <div style="padding-top: 5px;">{{ $wilayah->name }}</div>
                <hr> -->

                <!-- <b>Pembayaran Mala :</b>
                <br>
                </div>
                @if($trans->type_bayar == 'CASH')
                  <span class="badge badge-primary"><i class="fa fa-gift"></i> BAYAR CASH</span>
                @else
                  <span class="badge badge-info"><i class="fa fa-laptop"></i> BAYAR ONLINE</span>
                @endif

                <span class="badge badge-primary"><i class="fa fa-calendar"></i> {{ date('d M Y', strtotime($trans->created_at)) }}</span> -->
              </div>

              <!-- @if($trans->type_bayar == 'CASH')
              <div style="font-size: 10px;padding-bottom: 10px;">Pembayaran ini harus dilakukan pada outlet <b>@foreach($wilayah as $lokasi) {{ $lokasi->name }} @endforeach</b></div>
              @endif -->

          

            <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->
              <div style="font-size: 12px;"><b>Produk yang di Beli :</b></div><br>
              @php $total=0; @endphp
              @foreach($saldos as $saldo)

                @php
                $total += $saldo->amount;

                @endphp
                <div class="card shadow-ss" style="margin-bottom: 6px;border-radius: 1rem;" >
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" width="65%"><b>({{ $saldo->qty  }}) {{ $saldo->prod_name }} {{ $saldo->name }} @ {{ rupiah($saldo->amount / $saldo->qty) }}</b></td>
                          <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->amount)  }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>
              @endforeach
              

              @if($trans->alamat_id != null)
              <div class="card shadow-ss" style="margin-bottom: 6px;border-radius: 1rem;">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" width="65%"><b>{{ strtoupper($saldo->delivery_name) }} {{ strtoupper($saldo->delivery_type) }}</b></td>
                        <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              @endif

              @if($potongan)

                <div class="card shadow-ss bg-danger" style="margin-bottom: 6px;border-radius: 1rem;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;color: white;" width="65%"><b>Potongan Voucher</b></td>
                          <td align="right"  style="font-size: 11px;color: white;"><b>- {{ rupiah($potongan->amount)  }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>

              @endif

              <div class="card shadow-ss bg-iolo" style="margin-bottom: 6px;border-radius: 1rem;">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" class="text-white"><b>TOTAL BAYAR</b></td>
                        @if($trans->alamat_id != null)

                          @if($potongan)

                             <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery-$potongan->amount)  }}</b></td>

                          @else

                            <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>

                          @endif
                        @else

                          @if($potongan)
                          <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total-$potongan->amount)  }}</b></td>
                          @else
                          <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total)  }}</b></td>
                          @endif
                        
                        @endif
                      </tr>
                    </table>
                </div>
              </div>

              <!-- ===== DISKON ====== -->

              @if($trans->diskon != null)

                <div class="card shadow-ss bg-success" style="margin-bottom: 6px;border-radius: 1rem;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" class="text-white"><b>DISKON {{ $trans->diskon }}</b></td>
                          <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total * ((int)$trans->diskon/100)) }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>

                <div class="card shadow-ss bg-iolo" style="margin-bottom: 6px;border-radius: 1rem;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" class="text-white"><b>TOTAL BAYAR</b></td>
                          @if($trans->alamat_id != null)
                          <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah(($total+$saldo->delivery) - $potongan)  }}</b></td>
                          @else
                          <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total - ($total * ((int)$trans->diskon/100)))  }}</b></td>
                          @endif
                        </tr>
                      </table>
                  </div>
                </div>

              @endif

                <!-- ====== BARCODE ======== -->
                
                @if($trans->status == "BELUM BAYAR")
                  <hr>
                  <div style="font-size: 12px;"><b>Barcode :</b></div><br>
                  <div class="card shadow-ss">
                    <div class="card-body" >
                      
                      <table width="100%">
                        <tr>
                          <td align="center">
                            {!! DNS2D::getBarcodeHTML($trans->uuid, 'QRCODE'); !!}<br> <div style='font-size: 12px;' align='center'><u><b>{{ $trans->uuid }}</b></u></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="center"><div style="font-size: 11px"> Tunjukan QRCODE ini Ke Petugas kami Yang Berjaga di Lokasi untuk melakukan pengambilan dan pembayaran !</div></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                @endif

                <!-- ====== END BARCODE ====== -->

            </div>
          </div>

          <br>
          <a href="/promo/grab"><button class="btn btn-block btn-success">KEMBALI</button></a>

          @endif
        </div>
      </div>
    </div>
  @include('layout.footer2')

</body>

</html>