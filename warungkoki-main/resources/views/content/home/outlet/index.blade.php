@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-7 pt-md-8">
          <!-- Card stats -->
          
          <div class="row" id="homes" style="display: block;">
            <div class="col">
              <div class="card shadow">
                <div class="card-header bg-iolo-blue">
                  <h6 class="text-uppercase text-white ls-1 mb-1">MENU</h6>
                </div>
                <div class="card-body bg-blue-par2">
                  
                  <table border="0" align="center" width="100%">
                    <tr>

                      <td align="center" width="25%">
                        <div onclick="$('#uploadpost').click();" class="icon icon-shape bg-white text-white rounded-circle shadow">
                            <i class="fas fa-camera" style="color: #1d8ee5"></i>
                        </div>
                         <input id="uploadpost" name="file" type="file" style="display:none;"/>
                      </td>

                      <td align="center" width="25%">
                        <div id="mypost" class="icon icon-shape bg-white text-white rounded-circle shadow">
                            <i class="fas fa-paper-plane" style="color: #1d8ee5"></i>
                            <input type="hidden" id="selesai" value="0">
                        </div>
                      </td>
                    </tr>

                    <tr>
                       <td height="10px" colspan="2"></td>
                    </tr>

                    <tr>
                      <td align="center">
                        <h6 class="text-uppercase text-white ls-1 mb-1">New Post</h6>
                      </td>

                      <td align="center">
                        <h6 class="text-uppercase text-white ls-1 mb-1">My Post</h6>
                      </td>

                    </tr>

                    <tr>
                       <td height="30px" colspan="2"></td>
                    </tr>

                    <tr>
                      <td align="center" width="25%">
                        <a href="/report"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                            <i class="fas fa-clipboard" style="color: #1d8ee5"></i>
                            <input type="hidden" id="selesai" value="0">
                        </div></a>
                      </td>
                      <td align="center" width="25%">
                        <a href="/reedemmission"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                            <i class="fas fa-handshake" style="color: #1d8ee5"></i>
                        </div></a>
                      </td>
                    </tr>
                    <tr>
                       <td height="10px" colspan="2"></td>
                    </tr>

                    <tr>
                      <td align="center">
                        <h6 class="text-uppercase text-white ls-1 mb-1">Reporting</h6>
                      </td>
                      <td align="center">
                        <h6 class="text-uppercase text-white ls-1 mb-1">Reedem Mission</h6>
                      </td>
                    </tr>
                  </table>
                  
                </div>
              </div>
            </div>    
          </div>
          <br>
          <div class="card card-stats mb-4 mb-lg-0">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Pengambilan Hari Ini</h5>
                        <span class="h1 font-weight-bold mb-0">{{ $reedemhariini->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card card-stats mb-4 mb-lg-0">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Pembelian Hari Ini</h5>
                        <span class="h1 font-weight-bold mb-0">{{ $transaksihariini->count() }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fas fa-bullhorn"></i>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card card-stats mb-4 mb-lg-0">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Transaksi Rupiah Hari Ini</h5>
                        <span class="h1 font-weight-bold mb-0">Rp. {{ number_format($transaksirupiah,0,'.',',') }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fas fa-credit-card"></i>
                      </div>
                    </div>
                </div> 
            </div>
          </div>
          
          
      @include('content.home.principle.modal')
      @include('layout.footer')
      @include('script.principle')

      <script type="text/javascript">
        
        $( document ).ready(function() {

            setTimeout(function(){ window.location.href = '/outlet'; }, 40000);

        });
      </script>
</body>

</html>