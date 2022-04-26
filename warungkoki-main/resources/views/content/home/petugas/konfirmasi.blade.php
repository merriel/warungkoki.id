@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <div class="row">
        <div class="col">
          <!-- <a href="/produk/stock"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Konfirmasi Update</h1>
              
            </div>
            <hr>
            <br>
            @if($stocks)
            <div style="font-size: 12px;"> Berikut adalah Produk yang Akan Anda Update, Produk Tersebut dibawah ini <b>TIDAK ADA STOCK / NOT READY</b> Anda yakin akan melanjutkan Perbaharuan ini?</div>
            <table id="customers">
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Keterangan</th>
              </tr>
              @php $no=0; @endphp
              @foreach($details as $det)
              @php  $no++; @endphp

              <tr>
                <td>{{ $no }}</td>
                <td>{{ $det->prod_name }} {{ $det->name }}</td>
                <td>
                  <div class="text-danger"><b>Not Ready</b></div>
                </td>
              </tr>
              
              @endforeach
            </table>
            <br>
            @else
              <div class="card shadow-ss" style="background-color: #fb6340;">
                <div class="card-body">
                  <table>
                    <tr>
                      <td>
                        <i class="fa fa-exclamation-triangle" style="font-size: 24px;color: white;"></i>
                      </td>
                      <td width="3%">&nbsp;</td>
                      <td>
                          <div style="font-size: 13px;" class="text-white">
                            <b>TIDAK ADA STOK YANG KOSONG</b>
                          </div>
                          <div style="font-size: 11px; padding-bottom: 12px;" class="text-white">
                            Tidak ada stok yang kosong, artinya semua stok ready! pastikan bahwa stok benar benar ready semua, jika memang benar ready semua anda bisa melanjutkan update stock sekarang.
                          </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <br>
            @endif
            <button onclick="UpdateStockNow()" class="btn btn-success btn-block">
              Update Stock Sekarang
            </button>
            <br><br>
        </div> 
      </div> 
    </div>
  </div>
  @include('layout.footer')

  <script type="text/javascript">
    
    function UpdateStockNow(){

      $.ajax({
        type: 'GET',
        url: "{{ route('stock.update') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            },

        success: function(data) {

          swal({
            title: "Berhasil",
            text: "Update Produk Berhasil!",
            icon: "success",
            buttons: false,
            timer: 2000,
          });
          setTimeout(function(){ window.location.href = '/home'; }, 1500);

        }

      });

    }



  </script>

</body>

</html>