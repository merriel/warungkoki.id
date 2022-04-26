@include('xmission.layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-purple pt-4 pt-md-8" style="padding-bottom: 14rem;">
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
              <h3 class="text-white">Detail Mission</h3>   
          </div>
          <br>

          @if($mission)
          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Mission Name :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b>{{ $mission->name }}</b></div>
                <hr>
                <div style="font-size: 12px;"><b>Barcode :</b></div><br>
                <div class="card shadow-ss">
                  <div class="card-body" >  
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img width='100%' alt='barcode' src='https://tomxperience.id/assets/barcode/barcode.php?codetype=Code128&size=85&text={{ $mission->transuuid }}'><br> <div style='padding-top: 15px;font-size: 11px;' align='center'><u><b>{{ $mission->transuuid }}</b></u></div>
                        </td>
                      </tr>
                      <tr>
                        <td align="center"><b><div style="font-size: 11px">Tunjukkan Kode Ini ke Team SPBU Shell Alternatif saat pengisian BBM, untuk mendapatkan Hadiah langsungnya.</div></b></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div><br>
          @else
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
                            <h6>Mission ini sudah selesai!</h6>
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
      </div>
    </div>
    <br><br>
  @include('xmission.layout.footer')
</body>

<script type="text/javascript">

  function Ikut(id){

    $('#id').val(id);
  
    $('#ikut').modal('show');

  }


  function YakinUtama(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xmission.ikut') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#id').val(),
      },
     success: function(data) {

      if(data == 1){

        swal({
            title: "Perhatian!",
            text: "Satu Hari untuk satu Mission!",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

      } else {

        swal({
            title: "Berhasil",
            text: "Anda berhasil Mengikuti Mission ini!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });

        setTimeout(function(){ window.location.href = '/xmission'; }, 1500);

      }

      

     }

   });

  }

</script>

</html>