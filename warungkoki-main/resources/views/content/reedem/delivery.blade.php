@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-3 pt-md-8">
    <a href="/home"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a>
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Reedem Delivery</h1>
      </div>

      <!-- Card stats -->
      @if($transs->count() == '0')
        <div class="card shadow">
          <div class="card-body">
            <table width="100%" border="0">
              <tr>
                <td><h6>Belum ada Reedem Delivery apapun untuk saat ini!</h6></td>
              </tr>
            </table>
          </div>
        </div>
        <br>
      @else
      
        @foreach($transs as $trans)
      <div class="card shadow tombol" id="content_{{ $trans->id }}"  onclick="AksiDelivery({{ $trans->id }})">
        <div class="card-body">
          <table width="100%" border="0">
            <tr>
              <td width="25%" rowspan="4">
                <div class="icon icon-shape bg-iolo text-white rounded-circle shadow">
                  <i class="fas fa-handshake" style="color: #ffffff"></i>
              </div>
              </td>
              <td><b><div style="font-size: 17px"></div></b></td>
            </tr>

            @php

              $users = DB::table('transactions')
              ->select("users.*")
              ->leftJoin("users", "transactions.user_id", "=", "users.id")
              ->where("transactions.id", $trans->id)
              ->first();

              $details = DB::table('transaction_details')
              ->select("product.name")
               ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
              ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
              ->distinct()
              ->where("transactions.id", $trans->id)
              ->get();

            @endphp
            <tr>
              <td>
                <div class="text-warning" style="font-size: 14px; color: black;"><b>@foreach($details as $detail) {{ $detail->name }}, @endforeach</b></div>
                <input type="hidden" id="tglplan_{{ $trans->id }}" value="{{ date('Y-m-d', strtotime($trans->plan)) }}">
                <input type="hidden" id="jamplan_{{ $trans->id }}" value="{{ date('H:i', strtotime($trans->plan)) }}">
              </td>
            </tr>
            <tr>
              <td>
                <div style="font-size: 13px;color: black;padding-bottom: 5px;">
                  <b>{{ date('d M Y', strtotime($trans->created_at)) }} | {{ $details->count() }} Produk</b><br>
                  @if($trans->plan != '' || $trans->plan != NULL)
                    <div style="font-size: 10px;">Rencana Reedem : <b>{{ date('d F Y H:i', strtotime($trans->plan)) }}</b></div><hr style="margin-bottom: 0.3rem;margin-top: 0.3rem;">
                  @endif
                  @if($trans->ket != '' || $trans->ket != NULL)
                    <div style="font-size: 10px;">Keterangan : <b>{{ $trans->ket }}</b></div><hr style="margin-bottom: 0.3rem;margin-top: 0.3rem;">
                  @endif
                  <div style="font-size: 10px;">Lokasi Pengiriman : <b>({{ $trans->judul }}) - {{ $trans->alamat }} {{ $trans->regency_name }} PROVINSI {{ $trans->prov_name }} ({{ $users->no_hp }})</b></div>
                </div>
                
              </td>
            </tr>
            <tr>
              <td>
                <span class="badge badge-success"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $users->name }}</span>  
                <span class="badge badge-info"><i class="fa fa-home"></i>&nbsp;&nbsp;{{ $trans->wilayah_name }}</span>  
              </td>
            </tr>
          </table>

          @if($trans->status == 'REEDEM')
          <div style="display: none;" class="isinya" id="isi_{{ $trans->id }}">
            <hr>
            <table width="100%">
              <tr>
                <td>
                  <div style="padding-bottom: 6px;">
                    <button class="btn btn-success btn-block" onclick="Setuju({{ $trans->id }});"><i class="fa fa-check"></i>&nbsp;&nbsp;Setujui Delivery</button>
                  </div>
                  <div style="padding-bottom: 6px;">
                    <button class="btn btn-danger btn-block" onclick="Tolak({{ $trans->id }});"><i class="fa fa-times"></i>&nbsp;&nbsp;Tolak Delivery</button>
                  </div>
                  <div style="padding-bottom: 6px;">
                    <a href="https://api.whatsapp.com/send?phone={{ $users->no_hp }}"><button class="btn btn-primary btn-block"><i class="fa fa-comment"></i>&nbsp;&nbsp;Whatsapp User</button></a>
                  </div>
                  <div style="padding-bottom: 6px;">
                    <a href="tel:{{ $users->no_hp }}"><button class="btn btn-info btn-block"><i class="fa fa-phone"></i>&nbsp;&nbsp;Telepon User</button></a>
                  </div>
                </td>
            </table>
          </div>
          @else
          <hr>
          <table width="100%">
            <tr>
              @if($trans->status == 'REEDEM DISETUJUI')
              <td><h6>Transaksi Reedem Delivery ini sudah Anda <b>SETUJUI</b>!</h6></td>
              @elseif($trans->status == 'REEDEM DITOLAK')
              <td><h6>Transaksi Reedem Delivery ini sudah Anda <b>TOLAK</b>!</h6></td>
              @endif
            </tr>
          </table>
          @endif
        </div>
      </div>
      <br>
  @endforeach

  @endif

  </div>
</div>

@include('content.reedem.modal')       
@include('layout.footer')
<script type="text/javascript">
    
    function AksiDelivery(id){

      $('.isinya').attr("style","display: none;");

      $('#isi_'+id).attr("style","display: block;");
      $('#content_'+id).attr("onclick","TutupDelivery("+id+")");

    }

    function TutupDelivery(id){

      $('.isinya').attr("style","display: none;");

      $('#isi_'+id).attr("style","display: none;");
      $('#content_'+id).attr("onclick","AksiDelivery("+id+")");

    }

    function Setuju(id){

      $('#idplan').val(id);
      var tgl = $('#tglplan_'+id).val();
      var jam = $('#jamplan_'+id).val();

      $('#tgl').val(tgl);
      $('#jam').val(jam);

      $('#planingsetuju').modal('show');

    }

    $('#simpanplansetuju').on('click', function () {

      var plan = $('#idplan').val();
      $('#idsetuju').val(plan);

      $.ajax({
        type: 'POST',
        url: "{{ route('updateplan') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': plan,  
            'tgl': $('#tgl').val(), 
            'jam': $('#jam').val(), 
        },
        success: function(data) {

          $('#planingsetuju').modal('hide');
          $('#deliverysetuju').modal('show');

        }

      });

      

    });

    $('#yakin_setuju').on('click', function () {

      $('#deliverysetuju').modal('hide');
      $('.loading').attr('style','display: block');

      $.ajax({
        type: 'POST',
        url: "{{ route('setujudelivery') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idsetuju').val(),  
        },
        success: function(data) {

          $.ajax({        
            type : 'POST',
            url : "https://fcm.googleapis.com/fcm/send",
            headers : {
                Authorization : 'key=' + 'AAAA3hityDc:APA91bHSYyN1RWj8RAjOp87yjp6Z22MskaBe0soUt0cdQKq7XT7Z9hiMACpM1F0XjZ19zOI7M2hnn9T3z2GoTA3iZKpN00gkDTYOU0b69UZnFnbQYO_BvIJ9TgWTKq2duVlbNhgkKyCz'
            },
            contentType : 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                "to": data.fcm_token, 
                "notification": {
                    "title":"IOLOSMART NOTIFICATIONS!",
                    "body":"Hai "+data.name+", Reedem Delivery Anda Telah di Setujui, Barang Anda akan dikirim sesuai dengan Rencana Reedem, Terimakasih!",
                    "icon": "https://tomxperience.id/assets/icon/96x96.png",
                    "click_action": "https://tomxperience.id/users/transaksi",
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
              title: "Berhasil!",
              text: "Permintaan Reedem Delivery Sudah Disetujui!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/reedemdelivery'; }, 1500);

        }
      });

    });

    function Tolak(id){

      $('#idtolak').val(id);
      $('#deliverytolak').modal('show');

    }

    $('#yakin_tolak').on('click', function () {

      $('#deliverytolak').modal('hide');
      $('.loading').attr('style','display: block');

      $.ajax({
        type: 'POST',
        url: "{{ route('tolakdelivery') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idtolak').val(),  
        },
        success: function(data) {

          $.ajax({        
            type : 'POST',
            url : "https://fcm.googleapis.com/fcm/send",
            headers : {
                Authorization : 'key=' + 'AAAA3hityDc:APA91bHSYyN1RWj8RAjOp87yjp6Z22MskaBe0soUt0cdQKq7XT7Z9hiMACpM1F0XjZ19zOI7M2hnn9T3z2GoTA3iZKpN00gkDTYOU0b69UZnFnbQYO_BvIJ9TgWTKq2duVlbNhgkKyCz'
            },
            contentType : 'application/json',
            dataType: 'json',
            data: JSON.stringify({
                "to": data.fcm_token, 
                "notification": {
                    "title":"IOLOSMART NOTIFICATIONS!",
                    "body":"Hai "+data.name+", Reedem Delivery Anda Telah di Tolak, Coba hubungi Admin untuk Proses Lebih lanjut!",
                    "icon": "https://tomxperience.id/assets/icon/96x96.png",
                    "click_action": "https://tomxperience.id/users/transaksi",
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
              title: "Berhasil!",
              text: "Permintaan Reedem Delivery DITOLAK!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/reedemdelivery'; }, 1500);

        }
      });

    });

</script>   