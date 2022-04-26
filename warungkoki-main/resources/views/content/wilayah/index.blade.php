@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Master Wilayah</h1>
            </div>
            <button class="btn btn-sm btn-success" id="tambahwilayah" type="button"><i class="fa fa-plus"></i>Tambah Wilayah</button>
            <br><br>

            @if($areas->count() == '0')
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
            @foreach($areas as $area)

            <div class="card shadow" id="data_{{ $area->id }}" onclick="Actions({{ $area->id }})">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="3">
                      <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                        <i class="fas fa-home" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td><b><div style="font-size: 17px">{{ $area->name }}</div></b></td>
                  </tr>
                  <tr>
                    <td><h6>{{ $area->alamat }}</h6></td>
                  </tr>
                </table>
                <div style="display: none;" id="content_{{ $area->id }}">
                  <hr>
                  <table width="100%">
                    <tr>
                      <td align="center"><button class="btn btn-sm btn-info editwilayah" data-id="{{ $area->id }}" data-name="{{ $area->name }}" data-alamat="{{ $area->alamat }}" type="button"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-sm btn-danger deletewilayah" data-id="{{ $area->id }}" type="button"><i class="fa fa-trash"></i> Delete</button></td>
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
      @include('content.wilayah.modal')
      @include('layout.footer')
      @include('script.wilayah')

</body>

</html>