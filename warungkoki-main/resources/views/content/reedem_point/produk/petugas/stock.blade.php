@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <div class="row">
        <div class="col">
         <!--  <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Update Stok</h1>
              <!-- <span class="badge badge-pill badge-default">Update Stok Terakhir : Doni Prasetyo (20 Oktober 2020 17:22)</span> -->
            </div>

            <input type="text" class="form-control" placeholder="Pencarian Produk">
            <hr>
            <a href="/produk/konfirmasi"><button class="btn btn-success btn-block">
              Konfirmasi Stock
            </button></a>
            <br>
            <div style="font-size: 12px;padding-bottom: 12px;"> Pilihlah Produk-produk dibawah ini yang <b>Tidak Ready</b>, Otomatis produk sebelumnya akan terbaharui dengan update saat ini</div>
            <table id="customers">
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Actions</th>
              </tr>
              @php $no=0; @endphp
              @foreach($products as $prod)
              @php  $no++; @endphp

              @if(!$stocks)
              <tr>
                <td>{{ $no }}</td>
                <td>{{ $prod->prod_name }} {{ $prod->name }}</td>
                <td id="act_{{ $prod->id }}">
                  <button class="btn btn-success btn-sm" onclick="Ready({{ $prod->id }});">
                    Ready
                  </button>
                </td>
              </tr>
              @else

                @php
                  $stocknya = DB::table('updatestock_details')
                  ->where([
                      ['updatestock_id', '=', $stocks->id],
                      ['post_id', '=', $prod->id]
                  ])
                  ->first();

                @endphp

                <tr>
                <td>{{ $no }}</td>
                <td>{{ $prod->prod_name }} {{ $prod->name }}</td>
                <td id="act_{{ $prod->id }}">
                  @if(!$stocknya)
                  <button class="btn btn-success btn-sm" onclick="Ready({{ $prod->id }});">
                    Ready
                  </button>
                  @else
                  <button class="btn btn-danger btn-sm" onclick="NotReady({{ $prod->id }});">
                    Not Ready
                  </button>
                  @endif
                </td>
              </tr>

              @endif
              @endforeach
            </table>
            <br>
            <a href="/produk/konfirmasi"><button class="btn btn-success btn-block">
              Konfirmasi Stock
            </button></a>
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
        url: "{{ route('stock.notready') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          $('#act_'+id).html('<button class="btn btn-danger btn-sm" onclick="NotReady('+id+');">Not Ready</button>');

        }

      });

    }

    function NotReady(id){

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.ready') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          $('#act_'+id).html('<button class="btn btn-success btn-sm" onclick="Ready('+id+');">Ready</button>');

        }

      });

    }

  </script>

</body>

</html>