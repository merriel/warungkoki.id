@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pb-9 pt-md-8" style="padding-top: 6rem;">
      <div class="container-fluid">
        <div class="header-body">
          @if($cektrans)
          <input type="hidden" id="insentif" value="{{ $voucher ? $voucher->insentif : '' }}">
          @endif
        </div>
      </div>
    </div>

    @if(!$cekapproved)

      @if($cektrans)

        @if($code)

        <div class="container-fluid mt--9">
          @if($cektrans->status == "REEDEM")
          <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
              <div class="row justify-content-center">
                  <h2>Proses Reedem</h2>   
              </div>
              <br>
              <div class="card shadow">
                <div class="card-body">
                    <table id="customers">
                      <tr>
                        <td width="50%">
                          Nama Customer :
                        </td>
                        <td><b>{{ $cektrans->name }}</b></td>
                      </tr>
                      <tr>
                        <td>
                          Site Reedem :
                        </td>
                        <td><b>{{ $wilayah->name }}</b></td>
                      </tr>
                      @if($cektrans->ket != '' || $cektrans->ket != null)
                      <tr>
                        <td>
                          Keterangan :
                        </td>
                        <td><b>{{ $cektrans->ket }}</b></td>
                      </tr>
                      @endif
                    </table>
                    <hr>

                    @foreach($saldos as $saldo)
                    @if($saldo->status == 'SELESAI')
                      <div class="card shadow-ss bg-disabled" id="all_{{ $saldo->detail_id }}">
                        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                          <table width="100%">
                            <tr>
                              <td align="left" style="color: white;">
                                <div style="font-size: 12px;text-decoration: line-through;"><b>{{ $saldo->prod_name }} ({{ $saldo->post_type }})</b></div>
                                <div style="font-size: 10px;text-decoration: line-through;">Quantity yang akan diambil : <b>{{ number_format($saldo->qty,0,'.',',') }}</b></div>
                              </td>
                              <td align="right" id="button_{{ $saldo->detail_id }}">
                                <i class="fa fa-times" style="font-size: 18px;color: white;"></i>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <br>
                    @else
                      <div class="card shadow-ss" id="all_{{ $saldo->detail_id }}" onclick="Pilih({{ $saldo->detail_id }})">
                        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                          <table width="100%">
                            <tr>
                              <td align="left" id="text_{{ $saldo->detail_id }}">
                                <div style="font-size: 12px;"><b>{{ $saldo->prod_name }} ({{ $saldo->post_type }})</b></div>
                                <div style="font-size: 10px;">Quantity yang akan diambil : <b>{{ number_format($saldo->qty,0,'.',',') }}</b></div>

                                <div id="value_{{ $saldo->detail_id }}">
                                  
                                </div>

                                <div id="cekpilih_{{ $saldo->detail_id }}">
                                  <input type="hidden" class="cek">
                                </div>
                              </td>
                              <td align="right" id="button_{{ $saldo->detail_id }}">
                                <i class="fa fa-circle" style="font-size: 18px;color: #b2b2b2;"></i>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <br>
                    @endif
                    @endforeach
                    
                    <hr>
                    <table width="100%">
                      <tr>
                        <td align="center">

                          @if($voucher)
                            @if($voucher->insentif == "yes")
                              <div align="center"><button onclick="AdaInsentifAmbil({{ $cektrans->trans_id }},1)" type="button" class='btn btn-block btn-success'>Reedem Sekarang</button></div>
                            @else
                              <button type="button" onclick="ReedemNow()" class="btn btn-success">Reedem Sekarang</button>
                            @endif
                          @else
                          <button type="button" onclick="ReedemNow()" class="btn btn-success">Reedem Sekarang</button>
                          @endif
                        </td>
                      </tr>
                    </table>
                    <input type="hidden" id="tofcm" value="{{ $cektrans->fcm_token }}">
                    <input type="hidden" id="trans_id" value="{{ $cektrans->trans_id }}">
                </div>
              </div>
            </div>
          </div>
          @else 


          <!-- ====== JIKA MELAKUKAN PEMBAYARAN ===== -->

          <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
              <div class="row justify-content-center">
                  <h2>Rincian Pembelian</h2>   
              </div>
              <br>

              <div class="card shadow">
                <div class="card-body">
                    <table id="customers">
                      <tr>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                      </tr>
                    @php $harga=0 @endphp
                     @foreach($saldos as $saldo)
                     @php
                     if($saldo->order_timbangan == null){
                        $harga += $saldo->amount;
                     } else {
                        $harga += $saldo->order_timbangan;
                     }
                     

                     @endphp
                        <tr>
                          <td>{{ $saldo->prod_name }} {{ $saldo->name }}</td>
                          <td>{{ $saldo->qty }}</td>
                          @if($saldo->order_timbangan == null)
                          <td align="right">{{ number_format($saldo->amount / $saldo->qty,0,',','.') }}</td>
                          <td align="right">{{ number_format($saldo->amount,0,',','.') }}</td>
                          @else
                          <td align="right">{{ number_format($saldo->order_timbangan / $saldo->qty,0,',','.') }}</td>
                          <td align="right">{{ number_format($saldo->order_timbangan,0,',','.') }}</td>
                          @endif
                        </tr>
                        
                    @endforeach
                    </table>
                    
                    <input type="hidden" id="tofcm" value="{{ $fcm }}">
                    <input type="hidden" id="trans_id" value="{{ $saldo->trans_id }}">
                </div>

                @if($harga >= 25000000)
                @php $potongan = $harga * 0.05; @endphp
                <div style="border-color: #fff;" class="alert alert-default bg-success" role="alert">
                    <table width="100%">
                      <tr>
                        <td align="left"><b>Diskon 5%: </b></td>
                        <td align="right" class="text-white"><b>{{ rupiah($harga * 0.05) }}</b></td>
                      </tr>
                    </table>
                </div>
                @elseif($harga >= 2500000)
                @php $potongan = $harga * 0.03; @endphp

                <div style="border-color: #fff;" class="alert alert-default bg-success" role="alert">
                    <table width="100%">
                      <tr>
                        <td align="left"><b>Diskon 3%: </b></td>
                        <td align="right" class="text-white"><b>{{ rupiah($harga * 0.03) }}</b></td>
                      </tr>
                    </table>
                </div>
                @else
                @php $potongan = 0; @endphp


                @endif

                @if($voucher)

                  @if($voucher->jenis == null)

                    @if($voucher->amount == NULL)

                      @php
                      $potonganvoucher = $harga * ($voucher->percent/100);
                      @endphp
                        <div style="border-color: #fff;" class="alert alert-default bg-danger" role="alert">
                          <table width="100%">
                            <tr>
                              <td align="left"><b>Potongan Voucher </b></td>
                              <td align="right" class="text-white"><b>- {{ rupiah($potonganvoucher) }}</b></td>
                            </tr>
                          </table>
                      </div>

                    @else 

                      @php
                      $potonganvoucher = $voucher->amount;
                      @endphp
                        <div style="border-color: #fff;" class="alert alert-default bg-danger" role="alert">
                          <table width="100%">
                            <tr>
                              <td align="left"><b>Potongan Voucher </b></td>
                              <td align="right" class="text-white"><b>- {{ rupiah($potonganvoucher) }}</b></td>
                            </tr>
                          </table>
                      </div>

                    @endif

                  @else

                    @php
                    $potonganvoucher = 0;
                    @endphp

                  @endif

                @else
                  @php
                  $potonganvoucher = 0;
                  @endphp
                @endif

                <div style="border-color: #fff;" class="alert alert-default bg-iolo" role="alert">
                    <table width="100%">
                      <tr>
                        <td align="left"><b>Total Bayar : </b></td>
                        <td align="right" class="text-white"><b>{{ rupiah($harga - $potongan - $potonganvoucher) }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>

              <hr>
              <!-- <div align="center"><button onclick="KonfirmBayar({{ $cektrans->trans_id }})" type="button" class='btn btn-success'>Konfirmasi Bayar</button></div> -->
              <div class="row">
                <input type="hidden" id="transuuid" value="{{ $cektrans->trans_uuid }}">
              @if($harga != 0)
                <div class="col-6" style="padding-right:7.5px;">

                  @if($voucher)
                    @if($voucher->insentif == "yes")
                      <div align="center"><button onclick="AdaInsentif({{ $cektrans->trans_id }},1)" type="button" class='btn btn-block btn-success'>Bayar Via QRIS</button></div>
                    @else

                      @php
                      $cekmasihada = DB::table('voucher_details')
                      ->where("voucher_id", $voucher->id)
                      ->where("status", "selesai")
                      ->count();

                      @endphp

                      @if($voucher->total != NULL)
                        @if($voucher->total == $cekmasihada || $cekmasihada > $voucher->total)

                          <div align="center"><button type="button" onclick="VoucherHabis();" class='btn btn-block btn-success'>Bayar Via QRIS</button></div>

                        @else

                          <div align="center"><a class="menusxx" href="/reedem/showqris?uuid={{ $cektrans->trans_uuid }}"><button type="button" class='btn btn-block btn-success'>Bayar Via QRIS</button></a></div>

                        @endif

                      @else
                        <div align="center"><a class="menusxx" href="/reedem/showqris?uuid={{ $cektrans->trans_uuid }}"><button type="button" class='btn btn-block btn-success'>Bayar Via QRIS</button></a></div>

                      @endif

                    @endif
                  @else
                    <div align="center"><a class="menusxx" href="/reedem/showqris?uuid={{ $cektrans->trans_uuid }}"><button type="button" class='btn btn-block btn-success'>Bayar Via QRIS</button></a></div>
                  @endif
                  
                </div>

                <div class="col-6" style="padding-left:7.5px;">

                  @if($voucher)
                    @if($voucher->insentif == "yes")
                      <div align="center"><button onclick="AdaInsentif({{ $cektrans->trans_id }},2)" type="button" class='btn btn-block btn-warning'>Bayar CASH</button></div>
                    @else
                      <div align="center"><button onclick="BayarCashAja({{ $cektrans->trans_id }})" type="button" class='btn btn-block btn-warning'>Bayar CASH</button></div>
                    @endif
                  @else
                    <div align="center"><button onclick="BayarCashAja({{ $cektrans->trans_id }})" type="button" class='btn btn-block btn-warning'>Bayar CASH</button></div>
                  @endif

                </div>
              @else
                <div class="col-12">
                  <button onclick="KonfirmBayar({{ $cektrans->trans_id }})" type="button" class='btn btn-secondary btn-block'>Konfirmasi</button>
                </div>
              @endif  
              </div>  
            </div>
          </div>
          @endif
        </div>
        <br><br>
        @else

          <div class="container-fluid mt--9">
            <div class="row">
              <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <br>
                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img src="/assets/content/img/theme/error.jpg" width="100%">
                          <br>
                          <h6>Transaksi yang Anda cari tidak ditemukan</h6>
                        </td>
                      </tr>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>

        @endif

      @else
      <div class="container-fluid mt--9">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <br>
            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td align="center">
                      <img src="/assets/content/img/theme/error.jpg" width="100%">
                      <br>
                      <h6>Transaksi yang Anda cari tidak ditemukan</h6>
                    </td>
                  </tr>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
      @endif

    @else

      <div class="container-fluid mt--9">
        <div class="row">
          <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <br>
            <div class="card shadow">
              <div class="card-body">
                <div>Status Transaksi :</div>
                <div style="padding-top: 5px;font-size: 18px;"><b class="text-success">SELESAI</b></div>
                <hr>

                <div>Transaksi di Wilayah :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ $cekapproved->wilayah_name }}</div>
                <hr>

                <div>Waktu Reedem :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ date('d F Y H:i', strtotime($cekapproved->updated_at)) }}</div>
                <hr>

                <div>Nama User :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ $cekapproved->user_name }}</div>
                <hr>
                <div>
                  <a href="/home"><button class="btn btn-block btn-success">KEMBALI</button></a>
                </div>
              </div>
            </div>
            <br><br>
          </div>
        </div>
      </div>
    @endif

  @include('content.prosesreedem.modal')
  @include('layout.footer')

  <script type="text/javascript">

    function KonfirmBayar(id){

          $('#idx').val(id);

          $('#confirm_bayar').modal('show');
    }

    function AdaInsentif(id,num){

      $('#penjual').val('');


      if(num == 1){
        $('#tombolnya').html("<button type='button' class='btn btn-success' onclick='BayarQRISAja("+id+")'>Bayar Via QRIS</button>");
      } else {
        $('#tombolnya').html("<button type='button' onclick='BayarCashAja("+id+")' class='btn btn-primary'>Bayar Cash</button>");
      }

      $('#adainsentifnya').modal('show');

    }

    function AdaInsentifAmbil(id){

      $('#penjualnya').val('');

      $('#idcc').val(id);

      $('#adainsentifambilnya').modal('show');

    }

    function BayarQRISAja(id){

      var ins = $('#insentif').val();

      if(ins == "yes"){

        $.ajax({
          type: 'POST',
          url: "{{ route('reedem.penjual') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': id,
              'penjual': $('#penjual').val(),
          },
          success: function(data) {

          }

        });

      }

      var uuid = $('#transuuid').val();

      $('#tombolss').html("<a class='menusxx' href='/reedem/showqris?uuid="+uuid+"'><button type='button' class='btn btn-success'>Yakin</button></a>");

      $('#adainsentifnya').modal('hide');
      $('#confirmbayarqris').modal('show');
      
    }

    function BayarCashAja(id){

      var ins = $('#insentif').val();

      if(ins == "yes"){

        $.ajax({
          type: 'POST',
          url: "{{ route('reedem.penjual') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': id,
              'penjual': $('#penjual').val(),
          },
          success: function(data) {

          }

        });

      }

      $('#adainsentifnya').modal('hide');
      $('#idl').val(id);
      $('#confirmbayarcash').modal('show');
    }

    $('.modal-footer').on('click', '#cash_yakin', function() {

      $('#confirmbayarcash').modal('hide');

      $('.loading').attr('style','display: block');

      $.ajax({
        type: 'POST',
        url: "{{ route('reedem.bayarcash') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idl').val(),  
        },
        success: function(data) {

          if(data == 1){

            swal("Pembayaran sudah di lakukan CASH ke Petugas!", {
               icon: "success",
               buttons: false,
               timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/home'; }, 1500);

          } else if(data == 4){

            swal("Voucher Sudah Habis!", {
               icon: "error",
               buttons: false,
               timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/home'; }, 1500);

          } else if(data == 3){

            swal("Promo Tidak Berlaku di Wilayah ini!", {
               icon: "error",
               buttons: false,
               timer: 2000,
            });

            setTimeout(function(){ window.location.href = '/home'; }, 1500);

          } else {

            swal({
                title: "Beda Site/Outlet",
                text: "Pastikan Anda Membayar Cash di Site/Outlet yang Tepat!",
                icon: "error",
                buttons: false,
                timer: 3000,
            });

          }
        }

      });

    });

    $('.modal-footer').on('click', '#bayar_yakin', function() {

        $('#token').modal('show');
        $('#confirm_bayar').modal('hide');

    });

    $('#reedemtoken').on('click', function () {

      $('.loading').attr('style','display: block');
      $('#token').modal('hide');

      var tokens = $('#tokenusers').val();

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
              url: "{{ route('selesaibayar') }}",
              data: {
                  '_token': $('input[name=_token]').val(),
                  'trans_id': $('#idx').val(),
              },
              success: function(data) {

                if(data.status == '1'){

                  swal("Pembayaran ini sudah di Bayar sebelumnya!", {
                     icon: "error",
                     buttons: false,
                     timer: 2000,
                  });

                  setTimeout(function(){ window.location.href = '/home'; }, 1500);

                } else if(data.status == '2'){

                  swal({
                      title: "Beda Site/Outlet",
                      text: "Pastikan Anda Membayar Cash di Site/Outlet yang Tepat!",
                      icon: "error",
                      buttons: false,
                      timer: 3000,
                  });

                  setTimeout(function(){ window.location.href = '/home'; }, 1500);

                } else {

                  $.ajax({        
                      type : 'POST',
                      url : "https://fcm.googleapis.com/fcm/send",
                      headers : {
                          Authorization : 'key=' + 'AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6'
                      },
                      contentType : 'application/json',
                      dataType: 'json',
                      data: JSON.stringify({
                          "to": data.fcm, 
                          "notification": {
                              "title":"warungkoki.id - Pembayaran Berhasil!",
                              "body":"Hai "+data.name+", Terimakasih Anda Telah Membayar secara CASH!",
                              "icon": "https://warungkoki.id/assets/icon/96x96.png",
                          }
                      }),
                      success : function(response) {
                          console.log(response);
                      },
                      error : function(xhr, status, error) {
                          console.log(xhr.error);                   
                      }
                  });

                  swal("Pembayaran Users Berhasil!", {
                     icon: "success",
                     buttons: false,
                     timer: 2000,
                  });

                  setTimeout(function(){ window.location.href = '/home'; }, 1500);

                }
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
          
    function ReedemNow(){

      $('#confirm_reedem').modal('show');
      $('#adainsentifambilnya').modal('hide');

    }

    $('.modal-footer').on('click', '#reedem_yakin', function() {

      $('#confirm_reedem').modal('hide');
      $('#tokenreedem').modal('show');


    });

    $('#confirmreedemnow').on('click', function () {

      $('#tokenreedem').modal('hide');

      var ins = $('#insentif').val();
      var idnyas = $('#idcc').val();

      if(ins == "yes"){

        $.ajax({
          type: 'POST',
          url: "{{ route('reedem.penjual') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': idnyas,
              'penjual': $('#penjualnya').val(),
          },
          success: function(data) {

          }

        });

      }

      $.ajax({
        type: 'POST',
        url: "{{ route('validasitoken') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'token': $('#tokenusersreedem').val(),  
        },
        success: function(data) {

          if(data == '1'){

            var empty = 0;
            $('input.cek').each(function() {
                if($(this).val() == 1){
                  empty += 1;
                } else {
                  empty += 0;
                }

            });

            if (empty == 0) { 
                swal({
                    text: "Anda Harus Memilih Produknya!",
                    icon: "error",
                    buttons: false,
                    timer: 2000,
                });

            } else {

              var detail = [];

              $('.transdetail').each(function(){
                  detail.push($(this).val());
              });

              $('.loading').attr('style','display: block');

              $.ajax({
                type: 'POST',
                url: "{{ route('transaksireedem') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'trans_id': $('#trans_id').val(),
                    'transdetail_id': detail,
                    },

                success: function(data) {

                  if(data.status == 'kadaluarsa'){

                    swal({
                        title: "kadaluarsa",
                        text: "Transaksi Sudah di Reedem Sebelumnya!",
                        icon: "error",
                        buttons: false,
                        timer: 2000,
                    });

                    setTimeout(function(){ window.location.href = '/home'; }, 1500);
                    

                  } else if(data.status == 'bedawilayah'){

                    swal({
                        title: "Beda Site/Outlet",
                        text: "Pastikan Anda Menukarkan Saldo di Site/Outlet yang Tepat!",
                        icon: "error",
                        buttons: false,
                        timer: 2500,
                    });

                    setTimeout(function(){ window.location.href = '/home'; }, 1500);

                  } else if(data.status == 'belumselesai'){

                    swal({
                        title: "Berhasil",
                        text: "Transaksi Reedem Berhasil!",
                        icon: "success",
                        buttons: false,
                        timer: 2000,
                    });

                    setTimeout(function(){ window.location.href = '/home'; }, 1500);

                  } else {

                    $.ajax({        
                        type : 'POST',
                        url : "https://fcm.googleapis.com/fcm/send",
                        headers : {
                            Authorization : 'key=' + 'AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6'
                        },
                        contentType : 'application/json',
                        dataType: 'json',
                        data: JSON.stringify({
                            "to": data.fcm, 
                            "notification": {
                                "title":"Redeem Berhasil! - TOMX",
                                "body":"Anda Telah Berhasil Menyelesaikan Proses Reedem!",
                                "icon": "https://warungkoki.id/assets/icon/96x96.png",
                            }
                        }),
                        success : function(response) {
                            console.log(response);
                        },
                        error : function(xhr, status, error) {
                            console.log(xhr.error);                   
                        }
                    });

                    swal({
                        title: "Berhasil",
                        text: "Transaksi Reedem Berhasil!",
                        icon: "success",
                        buttons: false,
                        timer: 2000,
                    });

                    setTimeout(function(){ window.location.href = '/home'; }, 1500);

                  }

                }
              });

            }

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

    function Pilih(id){

      $('#all_'+id).attr('class','card shadow-ss bg-iolo');
      $('#button_'+id).html('<i class="fa fa-check" style="font-size: 18px;color: white;"></i>');
      $('#text_'+id).attr('style','color: white;');
      $('#all_'+id).attr('onclick','TidakPilih('+id+')');
      $('#value_'+id).html('<input type="hidden" class="transdetail" value="'+id+'">');
      $('#cekpilih_'+id).html('<input type="hidden" class="cek" value="1">');
    }

    function TidakPilih(id){

      $('#all_'+id).attr('class','card shadow-ss');
      $('#button_'+id).html('<i class="fa fa-circle" style="font-size: 18px;color: #b2b2b2;"></i>');
      $('#text_'+id).attr('style','');
      $('#all_'+id).attr('onclick','Pilih('+id+')');
      $('#value_'+id).html('');
      $('#cekpilih_'+id).html('<input type="hidden" class="cek">');

    }

    function Scan(id){

      $('.loading').attr('style','display: block');

      var scanner = $('#scanner_input').val();

      $.ajax({
        type: 'POST',
        url: "{{ route('scan.timbangan') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            'amount': scanner,  
        },
        success: function(data) {

          setTimeout(function(){ window.location.reload() }, 800);


        }

      });
    }

    function Hapus(id){

       $('.loading').attr('style','display: block');

      $.ajax({
        type: 'POST',
        url: "{{ route('scan.hapus') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id, 
        },
        success: function(data) {

          setTimeout(function(){ window.location.reload() }, 800);

        }

      });



    }

    function VoucherHabis(){

      swal({
            title: "Perhatian!",
            text: "Voucher Sudah Habis",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.href = '/home'; }, 1500);

      }


      
  </script>
</body>

</html>