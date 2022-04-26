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
              <h3 class="text-white">Rewards Anda</h3>   
          </div>
          <br>
          @if($rewards->count() == 0)
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
                              <h6>Belum ada Rewards yang Anda Dapatkan !</h6>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>

          @else
            
            <div class="card shadow-ss" style="border-radius: 1rem;">
              <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                  
                  @foreach($rewards as $r)
                    @if($r->hadiah_id == null)
                    <a href="/xmission/reward/games?uuid={{ $r->rewarduuid }}"><div class="card shadow-ss menusxx">
                        <div class="card-body">
                          <table width="100%" border="0">
                            <tr>
                              <td width="25%" rowspan="3">
                                <div class="icon icon-shape bg-purple text-white rounded-circle shadow-ss">
                                  <i class="fas fa-gift" style="color: #ffffff"></i>
                              </div>
                              </td>
                              <td><b><div style="font-size: 17px"></div></b></td>
                            </tr>
                            <tr>
                              <td>
                                <div style="font-size: 10px;color: black; padding-bottom: 8px;">Anda Mendapatkan Reward dari Mission <b>{{ $r->mission_name }}</b></div>

                                <button class="btn btn-success btn-sm">
                                  Dapatkan Hadiahmu
                                </button>
                              </td>
                            </tr>
                            
                          </table>
                        </div>
                      </div>
                    </a>
                    @else
                    <a href="/xmission/reward/detail?uuid={{ $r->rewarduuid }}"><div class="card shadow-ss menusxx">
                        <div class="card-body">
                          <table width="100%" border="0">
                            <tr>
                              <td width="25%" rowspan="3">
                                <div class="icon icon-shape bg-purple text-white rounded-circle shadow-ss">
                                  <i class="fas fa-gift" style="color: #ffffff"></i>
                              </div>
                              </td>
                              <td><b><div style="font-size: 17px"></div></b></td>
                            </tr>
                            <tr>
                              <td>
                                <div style="font-size: 14px; padding-bottom: 2px;" class="text-warning"><b>{{ $r->hadiah_name }}</b></div>
                                <div style="font-size: 10px;color: #525f7f; padding-bottom: 8px;">Anda Mendapatkan Reward dari Mission <b>{{ $r->mission_name }}</b></div>
                                <button class="btn btn-success btn-sm">
                                  Ambil Sekarang
                                </button>
                              </td>
                            </tr>
                            
                          </table>
                          <hr>
                          @php
                            date_default_timezone_set('Asia/Jakarta');
                            $tanggal = date('Y-m-d');
                            $sampai = $r->sampaireward;
                            
                            $dari = strtotime($tanggal);
                            $sam = strtotime($sampai);
                            $diff = $sam-$dari;
                            $hari = floor($diff / (60 * 60 * 24));
                          @endphp
                          <div align="center" style="color:#525f7f;"><i>{{ $hari }} Hari lagi akan Kadaluarsa!</i></div>
                        </div>
                      </div>
                    </a>

                    @endif
                    
                    <br>
                    @endforeach
              </div>
            </div>
            
          @endif
      </div>
    </div>

  @include('xmission.layout.footer')
</body>

<script type="text/javascript">

  function Selesai(id){

    $('#id').val(id);
  
    $('#konfirmasi').modal('show');

  }

  function YakinUtama(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xhome.history.selesai') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#id').val(),
      },
     success: function(data) {

      swal({
          title: "Berhasil",
          text: "Pesanan Anda sudah Selesai!",
          icon: "success",
          buttons: false,
          timer: 2000,
      });

      setTimeout(function(){ window.location.href = '/xhome/history'; }, 1500);

     }

   });

  }

</script>

</html>