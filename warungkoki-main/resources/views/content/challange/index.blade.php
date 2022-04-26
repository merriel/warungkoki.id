@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <!-- <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Challanges</h1>
            </div>
            <div class="alert alert-primary2" role="alert">
                <button id="baru" class="btn btn-sm btn-success" type="button">Challange Baru</button>
                <button id="berjalan" class="btn btn-sm btn-secondary" type="button">Berjalan</button>
                <button id="hadiah" class="btn btn-sm btn-secondary" type="button">Hadiah</button>
            </div>
            <br>
            <div id="contentbaru" style="display: block;">
              @if($postchallanges->count() == 0)
                <div class="card shadow">
                  <table width="100%">
                    <tr>
                      <td align="center">
                        <img src="/assets/content/img/theme/challangeempty.jpg" width="90%">
                        <br>
                        <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                        <h6>Tidak ada Challange Baru untuk saat ini!</h6>
                      </td>
                    </tr>
                  </table>
                </div>
              @else

              @foreach ($postchallanges as $postchallange)
              <a href="/users/challanges/{{ $postchallange->id }}">
                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="4">
                          <a href="#" class="avatar rounded-circle mr-3">
                            <img alt="Image placeholder" src="/assets/img_post/{{ $postchallange->imgname }}">
                          </a>
                        </td>
                        <td><h4><b>{{ $postchallange->name }}</b></h5></td>
                      </tr>
                      <tr>
                        <td style="font-size: 9px; color: black;"> <div style="padding-bottom: 2px;">Periode Challange :</div>
                          <div style="font-size: 14px;"><b>{{  date('d M Y', strtotime($postchallange->dari)) }} - {{  date('d M Y', strtotime($postchallange->sampai)) }}</b></div>
                        </td>
                      </tr>
                      <tr>
                        <td style="font-size: 9px; color: black;"><br> <div style="padding-bottom: 2px;">
                          Batas Reedem Hadiah : </div>  
                          <div style="font-size: 14px;"><b>{{ date('d M Y', strtotime($postchallange->dari_reward)) }} - {{ date('d M Y', strtotime($postchallange->sampai_reward)) }}</b></div>
                        </td>
                      </tr>
                    </table>
                    <hr>
                    <div style="font-size: 10px; color: black; padding-bottom: 5px;">Lokasi Challange :</div>
                      <span class="badge badge-pill badge-info" style="font-size: 9px;"><i class="fas fa-map-marker"></i>  {{ $postchallange->wilayah_name }} - {{ $postchallange->regency_name }}</span>
                    <hr>
                    <h6>HADIAH YANG DIDAPAT :</h6>
                    @php

                    $details = DB::table('post_rewards')
                    ->select('product.*', 'post_rewards.qty')
                    ->leftJoin('product', 'post_rewards.product_id', '=', 'product.id')
                    ->where('post_id', $postchallange->id)
                    ->get();

                    @endphp
                    <table id="customers">
                      <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                      </tr>
                      @foreach($details as $detail)
                      <tr>
                        <td style="color: black;">{{ $detail->name }}</td>
                        @if($detail->qty >= 1000)
                          <td style="color: black;">{{ rupiah($detail->qty) }}</td>
                        @else
                          <td style="color: black;">{{ $detail->qty }} Pcs</td>
                        @endif
                      </tr>
                      @endforeach
                    </table>
                  </div>
                </div>
              </a>
              <br>
              @endforeach
              @endif
            </div>

            <!-- ---------------------------------------------------- -->

            <div id="contentberjalan" style="display: none;">
              @if($postberjalans->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img src="/assets/content/img/theme/challangeempty.jpg" width="90%">
                          <br>
                          <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                          <h6>Tidak ada Challange yang Anda ikuti saat ini!</h6>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              @else

              @foreach ($postberjalans as $postberjalan)
                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="4">
                          <a href="#" class="avatar rounded-circle mr-3">
                            <img alt="Image placeholder" src="/assets/img_post/{{ $postberjalan->imgname }}">
                          </a>
                        </td>
                        <td colspan="2"><h4><b>{{ $postberjalan->name }}</b></h5></td>
                      </tr>
                      <tr>
                          <td style="font-size: 9px; color: black;"> <div style="padding-bottom: 2px;">Periode Challange :</div>
                            <div style="font-size: 14px;"><b>{{  date('d M Y', strtotime($postberjalan->dari)) }} - {{  date('d M Y', strtotime($postberjalan->sampai)) }}</b></div>
                          </td>
                        </tr>
                        <tr>
                          <td style="font-size: 9px; color: black;"><br> <div style="padding-bottom: 2px;">
                            Batas Reedem Hadiah : </div>  
                            <div style="font-size: 14px;"><b>{{ date('d M Y', strtotime($postberjalan->dari_reward)) }} - {{ date('d M Y', strtotime($postberjalan->sampai_reward)) }}</b></div>
                          </td>
                        </tr>
                    </table>
                    <hr>
                    @if($postberjalan->jenis_challange == 'global')

                      @php

                        $prosec = DB::table('challange_proses')
                        ->leftJoin('product', 'challange_proses.product_id', '=', 'product.id')
                        ->where('join_id', $postberjalan->join_id)
                        ->get();

                        $data = 0;

                        foreach($prosec as $pros){

                          $data += $pros->amount;

                        }

                        $grandtotal = $data;

                      @endphp

                    <div class="alert alert-blue-iolo shadow" role="alert">
                      <table width="100%">
                        <tr>
                          <td>
                            <div class="progress-wrapper" style="padding-top: 0px;">
                              <div class="progress-info">
                                <div class="progress-percentage">
                                  <span class="text-lembur text-white" style="font-size: 12px;">({{ number_format($grandtotal,0,'.','.') }} / {{ number_format($postberjalan->value_challange,0,'.','.') }})</span>
                                </div>
                              </div>
                              <div class="progress">
                                <div class="progress-bar bg-success lembur" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: {{ round(($grandtotal / $postberjalan->value_challange) * 100) }}%;"></div>
                              </div>
                            </div>
                          </td>
                          <td width="5%"></td>
                          <td width="20%" align="right"><h2 class="text-white">{{ round(($grandtotal / $postberjalan->value_challange) * 100) }}%</h2></td>
                        </tr>
                      </table>
                      <div style="font-size: 9px;">Pembelian Produk Berikut:</div>
                      <div style="font-size: 12px;">
                        @foreach($prosec as $proses)
                          {{ $proses->name }},
                        @endforeach
                      </div>
                    </div>

                    @else

                    <h6>PROSES CHALLANGES YANG BERJALAN :</h6><br>
                    @php

                    $prosec = DB::table('challange_proses')
                    ->select('product.*','challange_proses.amount','challange_proses.target')
                    ->leftJoin('product', 'challange_proses.product_id', '=', 'product.id')
                    ->leftJoin('challange_joins', 'challange_proses.join_id', '=', 'challange_joins.id')
                    ->where('join_id', $postberjalan->join_id)
                    ->get();

                    @endphp

                    @foreach($prosec as $detail)

                    @php

                      $persen = round(($detail->amount / $detail->target) * 100);

                    @endphp

                    <div class="alert alert-blue-iolo shadow" role="alert">
                      <table width="100%">
                        <tr>
                          <td>
                            {{ $detail->name }}<br>
                            <div class="progress-wrapper" style="padding-top: 0px;">
                              <div class="progress-info">
                                <div class="progress-percentage">
                                  <span class="text-lembur text-white" style="font-size: 11px;">({{ number_format($detail->amount,0,'.','.') }} / {{ number_format($detail->target,0,'.','.') }})</span>
                                </div>
                              </div>
                              <div class="progress">
                                <div class="progress-bar bg-success lembur" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: {{ $persen }}%;"></div>
                              </div>
                            </div>
                          </td>
                          <td width="5%"></td>
                          <td width="20%" align="right"><h2 class="text-white">{{ $persen }}%</h2></td>
                        </tr>
                      </table>
                    </div>
                    <hr>
                    @endforeach 

                    @endif

                  </div><br>
                </div>

              <br>
              @endforeach
              @endif
            </div>

            <!-- ------------------------------------------------------------ -->

            <div id="contenthadiah" style="display: none;">
              @if($rewards->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img src="/assets/content/img/theme/rewardempty.jpg" width="90%">
                          <br>
                          <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                          <h6>Anda Belum Memiliki Reward Apapun untuk saat ini!</h6>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              @else

              @foreach ($rewards as $reward)

              @php
              $saldos = DB::table('saldo_rewards')
              ->where([
                  ['user_id', '=', $userid],
                  ['product_id', '=', $reward->product_id]
              ])
              ->orderBy('id', 'desc')
              ->first();

              if($saldos->sisa >= 100){
                  $rupiah = 'Rp. ';
                  $kata = '';
              } else {
                $rupiah = '';
                $kata = 'Kali';

              }

              @endphp

                @if($saldos->sisa > 0)
                <div class="card shadow" id="data_{{ $saldos->id }}" onclick="ReedemReward({{ $saldos->id }})">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="3">
                          <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                            <i class="fas fa-coffee" style="color: #ffffff"></i>
                          </div>
                        </td>
                        <td><h4><b>{{ $reward->name }}</b></h5></td>
                      </tr>
                      
                      <tr>
                      <td><span class="badge badge-pill badge-primary" style="font-size: 9px;"><i class="fas fa-calendar"></i> Qty : {{ $saldos->sisa >= 1000 ? rupiah($saldos->sisa) : $saldos->sisa }}</span></td> 
                    </tr> 
                    </table>
                    <div id="reedem_{{ $saldos->id }}" style="display: none">
                      <hr>
                      <div class="row">
                        <div class="col-12" align="center">
                          <button type="button" onclick="Reedem(this)" data-saldo="{{ $saldos->sisa }}" data-saldotext="{{ $rupiah }}{{ number_format($saldos->sisa,0,'.',',') }} {{ $kata }}" data-prod="{{ $reward->name }}" data-id="{{ $saldos->id }}" class="btn btn-sm btn-success">Reedem</button>
                        </div>
                      </div>
                  </div>
                  </div>
                </div>
                <br>
                @endif
              @endforeach
              @endif
            </div>
        </div> 
      </div> 
    </div>
  </div>
  @include('content.deals.modal')
  @include('layout.footer')

  <script type="text/javascript">
    
    $('#berjalan').on('click', function () {

      $('#contentbaru').attr('style', 'display: none;');
      $('#contentberjalan').attr('style', 'display: block;');
      $('#contenthadiah').attr('style', 'display: none;');

      $('#baru').attr('class', 'btn btn-sm btn-secondary');
      $('#berjalan').attr('class', 'btn btn-sm btn-success');
      $('#hadiah').attr('class', 'btn btn-sm btn-secondary');

    });

    $('#baru').on('click', function () {

      $('#contentbaru').attr('style', 'display: block;');
      $('#contentberjalan').attr('style', 'display: none;');
      $('#contenthadiah').attr('style', 'display: none;');

      $('#baru').attr('class', 'btn btn-sm btn-success');
      $('#berjalan').attr('class', 'btn btn-sm btn-secondary');
      $('#hadiah').attr('class', 'btn btn-sm btn-secondary');

    });

    $('#hadiah').on('click', function () {

      $('#contentbaru').attr('style', 'display: none;');
      $('#contentberjalan').attr('style', 'display: none;');
      $('#contenthadiah').attr('style', 'display: block;');

      $('#baru').attr('class', 'btn btn-sm btn-secondary');
      $('#berjalan').attr('class', 'btn btn-sm btn-secondary');
      $('#hadiah').attr('class', 'btn btn-sm btn-success');

    });

    function ReedemReward(id){

        $('#reedem_'+id).attr('style', 'display: block;');
        $('#data_'+id).attr('onclick', 'Tutup('+id+')');

      }

      function Tutup(id){

        $('#reedem_'+id).attr('style', 'display: none;');
        $('#data_'+id).attr('onclick', 'ReedemReward('+id+')');

      }

      function Reedem(elem){

        var saldotext = $(elem).data("saldotext");
        var saldo = $(elem).data("saldo");
        var name = $(elem).data("prod");
        var id = $(elem).data("id");

        $('#saldo_id').val(id);
        $('#saldo').val(saldo);
        $('#saldos').html(saldotext);
        $('#name').html(name);

        $('#reedem').modal('show');
      }

      $('.modal-footer').on('click', '#reedem', function() {

    var qty = $('#qtyreedem').val();
    var saldo = $('#saldo').val();
    var id = $('#saldo_id').val();

    var empty = false;
      $('input#qtyreedem').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) { 
          swal({
              text: "Isian Tidak Boleh Kosong!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

      } else {

      if (parseInt(qty) > parseInt(saldo)){

        swal({
                    text: "Qty Tidak Boleh lebih dari Saldo!",
                    icon: "error",
                    buttons: false,
                    timer: 2000,
                });

      } else {

        $('#reedem').modal('hide');
        $('#token').modal('show');

      }

    }

  });

  $('#reedemtoken').on('click', function () {

    $('.loading').attr('style','display: block');
    $('#token').modal('hide');

    var tokens = $('#tokenusers').val();
    var id = $('#saldo_id').val();

    $.ajax({
      type: 'POST',
      url: "{{ route('validasitoken') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'token': $('#tokenusers').val(),  
      },
      success: function(data) {

        if(data == '1'){

          $.ajax({
            type: 'POST',
            url: "{{ route('reedemdeals') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'qty': $('#qtyreedem').val(),
                'saldo_id': $('#saldo_id').val(),
                'type': 'reward',
            },
            success: function(data) {

              $('#img_barcode').html("<img width='100%' alt='barcode' src='https://iolosmart.com/assets/barcode/barcode.php?codetype=Code128&size=85&text="+data.uuid+"'><br> <div style='padding-top: 15px;font-size: 15px;' align='center'><u><b>"+data.uuid+"</b></u></div>");
        $('#token').modal('hide');
        $('#barcode').modal('show');
        $('.loading').attr('style','display: none');
        $('#barcode').modal({backdrop: 'static', keyboard: false});

            }

        });

        } else if(data == '2'){

          swal({
            title: "Token Anda Salah",
            text: "Anda dapat Lihat di Menu Profile!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

            $('.loading').attr('style','display: none');
          

        } else {

          swal({
            title: "Belum Ada Token",
            text: "Update Token di Menu Profile!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

            $('.loading').attr('style','display: none');

        }

      }

    });

  });

  </script>

</body>

</html>