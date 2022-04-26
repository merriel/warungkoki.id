@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Pengisian Saldo</h1>
            </div>
            <button class="btn btn-sm btn-info" id="tambahsaldo" type="button"><i class="fa fa-plus"></i>Tambah Saldo</button>
            <br><br>
            @if($saldos->count() == '0')
            <div class="card shadow">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td><h6>Belum Ada Record Apapun Pada Tab ini!</h6></td>
                  </tr>
                </table>
              </div>
            </div>

            @else
            @foreach($saldos as $saldo)
            @php

              $usernya = DB::table('users')
              ->where('id', '=', $saldo->user_id)
              ->first();

            @endphp


            <div class="card shadow">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="3">
                      <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                        <i class="fas fa-archive" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td><b>
                      <div class="text-warning" style="font-size: 15px">{{ $saldo->user_name }}</div></b>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-size: 13px;color: black"><b>{{ rupiah($saldo->amount) }}</b></td>
                  </tr>
                  <tr>
                    <td style="font-size: 10px">Transaksi ini dilakukan pada tanggal {{ date('d F Y',strtotime($saldo->created_at)) }}</td>
                  </tr>
                </table>
                
              </div>
            </div>
            <br>
            @endforeach
            @endif
           
        </div> 
      </div> 
    </div>
  </div>
@include('content.saldo.modal')
@include('layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  
  $('#tambahsaldo').on('click', function () {

    $('#add').modal('show');
  });


  $('#users').select2({
    tags: true,
    dropdownParent: $("#add"),
    placeholder: 'Cari...',
    ajax: {
      url: "{{ route('saldo.users') }}",
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results:  $.map(data, function (item) {
            return {
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  function Simpan(){

    $('#konfirmasi').modal('show');

  }

  function Yakin(){

    var empty = false;
    $('select.isi, input.isi').each(function() {
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

      $.ajax({
        type: 'POST',
        url: "{{ route('saldo.store') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'users': $('#users').val(),
          'nominal': $('#nominal').val(),
        },
        success: function(data) {

            $('#add').modal('hide');

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
                      "title":"tomxperience.id - Saldo Anda Bertambah!",
                      "body":"Hai "+data.nama+", Saldo Anda sudah ditambahkan oleh petugas Kami, Yuk coba di cek!!!",
                      "icon": "https://tomxperience.id/assets/icon/96x96.png",
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
              title: "Success",
              text: "Saldo Berhasil Ditambahkan",
              icon: "success",
              buttons: false,
              timer: 2000,
            });

            setTimeout(function(){ window.location.reload() }, 1500);

          

        }

      });

      }

    }

</script>

</body>

</html>