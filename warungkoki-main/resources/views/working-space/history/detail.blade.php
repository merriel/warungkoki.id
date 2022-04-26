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
      <div class="card shadow-ss">
        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">

            <div style="font-size: 16px; color: #323232;"><b>BARCODE</b></div><hr>
            <table>
              <tr>
                <td>
                  <img width='100%' alt='barcode' src='https://iolosmart.com/assets/barcode/barcode.php?codetype=Code128&size=85&text={{ $barcode->uuid }}'><br> <div style='padding-top: 15px;font-size: 15px;' align='center'><u><b>{{ $barcode->uuid }}</b></u></div>
                </td>
              </tr>
              <tr>
                <td align="center"><b><div style="font-size: 11px">Tunjukan Barcode ini Ke Petugas kami Yang Berjaga !</div></b></td>
              </tr>
            </table>
            
        </div>
      </div>
    </div>
  </div>
</div>
     
@include('working-space.layout.footer')