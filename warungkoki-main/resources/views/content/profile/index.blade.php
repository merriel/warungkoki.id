@include('layout.head')
<style type="text/css">
  .bottom-left {
    position: absolute;
    bottom: 42px;
    right: 23px;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    @if(Auth::user()->role_id == 4)
    <div class="header bg-warung-3 pt-5 pt-md-8" style="padding-bottom: 9rem;">
    @else
    <div class="header bg-warung-3 pt-5 pt-md-8" style="padding-bottom: 12rem;">
    @endif
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="javascript: window.history.go(-1)"><button type="button" id="back" class='btn btn-sm btn-success'>Kembali</button></a> -->
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      @if(Auth::user()->role_id == 4)
      <div class="row">
        <div class="col-12">
          <div class="card-body bg-success shadow-ss" style="border-radius: 1rem;padding: 0.5rem 1rem;">    
            <table width="100%">
              <tr>
                <td align="left" width="55%">
                  <a href="/xhome/isisaldo" class="menusxx">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/money.png">
                          </td>
                          <td>&nbsp;</td>
                          <td>
                            <div style="font-size:10px;">Saldo Warungkoki :</div>
                            <b style="font-size: 13px;">{{ $saldouang ? rupiah($saldouang->sisa) : 'Rp. 0' }}</b>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </a>
                </td>
                <td>&nbsp;</td>
                <td align="left">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/padi.png">
                          </td>
                          
                          <td>
                            <a href='#' style="color: white;">
                            <div style="font-size:10px;">Butiran Padi :</div>
                            <b style="font-size: 13px;">{{ $saldopoin ? $saldopoin->sisa : '0' }}</b>
                            </a>
                          </td>
                        </tr>
                      </table>
                      
                    </div>
                </td>
              </tr>
            </table> 
          </div>
        </div>
      </div>
      @endif
      <div class="row">
        @if(Auth::user()->role_id != 4)
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow-ss" style="border-radius:1.5rem;">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="./assets/content/img/theme/noname.png" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="text-center">
                <h3>{{ $datas->name }}</h3>
                <div class="h5 font-weight-300" align="center">
                @if($datas->role_id == '4')
                User Warungkoki Apps
                @else
                Petugas Warungkoki Apps
                @endif
              </div>
              </div>
              <br>
              
            </div>
          </div>
        </div>
        @endif
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow-ss">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">My Profile</h3>
                </div>
                
              </div>
            </div>
            <div class="card-body">
              <h6 class="heading-small text-muted mb-4">Informasi User</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Nama Lengkap</label>
                      <input type="text" id="nama" value="{{ $datas->name }}" class="form-control form-control-alternative edited" placeholder="Username">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-email">Email</label>
                      <input type="text" value="{{ $datas->email }}" class="form-control form-control-alternative edited" placeholder="budi@example.com" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">Nomor Handphone</label>
                      <input type="number" id="no_hp" value="{{ $datas->no_hp }}" class="form-control form-control-alternative" placeholder="Masukan Nomor Handphone Anda">
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group" style="margin-bottom:0px;">
                      <label class="form-control-label" for="input-first-name">Nomor KTP Anda</label>
                      <input type="number" id="ktp" value="{{ $datas->ktp }}" class="form-control form-control-alternative" placeholder="Masukan Nomor KTP Anda"><br>
                      <!-- <button type="button" id="tombol" onclick="Lihat();" class="btn btn-sm btn-primary">Lihat</button> -->
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group" style="margin-bottom:0px;">
                      <label class="form-control-label" style="margin-bottom:0.2rem;" for="input-first-name">PIN Anda</label>
                      <div style="font-size:11px;padding-bottom: 7px;">PIN ini adalah PIN ketika Anda akan melakukan Transaksi</div>
                      <input type="password" id="token" value="{{ $datas->token }}" class="form-control form-control-alternative edited"><br>
                      <div class="bottom-left">
                        <button style="border-radius: 3rem;" type="button" id="tombol" onclick="Lihat();" class="btn btn-sm btn-seecondary"><i class="fa fa-eye-slash"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <table width="100%">
                    <tr>
                      <td>
                        <button type="button" onclick="Update();" class="btn btn-block btn-primary">Update</button>
                      </td>
                      <td width="3%"></td>
                      <td>
                          <a class="btn btn-block btn-danger menusxx" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </td>
                    </tr>

                  </table>
              </div>
               <br><br><br>
            </div>
          </div>
        </div>
        <br><br>
      
@include('layout.footer')

<script type="text/javascript">

    $(document).on('keyup', '#token', function() {

      var val = $(this).val();
      var substr = val.substring(0,6);

      if(val.length > 6){

        swal({
            title: "Perhatian",
            text: "Token Harus 6 Digit!",
            icon: "warning",
            buttons: false,
            timer: 2000,
        });

        $('#token').val(substr);

      } 

    });
  
    function Lihat(){

      $('#token').attr('type', 'number');
      $('#tombol').attr('onclick', 'Tutup();');
      $('#tombol').html('<i class="fa fa-eye"></i>');

    }

    function Tutup(){

      $('#token').attr('type', 'password');
      $('#tombol').attr('onclick', 'Lihat();');
      $('#tombol').html('<i class="fa fa-eye-slash"></i>');

    }

    function Update(){

      var empty = false;
      $('input.edited').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) { 
          swal({
              text: "PIN dan Nama Tidak Boleh Kosong!",
              icon: "warning",
              buttons: false,
              timer: 2000,
          });

      } else {

        var token = $('#token').val();

        if(token.length < 6){

          swal({
              title: "Perhatian",
              text: "Token Harus 6 Digit!",
              icon: "warning",
              buttons: false,
              timer: 2000,
          });

        } else {

          var ktp = $('#ktp').val();

          if(ktp == "" || ktp == null){

            $.ajax({
                type: 'POST',
                url: "{{ route('updateprofile') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nama': $('#nama').val(), 
                    'no_hp': $('#no_hp').val(), 
                    'token': $('#token').val(),
                    'ktp': $('#ktp').val(),
                },
                success: function(data) {

                  swal({
                      title: "Berhasil",
                      text: "Profile Anda Sudah Update!",
                      icon: "success",
                      buttons: false,
                      timer: 2000,
                  });

                  setTimeout(function(){ window.history.go(-1); }, 2000);

                }
              });

          } else { 

            if(ktp.length != 16){

              swal({
                title: "Perhatian",
                text: "Harap Masukan KTP dengan Benar!",
                icon: "warning",
                buttons: false,
                timer: 2000,
            });

            } else {

              $.ajax({
                type: 'POST',
                url: "{{ route('updateprofile') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'nama': $('#nama').val(), 
                    'no_hp': $('#no_hp').val(), 
                    'token': $('#token').val(),
                    'ktp': $('#ktp').val(),
                },
                success: function(data) {

                  swal({
                      title: "Berhasil",
                      text: "Profile Anda Sudah Update!",
                      icon: "success",
                      buttons: false,
                      timer: 2000,
                  });

                  setTimeout(function(){ window.history.go(-1); }, 2000);

                }
              });

            }

          }

      }

    }
  }

</script>
</body>

</html>