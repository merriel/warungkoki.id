@include('bazaar.layouts.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 4.8rem;">
        <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          <div class="ct-page-title" style="border-left: 2px solid #c34468">
            <h1 class="ct-title" id="content">Keranjang Anda</h1>
          </div>
          <!-- Card stats -->
          @php

          $total = 0;
          if($ada >= 1){
          @endphp
          @foreach ($kranjangs as $kranjang)

          @php

          if($kranjang->qty == '1'){

            $disabled = 'disabled';

          } else {

            $disabled = '';

          }

          @endphp
          <div class="row">
            <div class="col-12">
              <div class="card shadow-ss">
                <div class="card-body">
                  <div class="row">
                    <div class="col-4" style="padding-bottom: 0px;">
                        <img width="100%" src="/assets/img_post/{{ $kranjang->img }}">
                    </div>
                    <div class="col-6" style="padding-bottom: 0px; padding-right: 0px;">
                      <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $kranjang->wilayah_name }}</b></div>
                        <div style="font-size: 13px"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                        <h3 class="text-warning"><b>{{ rupiah($kranjang->harga_act + ceil($kranjang->harga_act * (float)$service->biaya / 100)) }}</b></h3>
                        <table width="100%">
                          <tr>
                            <td align="center">
                              <button onclick="Minus({{ $kranjang->id }})" id="minus_{{ $kranjang->id }}" class="btn btn-sm btn-success menusxx" {{ $disabled }}><i class="fa fa-minus"></i></button>
                            </td>
                            <td width="40%">
                              <input type="text" id="qtyview_{{ $kranjang->id }}" class="form-control" value="{{ $kranjang->qty }}" disabled>
                              <input type="hidden" id="qtynow_{{ $kranjang->id }}" class="form-control counts" value="{{ $kranjang->qty }}">
                              <input type="hidden" class="ids" value="{{ $kranjang->id }}">
                              <input type="hidden" value="{{ $kranjang->harga_act }}" id="harga_{{ $kranjang->id }}">
                              <input type="hidden" value="{{ ceil($kranjang->harga_act * (float)$service->biaya / 100) }}" id="service_{{ $kranjang->id }}">
                              <input type="hidden" class="grandtotal" value="{{ $kranjang->qty * ($kranjang->harga_act + ceil($kranjang->harga_act * (float)$service->biaya / 100)) }}" id="total_{{ $kranjang->id }}">
                            </td>
                            <td align="center">
                              @if(!$adatrans)
                              <button onclick="Plus({{ $kranjang->id }})" class="btn btn-sm btn-success pop menusxx" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Tambah Qty"><i class="fa fa-plus"></i></button>
                              @else
                              <button onclick="Plus({{ $kranjang->id }})" class="btn btn-sm btn-success menusxx"><i class="fa fa-plus"></i></button>
                              @endif
                            </td>
                          </tr>
                        </table>
                        
                    </div>
                    <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">
                        @if(!$adatrans)
                        <span style="font-size: 30px" class="ni ni-fat-remove pop" onclick="RemoveKeranjang({{ $kranjang->id }})" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Hapus Produk dari keranjang"></span>
                        @else
                        <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveKeranjang({{ $kranjang->id }})"></span>
                        @endif
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>    
          </div>
          
            @php

            $total += $kranjang->qty * ($kranjang->harga_act + ceil($kranjang->harga_act * (float)$service->biaya / 100));

            @endphp
          @endforeach 
          @php
          } else {
          @endphp
          <div class="row">
            <div class="col-12">
              <div class="card shadow">
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
          @php
          }
          @endphp
          

          <div class="row">
            <div class="col-12" style="padding-bottom: 0px;">
              <div class="card bg-bazaar">
                <div class="card-body">
                  <div class="row">
                    <div class="col-6" style="padding-bottom: 0px;">
                      <h5 class="text-white"> <b>Total :</b></h5>
                      <h2 class="text-white"> <b id="totalsemua">{{ rupiah($total) }}</b></h2>
                      <input type="hidden" id="amount" value="{{ $total }}">
                      <input type="hidden" id="name" value="{{ $userdetails->name }}">
                      <input type="hidden" id="email" value="{{ $userdetails->email }}">
                    </div>
                    <div class="col-6" align="right" style="padding-bottom: 0px; padding-top: 10px;">
                      @if($kranjangs->count() == '0')
                      <button class="btn btn-secondary" type="button" disabled>Checkout</button>
                      @elseif($total == 0)
                        <button onclick="KeranjangNol()" class="btn btn-success" type="button">Finish</button>
                      @else
                        @if(!$adatrans)
                        <button id="bayarz" class="btn btn-secondary pop" type="button" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Untuk Menyelesaikan Pesanan Anda disini">Checkout</button>
                        @else
                        <button id="bayarz" class="btn btn-secondary pop" type="button">Checkout</button>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           
@include('content.keranjang.modal')
@include('bazaar.layouts.footer')
@include('script.keranjang')

<script type="text/javascript">

  $('#kode').val('');

  function angkaqty(e) {
    if (!/^[0-9]*\.?[0-9]*$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
    }
  }
  
  $('#bayarz').on('click', function () {

      $('#pilihmethodbazaar').modal('show');

  });

  function Nanti(numb){


      $('.loading').attr('style','display: block');

      $('#pilihmethodbazaar').modal('hide');

      var qty = [];
      var id = [];

      $('.counts').each(function(){
          qty.push($(this).val());
      });

      $('.ids').each(function(){
          id.push($(this).val());
      });

      if(numb == '0'){
        var method = 'Yes';
      } else {
        var method = 'No';
      }

      $.ajax({
         type: 'POST',
         url: "{{ route('updatekeranjang') }}",
         data: {
              '_token': $('input[name=_token]').val(),
              'id': id,
              'qty': qty,
              'method': method,
          },
         success: function(data) {

          setTimeout(function(){ window.location.href = '/bazaar/bayar'; }, 500);

        }

      });

  }

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

  function Minus(id){

    var qty = $('#qtynow_'+id).val();
    var harga = $('#harga_'+id).val();
    var service = $('#service_'+id).val();

    var total = parseInt(qty) - 1;

    if(total == '1'){
      $('#minus_'+id).attr("disabled", "disabled");
    } else {

      $('#minus_'+id).removeAttr("disabled");

    }

    $.ajax({
      type: 'POST',
      url: "{{ route('keranjang.min') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'qty': total,
          'id': id,
      },
      success: function(data) {

        setTimeout(function(){ window.location.reload() }, 10);

      }

    });

    $('#qtyview_'+id).val(total);
    $('#qtynow_'+id).val(total);

    var grandtotal = parseInt(total) * (parseInt(harga) + parseInt(service));

    $('#total_'+id).val(grandtotal);

    var sum = 0;
    $(".grandtotal").each(function(){
        sum += +$(this).val();
    });

    var count = 0;
    $(".counts").each(function(){
        count += +$(this).val();
    });

    // $("#keranjangcount").html(count);

    var reverse = sum.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');

    // Cetak hasil  
    $("#totalsemua").html('Rp '+ribuan);
    $("#amount").val(sum);



  }

  function Plus(id){

    var qty = $('#qtynow_'+id).val();
    var harga = $('#harga_'+id).val();
    var service = $('#service_'+id).val();

    var total = parseInt(qty) + 1;

    if(total == '1'){
      $('#minus_'+id).attr("disabled", "disabled");
    } else {

      $('#minus_'+id).removeAttr("disabled");

    }

    $.ajax({
      type: 'POST',
      url: "{{ route('keranjang.min') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'qty': total,
          'id': id,
      },
      success: function(data) {

        setTimeout(function(){ window.location.reload() }, 10);

      }

    });

    //TotalQTY
    $('#qtyview_'+id).val(total);
    $('#qtynow_'+id).val(total);


    //TotalHarga
    var grandtotal = parseInt(total) * (parseInt(harga) + parseInt(service));
    $('#total_'+id).val(grandtotal);

    //HitungKeseluruhan
    var sum = 0;
    $(".grandtotal").each(function(){
        sum += +$(this).val();
    });

    //HitungKeseluruhanQty
    var count = 0;
    $(".counts").each(function(){
        count += +$(this).val();
    });

    //MasukinKeIconKeranjang
    // $("#keranjangcount").html(count);

    var reverse = sum.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');

    // Cetak hasil  
    $("#totalsemua").html('Rp '+ribuan);
    $("#amount").val(sum);

  }

  function SearchVoucher(){

    $.ajax({
      type: 'POST',
      url: "{{ route('keranjang.voucher') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'kode': $('#kode').val(),
      },
      success: function(data) {

        if(data == 0){

          swal({
              text: "Voucher tidak bisa di Gunakan!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        } else if (data == 2){

          swal({
              text: "Kode Voucher Tersebut tidak ada!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        } else {

          swal({
              text: "Voucher Berhasil digunakan!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);


        }

      }

    });

  }


    function KeranjangNol(){

      $('#pilihambil').modal('show');

    }


    function Ambil(numb){

      $('#pilihambil').modal('hide');
      $('#token').modal('show');

      if(numb == 0){
        $('#reedem').val('Yes');
      } else {
        $('#reedem').val('No');
      }

    }

    function Confirm(){

      $('.loading').attr('style','display: block');
      $('#token').modal('hide');

      var tokens = $('#tokennya').val();

      $.ajax({
        type: 'POST',
        url: "{{ route('validasitoken') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'token': $('#tokennya').val(),  
        },
        success: function(data) {

          if(data == '1'){

            $.ajax({
              type: 'POST',
              url: "{{ route('keranjang.nolbayar') }}",
              data: {
                  '_token': $('input[name=_token]').val(),
                  'reedem': $('#reedem').val(),  
              },
              success: function(data) {

                  if(data.reedem == 'Yes'){

                      $.ajax({
                        type: 'POST',
                        url: "{{ route('notif.petugas') }}",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'wilayah_id': data.wilayah_id,
                        },
                        success: function(data) {

                          var no = -1;

                          $.each(data, function() {

                              no++;
                              var fcm = data[no]['fcm_token'];
                              var name = data[no]['name'];

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
                                        "title":"HALO "+name+"!",
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

                        }

                      });

                  }

                  swal("Pembayaran Users Berhasil!", {
                     icon: "success",
                     buttons: false,
                     timer: 2000,
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

    }

</script>
</body>

</html>