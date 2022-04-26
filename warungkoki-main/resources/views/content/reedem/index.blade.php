@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">History Reedem</h1>
            </div>
            <div id="contentyourdeals" style="display: block;">
              @if($reedems->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <h6>Anda Belum Melakukan Reedem Apapun Saat ini</h6>
                  </div>

                </div>
              @else

              @foreach ($reedems as $reedem)
                <div class="card shadow">
                <div class="card-body">
                  <table width="100%" border="0">
                    <tr>
                      <td width="25%" rowspan="2">
                        <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                          <i class="fas fa-handshake" style="color: #ffffff"></i>
                      </div>
                      </td>
                      <td colspan="2"><h4><b>{{ $reedem->product_name }}</b></h5></td>
                    </tr>
                    <tr>
                      <td style="font-size: 9px;"> {{  date('d M Y H:i:s', strtotime($reedem->created_at)) }} | {{ $reedem->wilayah_name }}</td>
                    </tr>
                  </table>
                  <hr>
                  <table width="100%" border="0">
                    <tr>
                      <td style="font-size: 10px" align="center"><b>Anda Mengambil {{ $reedem->qty }} dari Saldo yang Anda Miliki</b></td>
                    </tr>
                  </table>
                </div>
                </div>
              <br>
              @endforeach
              @endif
            </div>
        </div> 
      </div> 
    </div>
  </div>
      
      @include('layout.footer')

</body>

</html>