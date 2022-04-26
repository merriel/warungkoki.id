@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Alamat Anda</h1>
        <div style="font-size:11px;">Klik pada alamat untuk Pilihan lainnya</div>
      </div>

      <!-- Card stats -->
      <a href="/alamatuser/add"><button class="btn btn-success btn-sm"><i class="fa fa-plus"></i>  Tambah Alamat</button></a><br><br>
      @if($alamats->count() == 0)
      <div class="col-12" >
        <table width="100%">
          <tr>
            <td align="center">
              <img src="/assets/content/img/icons/empty.png" width="60%">
              <br>
              <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
              <h6>Anda Belum menentukan Alamat Anda!</h6>
            </td>
          </tr>
        </table>
      </div>
      @else
      @foreach($alamats as $alamat)
      <div class="card shadow bg" onclick="Opsi({{ $alamat->id }})">     
        <div class="card-body">
          <table width="100%" border="0">
            <tr>
              <td width="25%" rowspan="2">
                <div id="bulat_{{ $alamat->id }}" class="bulat icon icon-shape bg-deliver text-white rounded-circle shadow">
                  <i id="icon_{{ $alamat->id }}" class="fas fa-home iconx" style="color: #ffffff"></i>
                  <input type="hidden" id="longuser">
                  <input type="hidden" id="latuser">
              </div>
              </td>
              <td><b><div class="judul text-warning" id="judul_{{ $alamat->id }}" style="font-size: 14px">{{ $alamat->judul }}</div></b></td>
            </tr>
            <tr>
              <td>
                <div style="font-size: 11px"><b>{{ $alamat->penerima }} ({{ $alamat->nohp }})</b></div>
                <div style="font-size: 10px">{{ $alamat->alamat }}  Kecamatan {{ $alamat->district_name }} {{ $alamat->regency_name }} Provinsi {{ $alamat->prov_name }} {{ $alamat->postal_code }}</div>

              </td>
            </tr>
            @if($alamat->utama == "yes")
            <tr>
              <td colspan="2" align="center">
                <hr>
                <div style="font-size: 10px;"><i>Ini merupakan Alamat UTAMA Anda!</i></div>
              </td>
            </tr>
            
            @endif
          </table>
          <div id="opsi_{{ $alamat->id }}" class="ops" style="display:none;">
            <hr>
            <table width="100%">
              <tr>
                @if($alamat->utama != "yes")
                <td>
                  <button onclick="Utama({{ $alamat->id }})" class="btn btn-sm btn-block btn-success">Jadikan Alamat Utama</button>
                </td>
                @endif
                <td>
                  <a href="/alamatuser/edit?id={{ $alamat->id }}" class="menusxx"><button class="btn btn-sm btn-block btn-info">Edit</button></a>
                </td>
                <td>
                  <button onclick="Hapus({{ $alamat->id }})" class="btn btn-sm btn-block btn-danger">Hapus</button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <br>
      @endforeach
      @endif
      <input type="hidden" id="alamatid" value="">
    </div>
  </div>

@include('content.alamat.modal')        
@include('layout.footer')

<script type="text/javascript">

  function Opsi(id){

    $('.ops').attr('style','display:none;');
    $('#opsi_'+id).attr('style','display:block;');

  }
  
  function TambahAlamat(){

    $('#tambahalamat').modal('show');

  }

  $('#prov').on('change', function () {

    var prov = $(this).val();

    $.ajax({
      url: "{{ route('register.ambilkabkot') }}",
      type: "POST",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': prov,
      },
      success:function(data) {

          var no = -1;
          var content_data ="";
          content_data += "<option value=''>Pilih Kota/Kabupaten</option>";
          $.each(data, function() {

              no++;
              var name = data[no]['name'];
              var id = data[no]['id'];

              content_data += "<option value="+id+">"+name+"</option>";

          });

          $('#regency').html(content_data);
      }
    });

  });

  $('#regency').on('change', function () {

    var regency = $(this).val();

    $.ajax({
      url: "{{ route('alamat.ambilkec') }}",
      type: "POST",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': regency,
      },
      success:function(data) {

          var no = -1;
          var content_data ="";
          content_data += "<option value=''>Pilih Kecamatan/Desa</option>";
          $.each(data, function() {

              no++;
              var name = data[no]['name'];
              var id = data[no]['id'];

              content_data += "<option value="+id+">"+name+"</option>";

          });

          $('#district').html(content_data);
      }
    });

  });

  $('#simpan').on('click', function () {

    var empty = false;
    $('input.mandatory, select.mandatory, textarea.mandatory').each(function() {
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
        url: "{{ route('alamat.store') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'judul': $('#judul').val(),
            'district_id': $('#district').val(),
            'alamat': $('#alamat').val(),
            'penerima': $('#penerima').val(),
            'nohp': $('#nohp').val(),
            'long': $('#longuser').val(),
            'lat': $('#latuser').val(),
        },

        success: function(data) {

          $('#tambahalamat').modal('hide');

          swal({
              title: "Berhasil",
              text: "Alamat Anda Berhasil Tersimpan!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/alamatuser'; }, 1500);


        }

    });

    }

  });

  // function PilihAlamat(id){

  //   $('.bg').attr("class","card shadow bg");
  //   $('.alamat').attr("class","alamat");
  //   $('.judul').attr("class","judul");
  //   $('.bulat').attr("class","bulat icon icon-shape bg-blue-par2 text-white rounded-circle shadow");
  //   $('.iconx').attr("style","color: #ffffff");

  //   $('#bgalamat_'+id).attr("class","card shadow bg bg-iolo");
  //   $('#alamat_'+id).attr("class","text-white alamat");
  //   $('#judul_'+id).attr("class","text-white judul");
  //   $('#bulat_'+id).attr("class","bulat icon icon-shape bg-white text-white rounded-circle shadow");
  //   $('#icon_'+id).attr("style","color: #003168");

  //   $('#alamatid').val(id);
  // }

  function Utama(id){

    $('#id').val(id);

    $('#utamaalamat').modal('show');

  }

  function YakinUtama(){

    $.ajax({
        type: 'POST',
        url: "{{ route('alamat.utama') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#id').val(),
        },

        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Anda Berhasil Mengganti Alamat Utama!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          $('#utamaalamat').modal('hide');

          setTimeout(function(){ window.location.reload() }, 1500);


        }

      });

  }

  function Hapus(id){

    $('#idc').val(id);

    $('#hapusalamat').modal('show');

  }

  function YakinHapus(){

    $.ajax({
        type: 'POST',
        url: "{{ route('alamat.hapus') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#idc').val(),
        },

        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Anda Berhasil Menghapus Alamat!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          $('#hapusalamat').modal('hide');

          setTimeout(function(){ window.location.reload() }, 1500);


        }

      });

  }

</script>   