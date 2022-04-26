@include('working-space.layout.head')
<div class="main-content">
<!-- Header -->
<div class="header bg-gradient-shell pb-7 pt-3 pt-md-8">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->
      
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-xl-0">
            <!-- <div class="row">
                <div class="col-12">
                    <input type="text" class="form-control shadow-ss" placeholder="Cari Ruangan Disini">
                </div>
            </div>
            <br> -->
            <div class="card shadow-ss" style="background-color: #EFDBB2;">
                <div class="card-body">
                    <div style="font-size: 13px;color: #323232;">Hello,</div>
                    <div style="font-size: 19px;color: #323232; padding-bottom: 6px;"><b>{{ $user->name }}</b></div>
                    <div style="font-size: 10px;color: #323232;">Selamat Datang, Hari ini Mau Booking Working Space dimana nih!</div>
                    <!-- <hr>
                    <div style="font-size: 14px; padding-bottom: 14px; color: #323232;">
                        <b> Order Anda</b>
                    </div> -->
                    <!-- <div class="row">
                        <div class="col-4">
                            <div class="card shadow-ss" style="background-color: #ffffff">
                                <div class="card-body" style="padding-left: 1rem;padding-right: 1rem;">
                                  <table width="100%" border="0">
                                    <tr>
                                      <td align="center"><i class="fa fa-history" style="font-size: 26px; color: #323232"></i></td>
                                    </tr>
                                    <tr>
                                      <td height="7px"></td>
                                    </tr>
                                    <tr>
                                      <td align="center"><h6><b>Order Anda</b></h6></td>
                                    </tr>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card shadow-ss" style="background-color: #ffffff">
                                <div class="card-body" style="padding-left: 1rem;padding-right: 1rem;">
                                  <table width="100%" border="0">
                                    <tr>
                                      <td align="center"><i class="fa fa-cloud" style="font-size: 26px; color: #323232"></i></td>
                                    </tr>
                                    <tr>
                                      <td height="7px"></td>
                                    </tr>
                                    <tr>
                                      <td align="center"><h6><b>Transaksi Anda</b></h6></td>
                                    </tr>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card shadow-ss" style="background-color: #ffffff">
                                <div class="card-body" style="padding-left: 1rem;padding-right: 1rem;">
                                  <table width="100%" border="0">
                                    <tr>
                                      <td align="center"><i class="fa fa-user" style="font-size: 26px; color: #323232"></i></td>
                                    </tr>
                                    <tr>
                                      <td height="7px"></td>
                                    </tr>
                                    <tr>
                                      <td align="center"><h6><b>Profile Anda</b></h6></td>
                                    </tr>
                                  </table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <br>
    <div style="font-size: 16px; padding-bottom: 14px; color: #323232;">
        <b> New Working Space</b>
    </div>

    @foreach($rooms as $room)
    <div class="row" style="padding-bottom: 14px;">
        <div class="col-12">
          <a href="/working-space/detail?uuid={{ $room->uuid }}" class="post menusxx">
          <div class="card shadow-ss" style="background-color: #EFDBB2;">
            <div class="gambar">
              <img class="card-img-top" src="{{ asset ('assets/img_workingspace/'.$room->img) }}" alt="Card image cap">
            </div>
            <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                <div style="font-size: 18px;padding-bottom: 6px; color: #323232;"><b>{{ $room->room_name }}</b></div>
                <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $room->wilayah_name }}</span>
                <div style="font-size: 9px;color: #323232;padding-top: 6px;">
                  Lokasi berada di {{ $room->alamat }} <b>{{ $room->regency_name }}</b>
                </div>            
                <hr style="margin-bottom: 0.6rem;margin-top: 0.6rem;">
                <table width="100%">
                    <tr>
                        <td align="left">
                        <table>
                            <tr>
                                <td>
                                   <b class="text-warning" style="font-size: 14px;">{{ rupiah($room->harga_hour) }}</b>
                                </td>
                                <td>
                                   <div style="font-size: 9px;color: #323232;"><b>/ Per Jam</b></div>
                                </td>
                            </tr>
                        </table>
                        </td>
                        <td>
                          <table>
                            <tr>
                                <td>
                                   <b class="text-warning" style="font-size: 14px;">{{ rupiah($room->harga_day) }}</b>
                                </td>
                                <td>
                                   <div style="font-size: 9px;color: #323232;"><b>/ Per Hari</b></div>
                                </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                </table>
            </div>
          </div>
          </a>
        </div> 
    </div>

    @endforeach

    <!-- <div style="font-size: 16px; padding-bottom: 14px; color: #323232;">
        <b> New Working Space</b>
    </div>
    <div class="row">
        <div class="col-6" style="padding-right: 7.5px;">
          <a href="/working-space/detail" class="post">
          <div class="card shadow-ss" style="background-color: #EFDBB2;">
            <div class="gambar">
              <img class="card-img-top" width="50px" src="/assets/content/img/theme/cowork.jpeg" alt="Card image cap">
            </div>
            <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
              <h5><b>Ruangan Standard Karawaci</b></h5>
                <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> Shell Karawaci</span>
              <br>
              <div style="font-size: 9px;padding-top: 12px;color: #323232;">
                Tempat ini tersedia di daerah <b>Kota Tangerang</b>
              </div>            
              <hr style="margin-bottom: 0.6rem;margin-top: 0.6rem;">
              <table>
                <tr>
                    <td>
                       <b class="text-warning" style="font-size: 14px;">Rp. 70.000</b>
                    </td>
                    <td>
                       <div style="font-size: 8px;color: #323232;">/ Per Hari</div>
                    </td>
                </tr>
            </table>
            </div>
          </div>
          </a>
        </div> 
        <div class="col-6" style="padding-left: 7.5px;">
            <a href="/working-space/detail" class="post">
            <div class="card shadow-ss" style="background-color: #EFDBB2;">
                <div class="gambar">
                  <img class="card-img-top" width="50px" src="/assets/content/img/theme/cowork.jpeg" alt="Card image cap">
                </div>
                <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <h5><b>Ruangan Standard Karawaci</b></h5>
                        <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> Shell Karawaci</span>
                    <br>
                    <div style="font-size: 9px;padding-top: 12px;color: #323232;">
                        Tempat ini tersedia di daerah <b>Kota Tangerang</b>
                    </div>            
                    <hr style="margin-bottom: 0.6rem;margin-top: 0.6rem;">
                    <table>
                        <tr>
                            <td>
                               <b class="text-warning" style="font-size: 14px;">Rp. 70.000</b>
                            </td>
                            <td>
                               <div style="font-size: 8px;color: #323232;">/ Per Hari</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            </a>
        </div> 
    </div> -->
</div>
        
      
@include('working-space.layout.footer')
</body>

</html>