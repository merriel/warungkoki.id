@include('layout.head')
<div class="main-content">
  <!-- Header -->
  <div class="container-fluid pb-4 pt-3 pt-md-8">
  <a href="/alamatuser"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a>
    <div class="ct-page-title">
      <h1 class="ct-title" id="content">Summary Pemesanan</h1>
    </div>

    <!-- Card stats -->
    <div style="font-size: 14px;"><b>Alamat Pengiriman :</b></div><hr>
    <div class="card shadow">
      <div class="card-body">
        <table width="100%" border="0">
          <tr>
            <td width="25%" rowspan="3">
              <div  class="bulat icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                <i class="fas fa-home" style="color: #ffffff"></i>
            </div>
            </td>
            <td><b><div style="font-size: 15px">{{ $reedems->judul }}</div></b></td>
          </tr>
          <tr>
            <td>
              <div style="font-size: 10px">{{ $reedems->alamat }}</div>
            </td>
          </tr>
          <tr>
            <td style="padding-top: 8px;">
              <span class="badge badge-pill badge-primary" style="font-size: 8px;"><i class="fa fa-building"></i>  {{ $reedems->regency_name }}</span> 
              <span class="badge badge-pill badge-warning" style="font-size: 8px;"><i class="fa fa-home"></i>  {{ $reedems->prov_name }}</span>
            </td>
          </tr>
        </table>
      </div>
    </div><br>
    <div style="font-size: 14px;"><b>Produk yang di Reedem :</b></div><hr>
    @foreach($deliveries as $delivery)
    <div class="card shadow bg-iolo">
      <div class="card-body">
        <table width="100%">
          <tr>
            <td class="text-warning" style="font-size: 11px;"><b>Outlet : {{ $delivery->wilayah_name }}</b></td>
          </tr>
          <tr>
            <td class="text-white">{{ $delivery->prod_name }} @ {{ rupiah($delivery->harga_act) }}</td>
            <td align="right" width="5%" class="text-white"><b>{{ $delivery->qty }}</b></td>
          </tr>
          
        </table>
      </div>
    </div><br>
    @endforeach
    <div style="font-size: 14px;"><b>Keterangan :</b></div><hr>
    <div class="card shadow bg-kuning">
      <div class="card-body" style="padding-bottom: 0.5rem;padding-top: 0.5rem;">
        <div class="row">
          <div class="col-12" style="padding-bottom: 0px;">
            <table width="100%">
              <tr>
                <td style="font-size: 10px;" align="left">
                  <b><i>Catatan Tambahan : </i></b>
                </td>
              </tr>
              <tr>
                <td align="left" style="font-size: 12px;"><b id="notes">{{ $reedems ? $reedems->ket : '-' }}</b></td>
              </tr>
            </table>
            <hr>
            <table width="100%">
              <tr>
                <td style="font-size: 10px;" align="left">
                  <b><i>Rencana Pengambilan Reedem : </i></b>
                </td>
              </tr>
              <tr>
                <td align="left" style="font-size: 12px;"><b id="plan">{{ $reedems->plan == null ? '-' : date('d F Y H:i', strtotime($reedems->plan)) }}</b></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('content.summary.modal')
@include('layout.footer')
<footer id="footer" style="position: relative;">
  <div class="container-fluid pt-md-8">
    <div class="row">
      <div class="col-12" style="padding: 0px;">
        <div class="card">
          <div class="card-body bg-iolo">
            <div class="row">
              <div class="col-12" align="right" style="padding-bottom: 0px; padding-top: 10px;">
                  <button onclick="ReedemNow();" class="btn btn-block btn-white" type="button">Konfirmasi Pemesanan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<script type="text/javascript">
  
  function ReedemNow(){

    //CekWilayah
    $.ajax({
       type: 'GET',
       url: "{{ route('cekwilayah') }}",
       success: function(data) {

          if(data > 1){

              swal({
                  title: "Perhatian!",
                  text: "Pastikan Anda Reedem Di Wilayah Yang sama!",
                  icon: "error",
                  buttons: false,
                  timer: 2000,
              });

          } else {

            $('#reedem_confirm').modal('show');

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
              url: "{{ route('prosesreedemdelivery') }}",
               data: {
                  '_token': $('input[name=_token]').val(), 
              },
              success: function(data) {

                  swal({
                      title: "Berhasil!",
                      text: "Permintaan Reedem Delivery Anda Sudah Terkerim!",
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

  });

</script>   