@include('working-space.layout.head')
<div class="main-content">
<!-- Header -->
<div class="header bg-gradient-shell pb-8 pt-6 pt-md-8">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->
      
    </div>
  </div>
</div>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-xl-0">
      <div class="card shadow-ss" style="background-color: #EFDBB2;">
        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
            <div style="font-size: 16px; color: #323232;"><b>Form Booking</b></div><hr>

            <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Lokasi :</div>
            <div class="card shadow-ss">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="2">
                      <div class="icon icon-shape bg-gradient-shell text-white rounded-circle shadow-ss">
                        <i class="fas fa-compass" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td><b><div style="font-size: 16px;color: #323232;">{{ $detailroom->wilayah_name }}</div></b><input type="hidden" id="wilayah" value="{{ $detailroom->room_name }}">
                      <input type="hidden" id="room_id" value="{{ $detailroom->id }}">
                      <input type="hidden" id="hariini" value="{{ $date }}">
                      <input type="hidden" id="template" value="{{ $detailroom->template }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div style="font-size: 10px">Lokasi berada di {{ $detailroom->alamat }} {{ $detailroom->regency_name }} </div>
                      <div style="font-size: 10px"><b>Buka Jam {{ $detailroom->open }} s/d {{ $detailroom->close }} </b></div>
                      <input type="hidden" id="alamat" value="{{ $detailroom->alamat }} {{ $detailroom->regency_name }}">
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <br>
            <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Tanggal :</div> 
            <input type="date" id="tanggal" class="form-control">   
            <br>
            <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Booking Type :</div> 
            <select class="form-control" id="type">
              <option value="hour">Per Jam</option>
              <option value="day">Harian</option>
              <!-- <option value="month">Bulanan</option> -->
            </select>
            <br>

            <table width="100%" class="jam">
              <tr>
                <td>
                  <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Dari Jam :</div>
                </td>
                <td width="3%"></td>
                <td>
                  <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Sampai Jam :</div>
                </td>
              </tr>
              <tr>
                <td>
                  <input type="time" class="form-control" id="dari">
                </td>
                <td width="3%"></td>
                <td>
                  <input type="time" class="form-control" id="sampai">
                </td>
              </tr>
            </table>
            <br>
            <div style="font-size: 12px;color: #323232; padding-bottom: 8px;">Pilih Tempat (Desk) :</div> 
            <div class="card shadow-ss">
              <div class="card-body" style="padding: 0rem;">
                @php
                  $tes = 'working-space.template.'.$detailroom->template;
                @endphp
                @include($tes)
                <br>
                <div style="font-size: 12px;color: #323232; padding-bottom: 8px;padding-left: 1rem;">Keterangan :</div> 
                <div style="padding-left: 1rem;padding-bottom: 1.5rem;">
                  <table width="100%">
                    <tr>
                      <td width="15%">
                        <img src="{{ asset ('assets/template/karawaci/tombol1.png') }}">
                      </td>
                      <td width="2%">=</td>
                      <td>
                        <div style="font-size: 12px;color: #323232;"><b>&nbsp;Available/Tersedia</b></div> 
                      </td>
                    <tr>
                    <tr>
                      <td width="15%">
                        <img src="{{ asset ('assets/template/karawaci/tombol1_m.png') }}">
                      </td>
                      <td width="2%">=</td>
                      <td>
                        <div style="font-size: 12px;color: #323232;"><b>&nbsp;Booked/Tidak Tersedia</b></div> 
                      </td>
                    </tr>
                    <tr>
                      <td width="15%">
                        <img src="{{ asset ('assets/template/karawaci/tombol1_p.png') }}">
                      </td>
                      <td width="2%">=</td>
                      <td>
                        <div style="font-size: 12px;color: #323232;"><b>&nbsp;Yang Dipilih</b></div> 
                      </td>
                    </tr>
                  </table>
                </div>
                <div style="font-size: 12px;color: #323232; padding-bottom: 3px;padding-left: 1rem;">Kursi yang Dipilih :<input type="hidden" id="valuedesk" value=""></div> 
                <div class="text-warning" style="font-size: 16px; padding-bottom: 14px;padding-left: 1rem;"><b id="pilihdesk">- </b></div> 
                <input type="hidden" id="namadesk">
              </div>
            </div>

            <hr style="margin-bottom: 0.6rem;margin-top: 0.6rem;">
            <table width="100%">
              <tr>
                <td align="left">
                  <b  style="font-size: 14px;color: #323232;">Total Bayar</b>
                </td>
                <td align="right">
                  <b class="text-warning" style="font-size: 21px;" id="total">-</b>
                  <input type="hidden" id="bayar">
                </td>
              </tr>
            </table>
            <!-- <table width="100%" style="margin-bottom: 7px;">
                <tr>
                    <td>
                    <table>
                        <tr>
                            <td>
                               <b class="text-warning" style="font-size: 17px;">Rp. 70.000</b>
                            </td>
                            <td>
                               <div style="font-size: 9px;color: #323232;">/ Per Hari</div>
                            </td>
                        </tr>
                    </table>
                    </td>
                    <td align="right">
                        <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> Shell Karawaci</span>
                    </td>
                </tr>
            </table> -->
<!--             <div style="font-size: 12px;margin-bottom: 7px;">
              <b>Diskusi</b> (32)  |  <b>Booked</b>  100
            </div> -->
            <br>
            <table width="100%">
              <tr>
                <td>
                  <a href="/working-space/detail?uuid={{ $detailroom->uuid }}"><button class="btn btn-block btn-danger menusxx" type="button">Batal</button></a>
                </td>
                <td width="4%"></td>
                <td>
                  <button onclick="BookedNow();" class="btn btn-block btn-secondary" type="button">Booking Sekarang</button>
                </td>
              </tr>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
        
@include('working-space.home.modal')      
@include('working-space.layout.footer')
<script type="text/javascript">

  function BookedNow(){

    var tgl = $('#tanggal').val();
    var dari = $('#dari').val();
    var sampai = $('#sampai').val();
    var room = $('#room_id').val();
    var type = $('#type').val();
    var desk = $('#valuedesk').val();
    var bayar = $('#bayar').val();

    if(tgl == '' || room == '' || type == '' || desk == ''){

      swal({
          title: "Perhatikan",
          text: "Harap isi dengan Lengkap Form Diatas!",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

    } else {

      $('#konf_wilayah').html($('#wilayah').val());
      $('#konf_alamat').html($('#alamat').val()+' | '+$('#namadesk').val());
      if(type == 'hour'){
        $('#konf_waktu').html('Jam '+dari+' s/d '+sampai);
      }else {
        $('#konf_waktu').html('Seharian');
      }

      var number_string = bayar.toString(),
        sisa  = number_string.length % 3,
        rupiah  = number_string.substr(0, sisa),
        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
          
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      $('#konf_total').html('Rp. '+rupiah);

      var tanggal = new Date(tgl).getDate();
      var _hari = new Date(tgl).getDay();
      var _bulan = new Date(tgl).getMonth();
      var _tahun = new Date(tgl).getYear();

      var hari =['Minggu', 'Senin','Selasa','Rabu', 'Kamis','Jumat','Sabtu'];
      var bulan =['Januari', 'Februari','Maret','April', 'Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
      var tahun = (_tahun < 1000) ? _tahun + 1900 : _tahun;

      var hari = hari[_hari];
      var bulan = bulan[_bulan];

      $('#konf_tanggal').html(hari+', '+tanggal+' '+bulan+' '+tahun);

      $('#konfirmasi').modal('show');


    }


  }
  
  $('#tanggal').on('change', function () {

    var startDate1 = new Date($(this).val());
    var today = new Date($('#hariini').val());
    var template = $('#template').val();

    if(startDate1 < today){

      swal({
          title: "Perhatikan",
          text: "Tidak bisa Input Hari Kemarin!",
          icon: "error",
          buttons: false,
          timer: 2000,
      });

      $('#tanggal').val('');

    }

    // ======= PENCARIAN KURSI KOSONG ========

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.caridesk') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        $('.available').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('.booked').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('#pilihdesk').html('-');
        $('.tmbl').attr("class", "tmbl");
        $('#valuedesk').val('');

        var content_data="";
        var no = -1;
        $.each(data, function() {

          no++;
          var id = data[no]['desk_id'];

            $('#imgdesk'+id).attr("src", "../assets/template/"+template+"/tombol"+id+"_m.png");
            $('#tombolkursi_'+id).attr("class", "tmbl disabled");
            $('#imgdesk'+id).attr("class", "booked");

        });
      }

    });

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.total') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        var number_string = data.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#total').html('Rp. '+rupiah);

        $('#bayar').val(data);

      }
    });


  });

  $('#type').on('change', function () {

    var type = $(this).val();

    if(type != 'hour'){

      $('.jam').attr('style','display: none;');

    } else {

      $('.jam').attr('style','display: ');

    }

    var template = $('#template').val();

    // ======= PENCARIAN KURSI KOSONG ========

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.caridesk') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        $('.available').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('.booked').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('#pilihdesk').html('-');
        $('.tmbl').attr("class", "tmbl");
        $('#valuedesk').val('');

        var content_data="";
        var no = -1;
        $.each(data, function() {

          no++;
          var id = data[no]['desk_id'];

            $('#imgdesk'+id).attr("src", "../assets/template/"+template+"/tombol"+id+"_m.png");
            $('#tombolkursi_'+id).attr("class", "tmbl disabled");
            $('#imgdesk'+id).attr("class", "booked");

        });
      }

    });

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.total') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        var number_string = data.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#total').html('Rp. '+rupiah);

        $('#bayar').val(data);

      }
    });

  });

  $('#dari').on('change', function () {

    var dari = $(this).val();
    var minutes = dari.substr(3,2);
    var hour = dari.substr(0,2);
    var template = $('#template').val();

    // if(minutes > 30){
    //   var jam = parseInt(hour) + 1;
    // } else {
    //   var jam = hour;
    // }

    // if(jam.toString().length == '1'){
    //   var jams = '0'+jam;
    // } else{
    //   var jams = jam;
    // }

    // var waktu = jams+':00';

    // $('#dari').val(waktu);

    // ======= PENCARIAN KURSI KOSONG ========

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.caridesk') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        $('.available').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('.booked').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('#pilihdesk').html('-');
        $('.tmbl').attr("class", "tmbl");
        $('#valuedesk').val('');

        var content_data="";
        var no = -1;
        $.each(data, function() {

          no++;
          var id = data[no]['desk_id'];

            $('#imgdesk'+id).attr("src", "../assets/template/"+template+"/tombol"+id+"_m.png");
            $('#tombolkursi_'+id).attr("class", "tmbl disabled");
            $('#imgdesk'+id).attr("class", "booked");

        });
      }

    });

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.total') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        var number_string = data.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#total').html('Rp. '+rupiah);

        $('#bayar').val(data);

      }
    });

  });

  $('#sampai').on('change', function () {

    var sampai = $(this).val();
    var minutes = sampai.substr(3,2);
    var hour = sampai.substr(0,2);
    var template = $('#template').val();

    // if(minutes > 30){
    //   var jam = parseInt(hour) + 1;
    // } else {
    //   var jam = hour;
    // }

    // if(jam.toString().length == '1'){
    //   var jams = '0'+jam;
    // } else{
    //   var jams = jam;
    // }

    // var waktu = jams+':00';

    // $('#sampai').val(waktu);
    // console.log(waktu);

    // ======= PENCARIAN KURSI KOSONG ========

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.caridesk') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        $('.available').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('.booked').attr("src", "../assets/template/"+template+"/tombol1.png");
        $('#pilihdesk').html('-');
        $('.tmbl').attr("class", "tmbl");
        $('#valuedesk').val('');

        var content_data="";
        var no = -1;
        $.each(data, function() {

          no++;
          var id = data[no]['desk_id'];

            $('#imgdesk'+id).attr("src", "../assets/template/"+template+"/tombol"+id+"_m.png");
            $('#tombolkursi_'+id).attr("class", "tmbl disabled");
            $('#imgdesk'+id).attr("class", "booked");

        });
      }

    });

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.total') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'tanggal': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'room_id': $('#room_id').val(),
          'type': $('#type').val(),
      },
      success: function(data) {

        var number_string = data.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        $('#total').html('Rp. '+rupiah);

        $('#bayar').val(data);

      }
    });

  });


  $('#booking').on('click', function () {

    $('#konfirmasi').modal('hide');

    $.ajax({
      type: 'POST',
      url: "{{ route('workingspace.order') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'desk_id': $('#valuedesk').val(),
          'date': $('#tanggal').val(),
          'dari': $('#dari').val(),
          'sampai': $('#sampai').val(),
          'type': $('#type').val(),
          'amount': $('#bayar').val(),
      },
      success: function(data, status) {
        snap.pay(data.snap_token, {
            // Optional
            onSuccess: function (result) {
                window.location.href = '/home';
            },
            // Optional
            onPending: function (result) {
                location.reload();
            },
            // Optional
            onError: function (result) {
                location.reload();
            }
        });

      }

    });

  });

</script>
</body>
</html>