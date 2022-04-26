@include('layout.head')
<div class="main-content">
  <!-- Header -->
<div class="container-fluid pb-4 pt-7 pt-md-8">
      <!-- Card stats -->
  <div class="row" id="master" style="display: block;">
    <div class="col">
      <div class="card shadow">
        <div class="card-header bg-iolo-blue">
          <h6 class="text-uppercase text-white ls-1 mb-1">MENU MASTER</h6>
        </div>
        <div class="card-body bg-blue-par2">
          <!-- <table border="0" align="center" width="100%">
            <tr>
              <td align="center" width="25%">
                <a href="/produk"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-gift" style="color: #1d8ee5"></i>
                </div></a>
              </td>
              <td align="center" width="25%">
                <a href="/wilayah"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-globe" style="color: #1d8ee5"></i>
                    <input type="hidden" id="selesai" value="0">
                </div>
                </a>
              </td>
            </tr>
            <tr>
               <td height="10px" colspan="7"></td>
            </tr>
            <tr>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Produk</h6>
              </td>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Cabang</h6>
              </td>
            </tr>
          </table>
          <br> -->
          <table border="0" align="center" width="100%">
            <tr>
              <td align="center" width="25%">
                <a href="/voucher"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-magic" style="color: #1d8ee5"></i>
                </div></a>
              </td>
              <td align="center" width="25%">
                <a href="/saldo/add"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-coffee" style="color: #1d8ee5"></i>
                </div>
                </a>
              </td>
              <td align="center" width="25%">
                <a href="/datahadiah"><div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-chart-bar" style="color: #1d8ee5"></i>
                </div>
                </a>
              </td>
            </tr>
            <tr>
               <td height="10px" colspan="7"></td>
            </tr>
            <tr>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Voucher</h6>
              </td>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">TambahSaldo</h6>
              </td>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Hadiah</h6>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>    
  </div>
  <!-- <div class="row" id="homes" style="display: none;">
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
               <td height="10px" colspan="7"></td>
            </tr>
            <tr>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">New Post</h6>
              </td>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">My Post</h6>
              </td>
            </tr>
          </table>
          <br>
          <table border="0" align="center" width="100%">
            <tr>
              <td align="center" width="25%">
                <div id="datamaster" class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-bolt" style="color: #0166b5"></i>
                </div>
              </td>
              <td align="center" width="25%">
                <div class="icon icon-shape bg-white text-white rounded-circle shadow">
                    <i class="fas fa-barcode" style="color: #0166b5"></i>
                </div>
              </td>
            </tr>
            <tr>
               <td height="10px" colspan="7"></td>
            </tr>
            <tr>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Data Master</h6>
              </td>
              <td align="center">
                <h6 class="text-uppercase text-white ls-1 mb-1">Scan</h6>
              </td>
            </tr>
          </table>

        </div>
      </div>
    </div>    
  </div> -->
  <br>
  <div class="card card-stats mb-4 mb-lg-0">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h6 class="card-title text-uppercase text-muted mb-0">Transaksi Ambil Hari Ini</h6>
                <span class="h1 font-weight-bold mb-0">{{ $reedemhariini }}</span>
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
                <h6 class="card-title text-uppercase text-muted mb-0">Produk yang  diambil Hari Ini</h6>
                <span class="h1 font-weight-bold mb-0">{{ $prodreedems }}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                  <i class="fas fa-laptop"></i>
              </div>
            </div>
        </div>
        
    </div>
  </div>
  <hr>     
          
@include('content.home.principle.modal')
@include('layout.footer')
@include('script.principle')
</body>

</html>