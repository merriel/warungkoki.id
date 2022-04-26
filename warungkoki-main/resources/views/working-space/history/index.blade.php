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

            <div style="font-size: 16px; color: #323232;"><b>History Transaksi Anda</b></div><hr>
            @foreach($transaksis as $transaksi)
            <div class="card shadow-ss">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="3">
                      <div class="icon icon-shape bg-gradient-shell text-white rounded-circle shadow-ss">
                        <i class="fas fa-building" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td>
                      <b><div style="font-size: 14px;" class="text-warning">{{ $transaksi->desk_code }}</div></b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div style="font-size: 12px;color: black;padding-bottom: 5px;">
                      <b>{{ hari_ini(date('D', strtotime($transaksi->date))) }} | {{ date('d F Y', strtotime($transaksi->date)) }}</b><br>
                      <div style="font-size: 10px;">{{ $transaksi->room_name }} - {{ $transaksi->alamat }} {{ $transaksi->regency_name }}<b></b></div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      @if($transaksi->type == 'hour')
                      <span class="badge badge-success"><i class="fa fa-calendar"></i> {{ $transaksi->dari }} - {{ $transaksi->sampai }}</span>
                      @else
                      <span class="badge badge-success"><i class="fa fa-calendar"></i> Satu Hari</span>
                      @endif
                      <span class="badge badge-info"><i class="fa fa-credit-card"></i> {{ rupiah($transaksi->amount) }}</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <br>
            @endforeach
            
        </div>
      </div>
    </div>
  </div>
</div>
     
@include('working-space.layout.footer')