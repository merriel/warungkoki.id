@include('layout.head2')

<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 17rem;">
  <div class="container-fluid">
    <div class="header-body">

    </div>
  </div>
</div>
<br>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      <section class="container">
        <div class="ct-page-title" style="margin-bottom:0.5rem;">
          <h2 class="ct-title" style="margin-bottom:0px;font-size: 21px;font-weight: bold;" id="content">DAFTAR MEMBER</h2>
          <div style="font-size:11px;">Isi data dibawah berikut untuk melanjutkan menjadi member di warungkoki.id</div>
        </div>
        <hr>
    </section>

      <div class="row">
        <div class="col-12" style="padding-bottom:0px;">
          <div class="card shadow-ss" style="border-radius:1rem;">
            <div class="card-body">


              <label>Masukan Nomor Handphone Anda :</label>
              <input type="text" class="form-control isi" id="nohp" placeholder="Contoh: 081100001122">
              <br>
              <label>Masukan Nama Lengkap Anda :</label>
              <input type="text" class="form-control isi" id="nama" placeholder="Contoh: Agus Budi">
              <hr>
              <button onclick="Konfirmasi();" class="btn btn-success btn-block">Daftar Sekarang</button>
            </div>
          </div>
        </div>    
      </div>
    </div>
  </div>
</div>
@include('content.promo.modal')     
@include('layout.footer2')

<script type="text/javascript">

function Konfirmasi(){

  $('#konfirmasidaftar').modal('show');
}

function YakinDaftar(){

    $('#konfirmasidaftar').modal('hide');
    $('.loading').attr('style','display: block');

    var empty = false;
    $('input.isi').each(function() {
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
        url: "{{ route('promo.grab.daftarstore') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'nohp': $('#nohp').val(),
            'nama': $('#nama').val(),
        },
        success: function(data) {

          swal({
              title: "SELAMAT!",
              text: "Anda Berhasil Menjadi Member!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });


          setTimeout(function(){ window.location.href = '/login2'; }, 1500);

        }

      });

    }


}
   
</script>
        
</body>

</html>