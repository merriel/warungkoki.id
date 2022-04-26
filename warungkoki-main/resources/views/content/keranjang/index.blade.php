@include('layout.head')
<style type="text/css">
  .nav3 {
    position: fixed;
    bottom: 0;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 90px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 60px;
    margin-left: 1%;
    width: 90%;

}

</style>
<div class="main-content">
  <!-- Header -->
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <!-- <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
    <div class="ct-page-title">
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
              @if($kranjang->retailer_name == "")
              <div class="text-warning" style="font-size: 10px"><b>Lokasi : {{ $kranjang->wilayah_name }}</b></div>
              @else
              <div class="text-warning" style="font-size: 10px"><b>{{ $kranjang->retailer_name }}</b></div>
              @endif
                <div style="font-size: 13px"><b>{{ $kranjang->prod_name }} {{ $kranjang->name }}</b></div>
                @if($kranjang->jenis != 'kg')
                <h3 class="text-warning"><b>{{ rupiah($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100)) }}</b></h3>
                @else
                <table width="100%">
                  <tr>
                    <td><h3 class="text-warning"><b>{{ rupiah($kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100) * $kranjang->qty) }}</b></h3></td>
                    <td align="left" style="font-size:11px;">/{{ $kranjang->qty }} Kg</td>
                  </tr>
                </table>
                <input type="hidden" class="ids" value="{{ $kranjang->id }}">
                <input type="hidden" id="qtynow_{{ $kranjang->id }}" class="form-control counts" value="{{ $kranjang->qty }}">
                @endif
                
                
                @if($kranjang->jenis != 'kg')
                <table width="100%">
                  <tr>
                    <td align="center">
                      @if($kranjang->jenis == "promo")

                        @if($kranjang->min_qty != null)

                          @if($kranjang->qty > $kranjang->min_qty)
                            <button onclick="Minus({{ $kranjang->id }})" id="minus_{{ $kranjang->id }}" class="btn btn-sm btn-success menusxx" {{ $disabled }}><i class="fa fa-minus"></i></button>
                          @else
                            <button class="btn btn-sm btn-success menusxx" disabled><i class="fa fa-minus"></i></button>
                          @endif

                        @else
                          <button onclick="Minus({{ $kranjang->id }})" id="minus_{{ $kranjang->id }}" class="btn btn-sm btn-success menusxx" {{ $disabled }}><i class="fa fa-minus"></i></button>
                        @endif

                      @else
                        <button onclick="Minus({{ $kranjang->id }})" id="minus_{{ $kranjang->id }}" class="btn btn-sm btn-success menusxx" {{ $disabled }}><i class="fa fa-minus"></i></button>
                      @endif
                      
                    </td>
                    <td width="55%">

                        <input type="number" onkeyup="Qtys({{ $kranjang->id }})" id="qtyview_{{ $kranjang->id }}" class="form-control" value="{{ $kranjang->qty }}">
                        <input type="hidden" id="qtynow_{{ $kranjang->id }}" class="form-control counts" value="{{ $kranjang->qty }}">
                        <input type="hidden" class="ids" value="{{ $kranjang->id }}">
                        <input type="hidden" value="{{ $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100) }}" id="harga_{{ $kranjang->id }}">
                        <input type="hidden" value="0" id="service_{{ $kranjang->id }}">
                        <input type="hidden" class="grandtotal" value="{{ $kranjang->qty * $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100) }}" id="total_{{ $kranjang->id }}">
                    </td>
                    <td align="center">
                      @if($kranjang->jenis == "promo")

                        @if($kranjang->max_qty != NULL)

                          @if($kranjang->max_qty <= $kranjang->qty)
                            <button class="btn btn-sm btn-success disabled"><i class="fa fa-plus"></i></button>
                          @else
                            <button onclick="Plus({{ $kranjang->id }})" class="btn btn-sm btn-success menusxx"><i class="fa fa-plus"></i></button>
                          @endif

                        @else
                          <button onclick="Plus({{ $kranjang->id }})" class="btn btn-sm btn-success menusxx"><i class="fa fa-plus"></i></button>
                        @endif

                      @else
                        <button onclick="Plus({{ $kranjang->id }})" class="btn btn-sm btn-success menusxx"><i class="fa fa-plus"></i></button>
                      @endif
                        

                    </td>
                  </tr>
                </table>
                @endif
                
            </div>
            <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">

                <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveKeranjang({{ $kranjang->id }})"></span>
            </div>
            
          </div>
        </div>
      </div>
    </div>    
  </div>
            
  @php

  $total += $kranjang->qty * $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);

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
  <!-- ============= Voucer =========== -->
  @if($potongan)

  @php

      if($potongan->jenis == "cashback"){
        $potongannya = 0;
      } else {

        if($potongan->amount == NULL){
          $potongannya = $total * ($potongan->percent/100);
        } else {

          $potongannya = $potongan->amount;
        }
        
      }

  @endphp
  <hr>

    @if($potongan->type == "fixed")

    <div class="row">
      <div class="col-12" style="padding-bottom: 0px;">

        <a href="/keranjang/promo" class="menusxx"><button class="btn btn-block btn-secondary" style="font-size:12px;border-radius: 1rem;">
          <table width="100%">
            <tr>
              <td align="left" width="10%"><img src="/assets/content/img/icons/discount.png" width="100%"></td>
              <td align="left">
                &nbsp;&nbsp;&nbsp;Kamu bisa hemat <b>{{ rupiah($potongannya) }}</b>
                <div style="font-size:9px;color: #b0b3b9"><i>&nbsp;&nbsp;&nbsp;Promo {{ $potongan->name }} Dipakai</i></div>
              </td>
              <td align="right"><i style="font-size:16px;" class="fa fa-chevron-right"></i></td>
            </tr>
          </table>
        </button> </a>
      </div>
    </div>
    <br><br><br><br><br>

    @else

    <div class="row">
      <div class="col-12">
        <div class="card shadow-ss" style="border-radius:1rem;">
          <div class="card-body">
            <div class="row">
              <div class="col-10" style="padding-right: 0px;padding-bottom: 0px;">
                @if($potongan->jenis == "cashback")
                <div class="text-warning" style="font-size: 10px;"><b>Dapat Cashback :</b></div>
                @else
                <div class="text-warning" style="font-size: 10px;"><b>Potongan Voucher :</b></div>
                @endif
                 <div style="font-size: 13px"><b>{{ $potongan->name }} {{ $potongan->percent == NULL ? '' : '- '.$potongan->percent.'%' }}</b></div>
                  <h3 class="text-warning"><b>{{ rupiah($potongannya) }}</b></h3>
                  <input type="hidden" id="potongan" value="{{ $potongannya }}" name="">
              </div>
              <div class="col-2" style="padding-top: 20px;padding-bottom: 0px;">
                <span style="font-size: 30px" class="ni ni-fat-remove" onclick="RemoveVoucher({{ $potongan->kranjang_id }})"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br><br><br>

    @endif

  @endif
  @if($ada >= 1)
    @if(!$potongan)
    <!-- ======== Tombol Pencarian Voucher ========== -->
    <div class="row">
      <div class="col-12" style="padding-bottom: 0px;">
        <hr>
        <a href="/keranjang/promo" class="menusxx"><button class="btn btn-block btn-secondary" style="font-size:11px;border-radius: 1rem;">
          <table width="100%">
            <tr>
              <td align="left" width="10%"><img src="/assets/content/img/icons/discount.png" width="100%"></td>
              <td align="left">&nbsp;&nbsp;&nbsp;Cek ada promo menarik disini</td>
              <td align="right"><i style="font-size:16px;" class="fa fa-chevron-right"></i></td>
            </tr>
          </table>
        </button></a>
      </div>
      
      <div class="col-12">
        <br>
        <div class="card shadow-ss" style="border-radius:1rem;">
          <div class="card-body">
            <div class="row">
              <div class="col-9" style="padding-bottom: 0px;">
                
                <input type="text" id="kode" placeholder="Ada kode Voucher?" class="form-control">
                
              </div>
              <div class="col-3" style="padding-bottom: 0px;">
                <button onclick="SearchVoucher();" class="btn btn-info"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
    <br><br><br><br>
    @endif
  @endif
  @php

    if($potongan){

      $total = $total - $potongannya;

    } else{

      $total = $total;

    }

  @endphp
           
@include('content.keranjang.modal')
<nav class="nav3">

  <a href="#" class="nav__link menusxx">
    <div class="text-white" style="font-size: 10px;">Grand Total :</div> 
      <div class="text-white" style="font-size: 16px;"> 
        <b id="totalsemua">{{ rupiah($total) }}</b>
        <input type="hidden" id="name" value="{{ $userdetails->name }}">
        <input type="hidden" id="email" value="{{ $userdetails->email }}">
      </div>
  </a>
  <a href="#" class="nav__link menusxx">
    @if($kranjangs->count() == '0')
    <button class="btn btn-secondary" type="button" disabled>Checkout</button>
    @elseif($total == 0)
      <button onclick="KeranjangNol()" class="btn btn-sm btn-success" type="button">Finish</button>
    @else
      
        <button onclick="Checkout()" class="btn btn-sm btn-secondary pop" type="button">Checkout</button>
      
    @endif
  </a>
</nav>
@include('layout.footer')
@include('script.keranjang')

<script type="text/javascript">

  function Checkout(){

    $('#pilihmethod').modal('show');
  }

  $('#kode').val('');

  function angkaqty(e) {
    if (!/^[0-9]*\.?[0-9]*$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
    }
  }
  
  $('#bayarx').on('click', function () {

      $('#pilihmethod').modal('show');

  });

  function Nanti(numb){


      $('.loading').attr('style','display: block');

      $('#pilihmethod').modal('hide');

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
      } else if(numb == '1'){
        var method = 'No';
      } else {
        var method = 'Local';
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

          if(method == 'Yes'){

            setTimeout(function(){ window.location.href = '/users/bayar'; }, 500);

          } else if(method == 'Local'){

            setTimeout(function(){ window.location.href = '/xhome/kurirtoko'; }, 500);

          } else {

             setTimeout(function(){ window.location.href = '/xhome/delivery'; }, 500);
          }

          

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

  function Qtys(id){

    var qty = $('#qtyview_'+id).val();
    var harga = $('#harga_'+id).val();
    var service = $('#service_'+id).val();

    if(qty == "" || qty == 0){

      var total = qty;

    } else {

      var total = parseInt(qty);

    }  

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

        setTimeout(function(){ 

          $('#qtyview_'+id).val(data.qty);
          $('#qtynow_'+id).val(data.qty);

          $('.loading').attr('style','display: block');

        }, 1000);    

      }

    });

    //TotalQTY
    // $('#qtyview_'+id).val(total);
    // $('#qtynow_'+id).val(total);


    // //TotalHarga
    // var grandtotal = parseInt(total) * (parseInt(harga) + parseInt(service));
    // $('#total_'+id).val(grandtotal);

    // //HitungKeseluruhan
    // var sum = 0;
    // $(".grandtotal").each(function(){
    //     sum += +$(this).val();
    // });

    // //HitungKeseluruhanQty
    // var count = 0;
    // $(".counts").each(function(){
    //     count += +$(this).val();
    // });

    // //MasukinKeIconKeranjang
    // // $("#keranjangcount").html(count);
    // if(qty != ""){
    //   var reverse = sum.toString().split('').reverse().join(''),
    //     ribuan  = reverse.match(/\d{1,3}/g);
    //     ribuan  = ribuan.join('.').split('').reverse().join('');

    //   // Cetak hasil  
    //   $("#totalsemua").html('Rp '+ribuan);
    // }

    setTimeout(function(){ window.location.reload() }, 1500);

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

        setTimeout(function(){ 

          $('#qtyview_'+id).val(data.qty);
          $('#qtynow_'+id).val(data.qty);

          $('.loading').attr('style','display: block');

        }, 1500);

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

    setTimeout(function(){ window.location.reload() }, 1000);
 
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

        setTimeout(function(){ 

          $('#qtyview_'+id).val(data.qty);
          $('#qtynow_'+id).val(data.qty);

          $('.loading').attr('style','display: block');

        }, 1500);

      }

    });


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

    setTimeout(function(){ window.location.reload() }, 1000);

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
              text: "Voucher Expired, Tidak bisa Digunakan!",
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

        } else if (data == 3){

          swal({
              text: "Voucher tidak Berlaku pada Wilayah Tersebut!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        } else if (data == 4){

          swal({
              text: "Voucher tidak Berlaku untuk Produk tersebut!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);

        } else if (data == 5){

          swal({
              text: "Anda Sudah Menggunakan Voucher ini!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.reload() }, 1500);


        } else if (data == 6){

          swal({
              text: "Minimal Pembelian Belum Terpenuhi",
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

  function RemoveVoucher(id){

        $('#idv').val(id);

        $('#hapus_voucher').modal('show');

    }

  function HapusVoucher(){

    $('#hapus_voucher').modal('hide');

    $.ajax({
      type: 'POST',
      url: "{{ route('removekeranjang') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#idv').val(),  
      },
      success: function(data) {

        swal({
            title: "Berhasil",
            text: "Voucher Dalam Keranjang di Hapus!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.reload() }, 1500);

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

  function Alamat(){

    swal({
        title: "Alamat tidak ada!",
        text: "Harap isi Alamat/Lokasi Anda terlebih Dahulu!",
        icon: "warning",
        buttons: false,
        timer: 2000,
    });

    setTimeout(function(){ window.location.href = '/alamatuser'; }, 1500);


  }

  function CheckoutTutup(){

    swal({
        title: "Toko Tutup!",
        text: "Anda tidak bisa melakukan Checkout",
        icon: "error",
        buttons: false,
        timer: 2000,
    });

  }

</script>
</body>

</html>