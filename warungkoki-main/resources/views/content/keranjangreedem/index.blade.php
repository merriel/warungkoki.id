@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-7 pt-md-8">
        <!-- <a href="/home"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Keranjang Pengambilan</h1>
          </div>

          <!-- <div class="row">
            <div class="col-6" style="padding-right: 7.5px;">
              <div id="beli" class="card shadow-ss bg-iolo" onclick="COD();">
                <div class="card-body" style="padding-right: 13px; padding-left: 13px;">
                  <table width="100%">
                    <tr>
                      <td align="left">
                        <i class="fas fa-building" id="iconbeli" style="color: #fff;font-size: 32px;"></i>
                      </td>
                      <td width="12px"></td>
                      <td align="right"><div style="font-size: 12px" id="textbeli" class="text-white"><b>Ambil dilokasi</b></div></td>
                    </tr>
                    
                  </table>
                </div>
              </div>
            </div>

            <div class="col-6" style="padding-left: 7.5px;">
              <div id="reedem" class="card shadow-ss" onclick="Delivery();">
                <div class="card-body" style="padding-right: 13px; padding-left: 13px;">
                  <table width="100%">
                    <tr>
                      
                      <td align="left"><div id="textreedem" style="font-size: 12px"><b>Ambil Delivery</b></div></td>
                      <td width="12px"></td>
                      <td align="right">
                        <i class="fas fa-truck" id="iconreedem" style="color: #33b5e5;font-size: 32px;"></i>
                      </td>
                    </tr>
                    
                  </table>
                </div>
              </div>
            </div>
          </div> -->
          <!-- Card stats -->

          <div id="content-cod" style="display: block;">
          @if($keranjangs->count() != 0)

          <div class="row" >
            <div class="col-12">
              <div class="card shadow-ss bg-kuning">
                <div class="card-body" style="padding-bottom: 0.5rem;padding-top: 0.5rem;">
                  <div class="row">
                    <div class="col-12" style="padding-bottom: 0px;">
                      <table width="100%">
                        <tr>
                          <td colspan="2" class="text-white" style="font-size: 10px;" align="left">
                            <b><i>Catatan Tambahan : </i></b>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" class="text-white" style="font-size: 12px;"><b class="notes">{{ $ket ? $ket->ket : '-' }}</b></td>
                          <td align="right">
                            @if($tour->keranjangambil != 1)
                              <button onclick="Catatan()" class="btn btn-sm btn-secondary pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Tambahkan Catatan Pengambilan Disini"><i class="fa fa-edit"></i></button>
                            @else
                              <button onclick="Catatan()" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i></button>
                            @endif
                          </td>
                        </tr>
                      </table>
                      <hr>
                      <table width="100%">
                        <tr>
                          <td colspan="2" class="text-white" style="font-size: 10px;" align="left">
                            <b><i>Rencana Pengambilan Reedem : </i></b>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" class="text-white" style="font-size: 12px;"><b class="plan">{{ $ket ? date('d F Y H:i', strtotime($ket->plan)) : '-' }}</b></td>
                          <td align="right">
                            @if($tour->keranjangambil != 1)
                              <button onclick="PlanReedem()" class="btn btn-sm btn-secondary pop" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Berikan Waktu Rencana Pengambilan disini"><i class="fa fa-calendar"></i></button>
                            @else
                              <button onclick="PlanReedem()" class="btn btn-sm btn-secondary"><i class="fa fa-calendar"></i></button>
                            @endif
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            @foreach ($keranjangs as $keranjang)
            <div class="row">
              <div class="col-12">
                <div class="card shadow-ss">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-4" style="padding-bottom: 0px;">
                          <img width="100%" src="/assets/img_post/{{ $keranjang->img_name }}">
                          @if($keranjang->po == "yes")
                          <br><br>
                          <span class="badge badge-pill badge-primary" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
                          @endif
                      </div>
                      <div class="col-6" style="padding-bottom: 0px; padding-right: 0px;">
                          <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $keranjang->wilayah_name }}</b></div>
                          <div style="font-size: 10px">@ {{ rupiah($keranjang->harga_act) }}</div>
                          <div style="font-size: 14px"><b>{{ $keranjang->prod_name }} {{ $keranjang->post_name }}</b></div>
                          <div style="font-size: 9px">Mengambil saldo <b>{{ $keranjang->type }}</b> dari <b>{{ $keranjang->prod_name }} {{ $keranjang->post_name }}</b> sebesar</b> :</div>

                          <div class="text-warning" style="font-size: 25px"><b>{{ $keranjang->qty >=1000 ? rupiah($keranjang->qty) : $keranjang->qty }}</b></div>
                          <!-- <div><span class="badge badge-info" onclick="UpdateQty({{ $keranjang->id }})">Update Qty</span></div> -->
                      </div>
                      <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">
                          @if($tour->keranjangambil != 1)
                            <span style="font-size: 30px" class="ni ni-fat-remove pop" onclick="RemoveKeranjangReedem({{ $keranjang->id }})" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Remove/Kembalikan ke Saldo Produk"></span>
                          @else
                            <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveKeranjangReedem({{ $keranjang->id }})"></span>
                          @endif
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>    
            </div>

          @endforeach 

          @else
          <div class="row">
            <div class="col-12">
              <div class="card shadow-ss">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <table width="100%">
                        <tr>
                          <td align="center">
                            <img src="/assets/content/img/theme/nothing.jpg" width="90%">
                            <br>
                            <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                            <h6>Tidak ada Transaksi apapun di Keranjang ini, Ayo Belanja!</h6>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>

          @endif
        </div>

        <div id="content-delivery" style="display: none;">
          @if($deliveries->count() != 0)

          <div class="row" >
            <div class="col-12">
              <div class="card shadow-ss bg-kuning">
                <div class="card-body" style="padding-bottom: 0.5rem;padding-top: 0.5rem;">
                  <div class="row">
                    <div class="col-12" style="padding-bottom: 0px;">
                      <table width="100%">
                        <tr>
                          <td colspan="2" class="text-white" style="font-size: 10px;" align="left">
                            <b><i>Catatan Tambahan : </i></b>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" style="font-size: 12px;"><b class="notes">{{ $ket ? $ket->ket : '-' }}</b></td>
                          <td align="right">
                            <button onclick="Catatan()" class="btn btn-sm btn-secondary"><i class="fa fa-edit"></i></button>
                          </td>
                        </tr>
                      </table>
                      <hr>
                      <table width="100%">
                        <tr>
                          <td colspan="2" style="font-size: 10px;" class="text-white" align="left">
                            <b><i>Rencana Pengambilan Reedem : </i></b>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" style="font-size: 12px;"><b class="plan">{{ $ket ? date('d F Y H:i', strtotime($ket->plan)) : '-' }}</b></td>
                          <td align="right">
                            <button onclick="PlanReedem()" class="btn btn-sm btn-secondary"><i class="fa fa-calendar"></i></button>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

            @foreach ($deliveries as $delivery)
            <div class="row">
              <div class="col-12">
                <div class="card shadow-ss">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-4" style="padding-bottom: 0px;">
                          <img width="100%" src="/assets/img_post/{{ $delivery->img_name }}">
                          @if($delivery->po == "yes")
                          <br><br>
                          <span class="badge badge-pill badge-primary" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
                          @endif
                      </div>
                      <div class="col-6" style="padding-bottom: 0px; padding-right: 0px;">
                          <div class="text-warning" style="font-size: 10px"><b>Outlet : {{ $delivery->wilayah_name }}</b></div>
                          <div style="font-size: 10px">@ {{ rupiah($delivery->harga_act) }}</div>
                          <div style="font-size: 14px"><b>{{ $delivery->prod_name }}</b></div>
                          <div style="font-size: 9px">Mengambil saldo <b>{{ $delivery->type }}</b> dari <b>{{ $delivery->post_name }}</b> sebesar</b> :</div>
                          <div class="text-warning" style="font-size: 25px"><b>{{ $delivery->qty }}</b></div>
                          <!-- <div><span class="badge badge-info" onclick="UpdateQty({{ $delivery->id }})">Update Qty</span></div> -->
                      </div>
                      <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">
                          <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveKeranjangReedem({{ $delivery->id }})"></span>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>    
            </div>

          @endforeach 

          @else
          <div class="row">
            <div class="col-12">
              <div class="card shadow-ss">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <table width="100%">
                        <tr>
                          <td align="center">
                            <img src="/assets/content/img/theme/nothing.jpg" width="90%">
                            <br>
                            <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                            <h6>Tidak ada Transaksi apapun di Keranjang ini, Ayo Belanja!</h6>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>

          @endif
        </div>

        <div id="tombol-reedem-cod" style="display: block;">
          @if($keranjangs->count() != 0)
          <div class="container-fluid pt-md-8">
            <div class="row">
              <div class="col-12" style="padding: 0px;">
                <div class="card bg-iolo shadow-ss">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12" align="right" style="padding-bottom: 0px; padding-top: 10px;">
                          @if($tour->keranjangambil != 1)
                            <button onclick="ReedemNow();" class="btn btn-block btn-secondary pop" type="button" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Melanjutkan Proses Pengambilan disini">Ambil Sekarang</button>
                          @else
                            <button onclick="ReedemNow();" class="btn btn-block btn-secondary" type="button">Ambil Sekarang</button>
                          @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>

        <div id="tombol-reedem-delivery" style="display: none;">
        @if($deliveries->count() != 0)
        <footer id="footer" style="position: relative;">
          <div class="container-fluid pt-md-8">
            <div class="row">
              <div class="col-12" style="padding: 0px;">
                <div class="card bg-iolo shadow-ss">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12" align="right" style="padding-bottom: 0px; padding-top: 10px;">
                          <button onclick="TentukanAlamat();" class="btn btn-block btn-white" type="button">Tentukan Alamat</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </footer>
        @endif
      </div>
   
@include('content.keranjangreedem.modal')
@include('layout.footer')

<script type="text/javascript">
  
  $('#bayarx').on('click', function () {

      $('.loading').attr('style','display: block');

  });

  function RemoveKeranjangReedem(id){

    $('#id').val(id);

    $('#reedem_hapus').modal('show');

  }

  $('#confirm_yakin').on('click', function () {

    $('#reedem_hapus').modal('hide');

      $.ajax({
          type: 'POST',
          url: "{{ route('removekeranjangreedem') }}",
          data: {
              '_token': $('input[name=_token]').val(),
              'id': $('#id').val(),  
          },
          success: function(data) {

            swal({
                title: "Berhasil",
                text: "Produk Dalam Keranjang Ambil di Hapus!",
                icon: "success",
                buttons: false,
                timer: 2000,
            });

            setTimeout(function(){ window.location.reload() }, 1500);

          }

        });
  });

  function UpdateQty(id){

    $.ajax({
       type: 'POST',
       url: "{{ route('editqty') }}",
       data: {
            '_token': $('input[name=_token]').val(),
            'id': id
        },
       success: function(data) {

        $('#name').html(data.post_name);
        $('#qtyasli').html(data.qty);
        $('#qty').val(data.qty);
        $('#ids').val(id);

       }
   });

  $('#editqty').modal('show');

  }

  $('#ubah').on('click', function () {

      var empty = false;
      $('input.harus').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) {

          swal({
              title: "Warning!!",
              text: "Harap isi Isian Quantity",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

      } else {

          $('#editqty').modal('hide');

          $.ajax({
              type: 'POST',
              url: "{{ route('updateqty') }}",
              data: {
                  '_token': $('input[name=_token]').val(),
                  'qty': $('#qty').val(),
                  'id': $('#ids').val(),
                  
              },
              success: function(data) {

                  swal({
                      title: "Berhasil!",
                      text: "Qty Berhasil Diupdate",
                      icon: "success",
                      buttons: false,
                      timer: 2000,
                  });

                  setTimeout(function(){ window.location.reload() }, 1500);
              }

          });

      }

  });

  function Qty(){

    var qty = $('#qty').val();

    if(qty == 0){

      $('#qty').val(1);

    }

  }

  function ReedemNow(){

    //CekReedem
    $.ajax({
       type: 'GET',
       url: "{{ route('cekreedem') }}",
       success: function(data) {

        if(data.plan != '0'){

          //CekWilayah
          $.ajax({
             type: 'GET',
             url: "{{ route('cekwilayah') }}",
             success: function(datas) {

                if(datas > 1){

                    swal({
                        title: "Perhatian!",
                        text: "Pastikan Anda Ambil Di Wilayah Yang sama!",
                        icon: "error",
                        buttons: false,
                        timer: 2000,
                    });

                } else {

                  $('#reedem_confirm').modal('show');

                }

             }

          });

        } else {

          swal({
              title: "Perhatian!",
              text: "Tentukan Rencana Pengambilan Anda!",
              icon: "warning",
              buttons: false,
              timer: 2000,
          }); 
        }
      }
    });
  }

  $('#yakin_reedem').on('click', function () {

      $('#reedem_confirm').modal('hide');

      $('#token').modal('show');

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
              url: "{{ route('proseskeranjangreedem') }}",
               data: {
                  '_token': $('input[name=_token]').val(), 
              },
              success: function(data) {

                  swal({
                      title: "Berhasil!",
                      text: "Segera Selesaikan Pengambilan di Site Kami!",
                      icon: "success",
                      buttons: false,
                      timer: 2000,
                  });

                  var no = -1;
                  var content_data="";

                  $.each(data, function() {

                      no++;
                      var fcm = data[no]['fcm_token'];

                      $.ajax({        
                        type : 'POST',
                        url : "https://fcm.googleapis.com/fcm/send",
                        headers : {
                            Authorization : 'key=' + 'AAAA3hityDc:APA91bHSYyN1RWj8RAjOp87yjp6Z22MskaBe0soUt0cdQKq7XT7Z9hiMACpM1F0XjZ19zOI7M2hnn9T3z2GoTA3iZKpN00gkDTYOU0b69UZnFnbQYO_BvIJ9TgWTKq2duVlbNhgkKyCz'
                        },
                        contentType : 'application/json',
                        dataType: 'json',
                        data: JSON.stringify({
                            "to": fcm, 
                            "notification": {
                                "title":"TOMX NOTIFICATIONS!",
                                "body":"Ada User yang Membuat Reedem! Ayo Cek di Aplikasi kamu untuk Menyipkan Barang Tersebut! Semangats!",
                                "icon": "https://tomxperience.id/assets/icon/96x96.png",
                                "click_action": "https://tomxperience.id/reedemtoday",
                            }
                        }),
                        success : function(response) {
                            console.log(response);
                        },
                        error : function(xhr, status, error) {
                            console.log(xhr.error);                   
                        }
                      });

                  });

                  setTimeout(function(){ window.location.href = '/users/transaksi'; }, 1500);

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

  function Catatan(){

    $('#catatan').modal('show');

  }

  $('#simpancatatan').on('click', function () {

    var empty = false;
      $('textarea.wajib').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) {

          swal({
              title: "Warning!!",
              text: "Harap isi Catatan",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

      } else {

        $('#catatan').modal('hide');

        $.ajax({
          type: 'POST',
          url: "{{ route('tambahcatatan') }}",
           data: {
              '_token': $('input[name=_token]').val(), 
              'ket': $('#keterangan').val(),
          },
          success: function(data) {

              $('.notes').html(data);

          }

        });

      }

  });

  function COD(){

    $('#beli').attr("class","card shadow-ss bg-iolo");
    $('#reedem').attr("class","card shadow-ss");

    $('#textbeli').attr("class","text-white");
    $('#textreedem').attr("class","");

    $('#iconbeli').attr("style","color: #fff;font-size: 32px;");
    $('#iconreedem').attr("style","color: #33b5e5;font-size: 32px;");

    $('#content-cod').attr("style","display: block;");
    $('#content-delivery').attr("style","display: none;");

    $('#tombol-reedem-cod').attr("style","display: block;");
    $('#tombol-reedem-delivery').attr("style","display: none;");

  }

  function Delivery(){

    $('#reedem').attr("class","card shadow-ss bg-iolo");
    $('#beli').attr("class","card shadow-ss");

    $('#textreedem').attr("class","text-white");
    $('#textbeli').attr("class","");

    $('#iconreedem').attr("style","color: #fff;font-size: 32px;");
    $('#iconbeli').attr("style","color: #33b5e5;font-size: 32px;");

    $('#content-cod').attr("style","display: none;");
    $('#content-delivery').attr("style","display: block;");

    $('#tombol-reedem-cod').attr("style","display: none;");
    $('#tombol-reedem-delivery').attr("style","display: block;");

  }

  function PlanReedem(){

    $('#planing').modal('show');

  }

  $('#simpanplan').on('click', function () {

    var empty = false;
      $('input.plans').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) {

          swal({
            title: "Warning!!",
            text: "Harap isi Tanggal dan Waktu Pengambilan",
            icon: "error",
            buttons: false,
            timer: 2000,
          });

      } else {

        $('#planing').modal('hide');

        $.ajax({
          type: 'POST',
          url: "{{ route('planreedem') }}",
           data: {
              '_token': $('input[name=_token]').val(), 
              'tgl': $('#tgl').val(),
              'jam': $('#jam').val(),
          },
          success: function(data) {

              if(data.status == '0'){

                if(data.po != '0'){

                  if(data.waktu != '0'){

                    $('.plan').html(data.hari);

                  } else {

                    swal({
                      title: "Warning!!",
                      text: "Tanggal Pengambilan Harus Sesuai dengan Jam Operational Outlet yaitu Jam "+data.masuk+" - "+data.tutup+"",
                      icon: "error",
                      buttons: false,
                      timer: 3000,
                    });

                  }

                } else {

                  swal({
                    title: "Warning!!",
                    text: "Barang yang Memiliki Tanda PO Tidak Bisa Melakukan Reedem Hari ini, Diharuskan Kesokan Harinya!",
                    icon: "error",
                    buttons: false,
                    timer: 3000,
                  });

                }

              } else {

                  swal({
                    title: "Warning!!",
                    text: "Tanggal & Waktu Pengambilan Harus Lebih Besar dari Tanggal & Waktu Sekarang!",
                    icon: "error",
                    buttons: false,
                    timer: 3000,
                  });
              }
          }

        });

      }

  });

  function TentukanAlamat(){

    var reedem = $('#tgl').val();

    if(reedem == ''){

        swal({
            title: "Warning!",
            text: "Tentukan Rencana Pengambilan Anda!",
            icon: "warning",
            buttons: false,
            timer: 2000,
        });

    } else {

      setTimeout(function(){ window.location.href = '/alamatuser'; }, 400);

    }

  }

</script>
</body>

</html>