@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="row">
        <div class="col">
         <!--  <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Update Stok</h1>
              <!-- <span class="badge badge-pill badge-default">Update Stok Terakhir : Doni Prasetyo (20 Oktober 2020 17:22)</span> -->
            </div>
<!-- 
            <input type="text" class="form-control" placeholder="Pencarian Produk"> -->
            <hr>
            <div style="font-size: 12px;padding-bottom: 12px;"> Berikut adalah data produk yang saat ini aktif atau tidak aktif, cek Produk di bawah ini yang Stock nya yang aktif atau tidak aktif,</div>
            <table id="customers">
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Aksi</th>
              </tr>
              @php $no=0; @endphp
              @foreach($products as $prod)
              @php  $no++; @endphp

              <tr>
                <td>{{ $no }}</td>
                <td>{{ $prod->prod_name }} {{ $prod->name }}</td>
                <td>
                  <label class="custom-toggle">
                    @if($prod->active == "Y")
                      <input type="checkbox" onclick="NotReady({{ $prod->id }});" checked>
                    @else
                      <input type="checkbox" onclick="Ready({{ $prod->id }});">
                    @endif
                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                  </label>

                </td>
                
              </tr>
              
              @endforeach
            </table>
            <br>
            <!-- <br>
            <a href="/produk/konfirmasi"><button class="btn btn-success btn-block">
              Konfirmasi Stock
            </button></a> -->
        </div> 
      </div> 
      <br><br>
    </div>
  </div>
  @include('layout.footer')

  <script type="text/javascript">
    
    function Ready(id){

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.notready2') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          setTimeout(function(){ window.location.reload() }, 100);

        }

      });

    }

    function NotReady(id){

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.ready2') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          setTimeout(function(){ window.location.reload() }, 100);

        }

      });

    }

  </script>

</body>

</html>