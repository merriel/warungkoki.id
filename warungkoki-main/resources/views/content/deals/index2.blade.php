@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Deals</h1>
            </div>
            <div class="alert alert-primary2" role="alert">
                <button id="yourdeals" class="btn btn-sm btn-success" type="button">YOUR DEALS</button>
                <button id="past" class="btn btn-sm btn-secondary" type="button">PAST</button>
            </div>
            <br>
            <div id="contentyourdeals" style="display: block;">
              @if($postdeals->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <h6>Anda Belum Memiliki Saldo Deals untuk saat ini</h6>
                  </div>

                </div>
              @else

              @foreach ($postdeals as $postdeal)

              <!-- @php

                $sald = DB::table('saldo')
                  ->select(DB::raw('SUM(sisa) as sisa_saldo'))
                  ->where([
                      ['post_id', '=', $postdeal->id],
                      ['user_id', '=', $userID],
                  ])
                  ->get();

              @endphp -->
              <a href="/users/deals/{{ $postdeal->id }}" class="lihat">
                <div class="card shadow">
                <div class="card-body {{ $sald }}">
                  <table width="100%" border="0">
                    <tr>
                      <td width="25%" rowspan="3">
                        <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                          <i class="fas fa-handshake" style="color: #ffffff"></i>
                        </div>
                      </td>
                      <td colspan="2"><h5><b>{{ $postdeal->name }}</b></h5></td>
                    </tr>
                    <tr>
                      <td width="20%"><span class="badge badge-pill badge-primary" style="font-size: 9px;"><i class="fas fa-calendar"></i> Exp : {{  date('d M Y', strtotime($postdeal->sampai)) }}</span></td>
                      <td><span class="badge badge-pill badge-danger" style="font-size: 9px;"><i class="fas fa-clock"></i> 

                        @php

                        $exp = new DateTime($postdeal->sampai);
                        $today = new DateTime();
                        $diff = $today->diff($exp);

                        @endphp

                      {{ $diff->days }} Hari Lagi</span></td>
                    </tr>
                  </table>
                </div>
                </div>
              </a>
              <br>
              @endforeach
              @endif
            </div>

            <div id="contentpast" style="display: none;">
              @if($pastdeals->count() == 0)
                <div class="card shadow">
                  <div class="card-body">
                    <h6>Belum ada Data Deals Lampau Saat ini!</h6>
                  </div>
                </div>
              @else

              @foreach ($pastdeals as $pastdeal)
                <div class="card shadow kadaluarsa">
                  <div class="card-body">
                    <table width="100%" border="0">
                      <tr>
                        <td width="25%" rowspan="3">
                          <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                            <i class="fas fa-handshake" style="color: #ffffff"></i>
                        </div>
                        </td>
                        <td colspan="2"><h5><b>{{ $pastdeal->name }}</b></h5></td>
                      </tr>
                      <tr>
                        <td width="20%"><span class="badge badge-pill badge-primary" style="font-size: 9px;"><i class="fas fa-calendar"></i> Exp : {{  date('d M Y', strtotime($pastdeal->sampai)) }}</span></td>
                        <td><span class="badge badge-pill badge-danger" style="font-size: 9px;"><i class="fas fa-clock"></i> KADALUARSA</span></td>
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

      <script type="text/javascript">
        
        $('#past').on('click', function () {

          $('#contentyourdeals').attr('style', 'display: none;');
          $('#contentpast').attr('style', 'display: block;');

          $('#yourdeals').attr('class', 'btn btn-sm btn-secondary');
          $('#past').attr('class', 'btn btn-sm btn-success');

        });

        $('#yourdeals').on('click', function () {

          $('#contentyourdeals').attr('style', 'display: block;');
          $('#contentpast').attr('style', 'display: none;');

          $('#yourdeals').attr('class', 'btn btn-sm btn-success');
          $('#past').attr('class', 'btn btn-sm btn-secondary');

        });

        $('.kadaluarsa').on('click', function () {

          swal({
              title: "Warning",
              text: "Deals Anda sudah Kadaluarsa!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

        });

        $('.lihat').on('click', function () {

            $('.loading').attr('style','display: block');

        });

      </script>

</body>

</html>