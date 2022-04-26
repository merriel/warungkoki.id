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

          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">
                <b>Mission Name :</b>
                <br>
                <div style="padding-top: 5px;" class="text-warning"><b>{{ $mission->name }}</b></div>
                <hr>

                <b>Periode Mission :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y', strtotime($mission->dari)) }} - {{ date('d F Y', strtotime($mission->sampai)) }}</div>
                <hr>

                <b>Deskripsi Mission :</b>
                <br>
                <div style="padding-top: 5px;">
                  {!! $mission->desc !!}
                </div>
                <hr>
              </div>

            </div>
          </div><br>
          <button onclick="Ikut({{ $mission->id }})" class="btn btn-success btn-block"> Ikut Mission</button>
        </div>
      </div>
    </div>
    <br><br>
  @include('xmission.layout.footer')
  @include('xmission.home.modal')
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

      } else if(data == 2){

        swal({
            title: "Perhatian!",
            text: "Anda Sudah Mengikuti Mission",
            icon: "error",
            buttons: false,
            timer: 2000,
        });

      } else if(data == 3){

        swal({
            title: "Perhatian!",
            text: "Anda Sudah Melebihi Batas Ikut Mission",
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