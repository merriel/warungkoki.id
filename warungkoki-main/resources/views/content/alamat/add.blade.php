@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
    <a href="/alamatuser"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a>
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Alamat Anda</h1>
      </div>

      <div class="row">
        <div class="col-md-12">

          <div class="form-group" align="left">
            <label class="form-control-label">Judul Alamat :</label>
            <input type="text" id="judul" class="form-control mandatory" placeholder="Contoh : Alamat Rumah, Alamat Kantor">
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Provinsi :</label>
            <select class="form-control mandatory" id="prov">
                <option value=""></option>
                @foreach($provinces as $prov)
                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Kota/Kabupaten :</label>
            <select class="form-control mandatory" id="regency">
                
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Kecamatan :</label>
            <select class="form-control mandatory" id="district">
                
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Nama Penerima :</label>
            <input type="text" id="penerima" class="form-control mandatory" placeholder="Contoh : Dodi, Agus,">
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Nomor HP Penerima :</label>
            <input type="text" id="nohp" class="form-control mandatory" placeholder="Contoh : 0890011911">
          </div>
          <input type="hidden" id="latuser" name="lat" value="">
          <input type="hidden" id="longuser" name="lng" value="">
          <hr>
<!--           <label class="form-control-label">Pilih Lokasi pada Peta :</label>
          <div class="form-group">
              <input type="text" id="address-input" name="address_address" class="form-control map-input">
          </div> -->
          <label class="form-control-label">Alamat Lengkap Anda :</label>
          <div class="form-group">
              <input id="address-input" type="text" class="form-control map-input mandatory">
          </div>
          <div class="form-group" align="left">
            <label class="form-control-label">Catatan Tambahan Alamat :</label>
            <input type="text" class="form-control" id="catatan" placeholder="Contoh : Blok 10 A, Lantai 2">
          </div>
          <div id="googleMap" style="width:100%;height:380px;"></div>
          <br>
          <table width="100%">
            <tr>
              <td><button type="button" id="simpan" class="btn btn-block btn-success">Simpan</button></td>
              <td><a href="/alamatuser"><button type="button" class="btn btn-danger btn-block">Cancel</button></a> </td>
            </tr>
          </table>

        </div>
    </div>
    </div>
  </div>
      
@include('layout.footer')
<!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k"></script>

<script type="text/javascript">

  // variabel global marker
  var marker;
    
  function taruhMarker(peta, posisiTitik){
      
      if( marker ){
        // pindahkan marker
        marker.setPosition(posisiTitik);
      } else {
        // buat marker baru
        marker = new google.maps.Marker({
          position: posisiTitik,
          map: peta,
          animation: google.maps.Animation.BOUNCE
        });
      }
    
       // isi nilai koordinat ke form
      document.getElementById("latuser").value = posisiTitik.lat();
      document.getElementById("longuser").value = posisiTitik.lng();
  }
    
  function initialize() {
    var propertiPeta = {
      center:new google.maps.LatLng(-6.18695509740201,106.64104728172163),
      zoom:15,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    
    var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    
    // even listner ketika peta diklik
    google.maps.event.addListener(peta, 'click', function(event) {
      taruhMarker(this, event.latLng);
    });

    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById("address-input")), {
        componentRestrictions: {country: "id"}
        
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();

      peta.setCenter(place.geometry.location);
      peta.setZoom(17);  // Why 17? Because it looks good.

      if( marker ){
        // pindahkan marker
        marker.setPosition(place.geometry.location);
      } else {
        // buat marker baru
        marker = new google.maps.Marker({
          position: place.geometry.location,
          map: peta,
          animation: google.maps.Animation.BOUNCE
        });
      }

      document.getElementById('latuser').value = place.geometry.location.lat();
      document.getElementById('longuser').value = place.geometry.location.lng();

      var address = '';
      if (place.address_components) {
        address = [(place.address_components[0] &&
                    place.address_components[0].short_name || ''),
                   (place.address_components[1] &&
                    place.address_components[1].short_name || ''),
                   (place.address_components[2] &&
                    place.address_components[2].short_name || '')
                  ].join(' ');
      }
      
      google.maps.event.addListener(peta, 'click', function() {
        return place
      });
    });

  }

  // event jendela di-load  
  google.maps.event.addDomListener(window, 'load', initialize);

  // navigator.geolocation.getCurrentPosition(function (position) {
  //     $('#longuser').val('106.65281183139808');
  //     $('#latuser').val('-6.288351362398975');

  //     console.log(positioposition.coords.latituden.coords.latitude);
  // });
  
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

      if($('#latuser').val() == '' && $('#longuser').val() == ''){

        swal({
            text: "Harap Pin Lokasi Anda Terlebih Dahulu!",
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
              'alamat': $('#address-input').val(),
              'penerima': $('#penerima').val(),
              'nohp': $('#nohp').val(),
              'long': $('#longuser').val(),
              'lat': $('#latuser').val(),
              'catatan': $('#catatan').val(),
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

    }

  });

</script>   