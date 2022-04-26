@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/principle/komentar"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          <br><br>
          <div class="card shadow">
            <div class="card-body">
              <table width="100%">
                <tr>
                  <td width="17%" rowspan="3">
                    <img width="100%" src="/assets/img_post/{{ $diskusi->img }}">
                  </td>
                  <td width="5%"></td>
                  <td style="font-size: 16px;"><b>
                    {{ $diskusi->post_name }}</b>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td><span class="badge badge-success">{{ $diskusi->post_type }}</span></td>
                </tr>
              </table>
              <hr>
              <table width="100%">
                <tr>
                  <td width="15%" rowspan="2">
                    <img width="100%" src="/assets/content/img/theme/team-1-800x800.jpg">
                  </td>
                  <td width="5%"></td>
                  <td><b style="font-size: 13px">{{ $diskusi->user_name }}</b></td>
                </tr>
                <tr>
                  <td width="5%"></td>
                  <td style="font-size: 9px;">{{ date('d F Y', strtotime($diskusi->created_at)) }} Pukul {{ date('H:i', strtotime($diskusi->created_at)) }}</td>
                </tr>
                <tr>
                  <td width="15%"></td>
                  <td width="5%"></td>
                  <td style="font-size: 3px;">&nbsp;</td>
                </tr>
                <tr>
                  <td width="15%"></td>
                  <td width="5%"></td>
                  <td style="font-size: 12px;">{{ $diskusi->desc }} </td>
                </tr>
              </table>
              @php
                $komentars = DB::table('komentar')
                ->select("komentar.*", "users.name as user_name")
                ->join("users", "komentar.user_id", "=", "users.id")
                ->where('diskusi_id', $diskusi->id)
                ->get();
              @endphp

              @foreach($komentars as $komentar)
              <br>
              <table width="100%">
                <tr>
                  <td width="15%" rowspan="3">
                    
                  </td>
                  <td width="15%" rowspan="2">
                    <img width="100%" src="/assets/content/img/theme/team-1-800x800.jpg">
                  </td>
                  <td width="5%"></td>
                  <td><b style="font-size: 13px">{{ $komentar->user_name }}</b></td>
                </tr>
                <tr>
                  <td width="5%"></td>
                  <td style="font-size: 9px;">{{ date('d F Y', strtotime($komentar->created_at)) }} Pukul {{ date('H:i', strtotime($komentar->created_at)) }}</td>
                </tr>
                <tr>
                  <td width="15%"></td>
                  <td width="5%"></td>
                  <td style="font-size: 3px;">&nbsp;</td>
                </tr>
                <tr>
                  <td width="15%"></td>
                  <td width="5%"></td>
                  <td width="5%"></td>
                  <td style="font-size: 12px;">{{ $komentar->desc }} </td>
                </tr>
              </table>
              @endforeach
              <hr>
              <div align="center">
                <button type="button" onclick="Komentar({{ $diskusi->id }})" class='btn btn-sm btn-iolo'>Balas Diskusi</button>
              </div>
            </div>
          </div>
        </div> 
      </div> 
    </div>
  </div>
      @include('content.home.principle.komentar.modal')
      @include('layout.footer')

  <script type="text/javascript">
    
    function Komentar(id){

      $('#diskusiid').val(id);
      $('#nambahkomentar').modal('show');

    }

    $('#balas').on('click', function () {

      var empty = false;
      $('textarea#isibalasdiskusi').each(function() {
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
            url: "{{ route('balasdiskusi') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'desc': $('textarea#isibalasdiskusi').val(),
                'diskusi_id': $('#diskusiid').val(),
            },
            success: function(data) {

              swal({
                  title: "Berhasil",
                  text: "Balasan Diskusi Berhasil Dilakukan!",
                  icon: "success",
                  buttons: false,
                  timer: 2000,
              });

              setTimeout(function(){ window.location.reload() }, 1500);

              $.ajax({        
                type : 'POST',
                url : "https://fcm.googleapis.com/fcm/send",
                headers : {
                    Authorization : 'key=' + 'AIzaSyBXPLEpZkP6lH8gPpBWYa2Z835ZHiUZS8w'
                },
                contentType : 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    "to": data.tokenprinciple, 
                    "notification": {
                        "title":"Diskusi : "+data.namapost,
                        "body": $('textarea#isidiskusi').val(),
                        "icon": "https://iolosmart.com/assets/icon/96x96.png",
                        "click_action" : "https://iolosmart.com/users",
                    }
                }),
                success : function(response) {

                  

                }

              });

            }

          });

      }

    });

  </script>
</body>

</html>