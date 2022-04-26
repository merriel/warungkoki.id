@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.3rem;">
      <div class="ct-page-title">
        <h1 class="ct-title" id="content">Edit Alamat Anda</h1>
      </div>

      <div class="row">
        <div class="col-md-12">
          <input type="hidden" id="alamatid" value="{{ $alamat->id }}" name="">
          <div class="form-group" align="left">
            <label class="form-control-label">Judul Alamat :</label>
            <input type="text" id="judul" class="form-control mandatory" placeholder="Contoh : Alamat Rumah, Alamat Kantor" value="{{ $alamat->judul }}">
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Provinsi :</label>
            <select class="form-control mandatory" id="prov">
                <option value=""></option>
                @foreach($provinces as $prov)
                <option {{ $prov->id == $alamat->prov_id ? 'selected' : '' }} value="{{ $prov->id }}">{{ $prov->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Kota/Kabupaten :</label>
            <select class="form-control mandatory" id="regency">
                @foreach($regencies as $reg)
                <option {{ $reg->id == $alamat->regency_id ? 'selected' : '' }} value="{{ $reg->id }}">{{ $reg->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Pilih Kecamatan :</label>
            <select class="form-control mandatory" id="district">
                @foreach($districts as $dis)
                <option {{ $dis->id == $alamat->district_id ? 'selected' : '' }} value="{{ $dis->id }}">{{ $dis->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Alamat Lengkap :</label>
            <textarea class="form-control mandatory" id="alamat" rows="7" placeholder="Isikan Alamat Lengkap Anda Disini">{{ $alamat->alamat }}</textarea>
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Nama Penerima :</label>
            <input type="text" id="penerima" value="{{ $alamat->penerima }}" class="form-control mandatory" placeholder="Contoh : Dodi, Agus,">
          </div>

          <div class="form-group" align="left">
            <label class="form-control-label">Nomor HP Penerima :</label>
            <input type="text" id="nohp" value="{{ $alamat->nohp }}" class="form-control mandatory" placeholder="Contoh : 0890011911">
          </div>
          <input type="hidden" id="latuser" name="lat" value="{{ $alamat->lat }}">
          <input type="hidden" id="longuser" name="lng" value="{{ $alamat->long }}">
          <hr>
          <label class="form-control-label">Pilih Lokasi pada Peta :</label>
          <div class="form-group">
              <input type="text" id="address-input" name="address_address" class="form-control map-input">
          </div>
          <div id="googleMap" style="width:100%;height:380px;"></div>
          <br>
          <table width="100%">
            <tr>
              <td><button type="button" id="update" class="btn btn-block btn-success">Update</button></td>
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
      center:new google.maps.LatLng($('#latuser').val(),$('#longuser').val()),
      zoom:16,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    
    var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

    var markers = new google.maps.Marker({
        position: new google.maps.LatLng($('#latuser').val(),$('#longuser').val()),
        map: peta,
        animation: google.maps.Animation.BOUNCE
    });
    
    // even listner ketika peta diklik
    google.maps.event.addListener(peta, 'click', function(event) {
      taruhMarker(this, event.latLng);
      markers.setMap(null);
    });

    // ===== Autocomplete ===

    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById("address-input")), {
        componentRestrictions: {country: "id"}
        
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
          var place = autocomplete.getPlace();

          peta.setCenter(place.geometry.location);
          peta.setZoom(16);  // Why 17? Because it looks good.
          markers.setPosition(place.geometry.location);

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
          
          google.maps.event.addListener(marker, 'click', function() {
            return place
          });
        });
  



  }


  // event jendela di-load  
  google.maps.event.addDomListener(window, 'load', initialize);
  
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

  $('#update').on('click', function () {

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
        url: "{{ route('alamat.update') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'judul': $('#judul').val(),
            'district_id': $('#district').val(),
            'alamat': $('#alamat').val(),
            'penerima': $('#penerima').val(),
            'nohp': $('#nohp').val(),
            'long': $('#longuser').val(),
            'lat': $('#latuser').val(),
            'id': $('#alamatid').val(),
        },

        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Alamat Anda Berhasil Di Perbaharui!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/alamatuser'; }, 1500);


        }

    });

    }

  });

</script>   