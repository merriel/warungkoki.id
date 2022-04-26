@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pt-4 pt-md-8" style="padding-bottom: 14rem;">
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
              <h3 class="text-white">Approve Mission Customers</h3>   
          </div>
          <br>

          @if($saldo)

          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Mission Name :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b>{{ $saldo->name }}</b></div>

                <hr>
                <b>Tanggal Mission :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y', strtotime($saldo->date)) }}</div>

                <hr>
                <b>Nama Customers :</b>
                <br>
                <div style="padding-top: 5px;">{{ $saldo->username }}</div>

                <hr>

                <div><b>Keterangan</b></div>
                <div style="font-size: 10px;padding-top: 6px;" class="text-warning"><i>
                  Hadiah mainan dan voucher dapat diambil di SPBU Shell Lippo Karawaci setelah proses peningkatan layanan selesai, mulai dari Tanggal 12 Juli 2021</i>
                </div>

              </div>
            </div>
          </div><br>
          <button onclick="Approve({{ $saldo->trans_id }})" class="btn btn-success btn-block"> Approve</button>

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
                            <h6>Sudah Di Approve Mission ini!</h6>
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
    <br><br>
  @include('layout.footer')
  @include('xmission.petugas.modal')
</body>

<script type="text/javascript">

  function Approve(id){

    $('#id').val(id);
  
    $('#approve').modal('show');

  }


  function YakinUtama(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xmission.approve') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#id').val(),
      },
     success: function(data) {

        $('#approve').modal('hide');

        if(data == 0){

          swal({
              title: "Berhasil",
              text: "Anda berhasil Approve Mission ini!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/home'; }, 1500);

        } else {

          swal({
              title: "Berhasil",
              text: "Anda Telah Menyelesaikan Mission ini!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

        }
   

     }

   });

  }

</script>

</html>