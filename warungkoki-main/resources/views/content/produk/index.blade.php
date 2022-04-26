@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Master Produk</h1>
            </div>
            <button class="btn btn-sm btn-success" id="tambahprod" type="button"><i class="fa fa-plus"></i>Tambah Produk</button>
            <br><br>

            @if($getprods->count() == '0')
            <div class="card shadow">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td><h6>Belum Ada Record Apapun Pada Tab ini!</h6></td>
                  </tr>
                </table>
              </div>
            </div>

            @else
            @foreach($getprods as $getprod)

            <div class="card shadow" id="data_{{ $getprod->id }}" onclick="Actions({{ $getprod->id }})">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="3">
                      <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                        <i class="fas fa-archive" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td><b><div style="font-size: 15px">{{ $getprod->name }}</div></b></td>
                  </tr>
                  <tr>
                    <td class="text-warning"><b>{{ rupiah($getprod->harga) }}</b></td>
                  </tr>

                  @if($getprod->garansi_id != null)
                  <tr>
                    <td><span class="badge badge-warning">Terdapat Garansi pada Produk ini</span></td>
                  </tr>
                  @endif
                </table>
                <div style="display: none;" id="content_{{ $getprod->id }}">
                  <hr>
                  <table width="100%">
                    <tr>
                      <td align="center"><button class="btn btn-sm btn-info editproduct" data-id="{{ $getprod->id }}" data-name="{{ $getprod->name }}" data-price="{{ $getprod->harga }}" type="button"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-sm btn-danger deleteproduct" data-id="{{ $getprod->id }}" type="button"><i class="fa fa-trash"></i> Delete</button></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <br>
            @endforeach
            @endif
        </div> 
      </div> 
    </div>
  </div>
      @include('content.produk.modal')
      @include('layout.footer')
      @include('script.produk')

  <script type="text/javascript">
    
    $('#customCheck1').on('change', function () {

      if($(this).is(':checked')){

        $('#garans').attr("style", "display: block;");
        
      } else {

        $('#garans').attr("style", "display: none;");
        
      }

    });

  </script>

</body>

</html>