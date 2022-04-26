@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 19rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/users/transaksi"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="row justify-content-center">
              <h3>Rincian Transaksi {{ $jenis }}</h3>   
          </div>
          <br>

          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Customer Name :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b>{{ $trans->username }}</b></div>
                <hr>

                <b>Tanggal Pembelian :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                <hr>

                @if($trans->jam != null)
                <b>Rencana Jam Pengiriman :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b style="font-size: 14px;">{{ $trans->jam }}</b></div>
                <hr>
                @endif
              </div>

                <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->

              <div><b>Produk yang di Beli :</b></div><br>
              @php $total=0; @endphp
              @foreach($saldos as $saldo)

                @php
                $total += $saldo->amount;

                @endphp
                <div class="card shadow-ss" style="margin-bottom: 6px;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" width="65%"><b>{{ $saldo->qty  }} {{ $saldo->prod_name }} {{ $saldo->name }} @ {{ rupiah($saldo->amount / $saldo->qty) }}</b></td>
                          <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->amount)  }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>
              @endforeach
              <div class="card shadow-ss" style="margin-bottom: 6px;">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" width="65%"><b>{{ strtoupper($saldo->delivery_name) }} {{ strtoupper($saldo->delivery_type) }}</b></td>
                        <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              <div class="card shadow-ss bg-iolo">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" class="text-white">TOTAL</td>
                        <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              <hr>
              <b>Dikirim Ke :</b>
              <br>
              <div style="padding-top: 5px;">
                {{ $trans->penerima }} ({{ $trans->nohp }})
                <div>{{ $trans->alamat }}  Kecamatan {{ $trans->district_name }} {{ $trans->regency_name }} Provinsi {{ $trans->prov_name }} {{ $trans->postal_code }}</div>
              </div>
              <hr>
              <b>Status :</b>
              <br>
              @if($trans->status == "ALLOCATED" || $trans->status == "CONFIRMED")
                @if($trans->delivery_name == "kurirtoko")
                <div style="padding-top: 5px;" class="text-warning"><b>Sedang Di Proses Oleh Kurir Toko</b></div>
                @else
                <div style="padding-top: 5px;" class="text-warning"><b>Proses Pencarian Driver</b></div>
                @endif
              @elseif($trans->status == "PICKING_UP" || $trans->status == "PICKED")
                <div style="padding-top: 5px;" class="text-warning"><b>Kurir sedang dalam Proses Penjemputan</b></div>
              @elseif($trans->status == "DROPPING_OFF")
                <div style="padding-top: 5px;" class="text-warning"><b>Barang sedang proses pengantaran ke Pelanggan</b></div>
              @elseif($trans->status == "DIPROSES")
                <div style="padding-top: 5px;" class="text-warning"><b>Barang Sedang disiapkan oleh Petugas </b></div> 
              @else
                <div style="padding-top: 5px;" class="text-warning"><b>Barang Sudah sampai ke Pelanggan </b></div> 
              @endif
              
              <hr>
              @if($trans->status != "DIPROSES")

                @php
                  $delv = DB::table('transaction_delivery')
                  ->select("transaction_delivery.*", "users.name as user_name","users.no_hp")
                  ->leftJoin("users", "transaction_delivery.user_id", "=", "users.id")
                  ->where('transaction_id', $trans->id)
                  ->first();

                @endphp

              @if($delv)

              <b>Kurir :</b>
              <br>
              <div style="padding-top: 5px;">{{ $delv->user_name }} ({{ $delv->no_hp }})</div>
              <hr>
              <b>Foto Proses Delivery :</b>
              <br>
              <div style="padding-top: 8px;">
                <img width="100%" src="/assets/img_delivery/{{ $delv->photo }}">
              </div>
              <hr>
              @endif
              @endif
            </div>
          </div><br>
          @if($trans->status == "DIPROSES")
              <button onclick="Proses({{ $trans->id }})" class="btn btn-success btn-block"> Proses Delivery</button>

              <button onclick="Cancel({{ $trans->id }})" class="btn btn-danger btn-block"> Cancel Delivery</button>
          @endif

          @if($trans->status == "ALLOCATED" && $trans->delivery_name == "kurirtoko")
            <button onclick="KirimNow({{ $trans->id }})" class="btn btn-success btn-block"> Kirim Sekarang</button>
          @endif

          @if($trans->status == "DROPPING_OFF" && $trans->delivery_name == "kurirtoko")
            <button onclick="Selesai({{ $trans->id }})" class="btn btn-success btn-block"> Pengiriman Selesai</button>
          @endif
        </div>
      </div>
    </div>
    <br><br>
  @include('layout.footer')
  @include('xhome.petugas.modal')
</body>

<script type="text/javascript">

  function Proses(id){

    $('#idx').val(id);
  
    $('#proses').modal('show');

  }

  function KirimNow(id){

    $('#idp').val(id);
  
    $('#proses2').modal('show');

  }

  function Cancel(id){

    $('#idc').val(id);
  
    $('#cancel').modal('show');

  }

  function Selesai(id){

    $('#ids').val(id);
  
    $('#selesai').modal('show');

  }

  $(".uploadfoto1").on("change", function() {

    $('.loading').attr('style','display: block');
    $('#proses2').modal('hide');

    var formData = new FormData();
    formData.append('file', $('.uploadfoto1')[0].files[0]);

    $.ajax({
        url: "{{ route('xhome.upload') }}",
        method:"POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,

        success:function(data) {

            if(data.status == '1'){

                $('.loading').attr('style','display: none');
                $('#proses2').modal('show');

                $('#foto1').html("<img width='100%' src='/assets/img_delivery/"+data.name+"'><hr>"); 
                $('#img1').val(data.name);
                $('#img1').attr("class", "imgs");
                $('#akhirtombol1').attr("style","display: block;");
                $('#awaltombol1').attr("style","display: none;"); 

            } else {

                $('.loading').attr('style','display: none');
                $('#selesai').modal('show');

                swal({
                    title: "Gagal!",
                    text: "Pastikan File yang Anda Upload Benar!",
                    icon: "error",
                    buttons: false,
                    timer: 2000,
                });

                
            }
        }
    });

  });

  $(".uploadfoto2").on("change", function() {

    $('.loading').attr('style','display: block');
    $('#selesai').modal('hide');

    var formData = new FormData();
    formData.append('file', $('.uploadfoto2')[0].files[0]);

    $.ajax({
        url: "{{ route('xhome.upload') }}",
        method:"POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,

        success:function(data) {

            if(data.status == '1'){

                $('.loading').attr('style','display: none');
                $('#selesai').modal('show');

                $('#foto2').html("<img width='100%' src='/assets/img_delivery/"+data.name+"'><hr>"); 
                $('#img2').val(data.name);
                $('#img2').attr("class", "imgs");
                $('#akhirtombol2').attr("style","display: block;");
                $('#awaltombol2').attr("style","display: none;"); 

            } else {

                $('.loading').attr('style','display: none');
                $('#selesai').modal('show');

                swal({
                    title: "Gagal!",
                    text: "Pastikan File yang Anda Upload Benar!",
                    icon: "error",
                    buttons: false,
                    timer: 2000,
                });

                
            }
        }
    });

  });

  function Batalkan(){
  
    $('#cancel').modal('hide');

    $('#konfirmcancel').modal('show');

  }

  function YakinBatal(){

    $('.loading').attr('style','display: block');

    $('#konfirmcancel').modal('hide');
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xhome.petugas.cancel') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#idc').val(),
          'ket': $('#ket').val(),
      },
     success: function(data) {

      swal({
          title: "Berhasil",
          text: "Pesanan Dibatalkan!",
          icon: "success",
          buttons: false,
          timer: 2000,
      });

      setTimeout(function(){ window.location.href = '/home/'; }, 1500);

     }

   });

  }

  function HapusNew(img){

      $('#akhirtombol'+img).attr("style","display: none;");
      $('#awaltombol'+img).attr("style","display: block;");
      $('#foto'+img).html('');
      $('#img'+img).val('');
      $('#img'+img).attr("class", "");
  }

  function Simpan(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xhome.petugas.proses') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#idx').val(),
          'name': $('#name').val(),
          'nohp': $('#nohp').val(),
          'img': $('#img1').val(),
      },
     success: function(data) {

      swal({
          title: "Berhasil",
          text: "Pesanan Dalam Proses Delivery!",
          icon: "success",
          buttons: false,
          timer: 2000,
      });

      setTimeout(function(){ window.location.href = '/home/'; }, 1500);

     }

   });

  }

  function SimpanProses(){

    if($('#img1').val() == ""){

      swal({
            title: "Perhatian",
            text: "Harap Foto Terlebih Dahulu!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

    } else {

      $('#proses2').modal('hide');
  
      $.ajax({
       type: 'POST',
       url: "{{ route('xhome.kurir.proses') }}",
       data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idp').val(),
            'img': $('#img1').val(),
        },
       success: function(data) {

        swal({
            title: "Berhasil",
            text: "Pesanan Berhasil di Proses!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.href = '/home'; }, 1500);

       }
     });
    }
  }

  function SimpanSelesai(){

    if($('#img2').val() == ""){

      swal({
            title: "Perhatian",
            text: "Harap Foto Terlebih Dahulu!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

    } else {

      $('#selesai').modal('hide');
  
      $.ajax({
       type: 'POST',
       url: "{{ route('xhome.kurir.selesai') }}",
       data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#ids').val(),
            'img': $('#img2').val(),
        },
       success: function(data) {

        swal({
            title: "Berhasil",
            text: "Pesanan Anda sudah Selesai!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.href = '/home'; }, 1500);

       }

     });

    }
  }

</script>

</html>