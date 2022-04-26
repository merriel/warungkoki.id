@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/report"><button type="button" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Hasil Reporting</h1>
            </div>

            <div class="card shadow">
              <div class="card-body">
                <table id="customers">
                  <tr>
                    <th colspan="2"> Detail Pencarian</th>
                  </tr>
                  <tr>
                    <td>Dari Tanggal : </td>
                    <td>{{ date('d F Y H:i', strtotime($dari)) }} </td>
                  </tr>
                  <tr>
                    <td>Sampai Tanggal : </td>
                    <td>{{ date('d F Y H:i', strtotime($sampai)) }}</td>
                  </tr>
                  <tr>
                    <td>Type Report : </td>
                    <td><b>{{ $type }}</b></td>
                  </tr>
                </table>
                <hr>
                @if($jenis == 'penjualan')
                <table id="customers">
                  <tr>
                    <th colspan="2">Transaksi CASH</th>
                  </tr>
                  <tr>
                    <td width="40%">Banyaknya Transaksi </td>
                    <td style="font-size: 20px;" class="text-warning" align="right"><b>{{ $trans }}</b></td>
                  </tr>
                  <tr>
                    <td>Total Transaksi</td>
                    <td style="font-size: 16px;" class="text-warning" align="right"><b>{{ rupiah($total) }}</b></td>
                  </tr>
                </table>

                <br>

                <table id="customers">
                  <tr>
                    <th colspan="2">Transaksi ONLINE</th>
                  </tr>
                  <tr>
                    <td width="40%">Banyaknya Transaksi </td>
                    <td style="font-size: 20px;" class="text-warning" align="right"><b>{{ $onlines }}</b></td>
                  </tr>
                  <tr>
                    <td>Total Transaksi</td>
                    <td style="font-size: 16px;" class="text-warning" align="right"><b>{{ rupiah($totalonlines) }}</b></td>
                  </tr>
                </table>
                @else
                <table id="customers">
                  <tr>
                    <th colspan="2">Reedem Deals</th>
                  </tr>
                  @php
                    $hargadeals = 0;
                  @endphp
                  @foreach($dealtotals as $dealtotal)

                    @php
                      if($dealtotal->qty >= 1000){

                        $totdeals = $dealtotal->qty;

                      } else {

                        $totdeals = $dealtotal->qty * $dealtotal->harga;

                      }

                      $hargadeals += $totdeals;

                    @endphp

                  @endforeach
                  <tr>
                    <td width="35%">Banyanya </td>
                    <td style="font-size: 21px;" class="text-warning" align="right"><b>{{ $deals }}</b></td>
                  </tr>
                  <tr>
                    <td>Seharga </td>
                    <td style="font-size: 17px;" class="text-warning" align="right"><b>{{ rupiah($hargadeals) }}</b></td>
                  </tr>
                </table>
                <hr>
                <table id="customers">
                  <tr>
                    <th colspan="2">Reedem Produk</th>
                  </tr>
                  @php
                    $hargaproducts = 0;
                  @endphp
                  @foreach($producttotals as $producttotal)

                    @php

                      $hargaproducts += $producttotal->qty * $producttotal->harga_act;

                    @endphp

                  @endforeach
                  <tr>
                    <td width="35%">Banyaknya</td>
                    <td style="font-size: 21px;" class="text-warning" align="right"><b>{{ $products }}</b></td>
                  </tr>
                  <tr>
                    <td>Seharga</td>
                    <td style="font-size: 17px;" class="text-warning" align="right"><b>{{ rupiah($hargaproducts) }}</b></td>
                  </tr>
                </table>
                <hr>
                <table id="customers">
                  <tr>
                    <th colspan="2">Reedem Reward</th>
                  </tr>
                  <tr>
                    <td width="35%">Banyaknya</td>
                    <td style="font-size: 21px;" class="text-warning" align="right"><b>{{ $rewards }}</b></td>
                  </tr>
                  <tr>
                    <td>Seharga</td>
                    <td style="font-size: 17px;" class="text-warning" align="right"><b>Rp .0</b></td>
                  </tr>
                </table>
                <hr>
                <table id="customers">
                  <tr>
                    <td><h4> <b>Total Banyak</b></h4></td>
                    <td style="font-size: 21px;" class="text-warning" align="right"><b>{{ $total }}</b></td>
                  </tr>
                  <tr>
                    <td><h4> <b>Total Harga</b></h4></td>
                    <td style="font-size: 17px;" class="text-warning" align="right"><b>{{ rupiah($hargadeals + $hargaproducts) }}</b></td>
                  </tr>
                </table>
                @endif
              </div>
            </div>
        </div> 
      </div> 
    </div>
  </div>

  @include('layout.footer')
  <script type="text/javascript">
    
    $('#jamdariwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 23 || angka == ''){

        $('#jamdariwaktu').val('00');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = angka;
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');

    });

    $('#jamsampaiwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 23 || angka == ''){

        $('#jamsampaiwaktu').val('23');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = angka;
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');

    });

    $('#menitdariwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 59 || angka == ''){

        $('#menitdariwaktu').val('00');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = angka;
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');

    });

    $('#menitsampaiwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 59 || angka == ''){

        $('#menitsampaiwaktu').val('59');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = angka;

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');

    });

    $('#daritanggal').on('change', function () {

      var tanggaldari = $(this).val();
      var tanggalsampai = $('#sampaitanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();
      var type = $('#type').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');


    });

    $('#sampaitanggal').on('change', function () {

      var tanggalsampai = $(this).val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();
      var type = $('#type').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');


    });

    $('#type').on('change', function () {

      var type = $(this).val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-success">Search</button>');


    });

  </script>
</body>

</html>