@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Master Garansi</h1>
            </div>
            <button class="btn btn-sm btn-success" id="tambahgaransi" type="button"><i class="fa fa-plus"></i>Tambah Garansi</button>
            <br><br>
            @if($getgaransis->count() == '0')
            <div class="card shadow">
              <div class="card-body">
                <h6>Data Garansi Belum Ada</h6>
              </div>
            </div>

            @else
            @foreach($getgaransis as $getgaransi)

            <div class="card shadow" id="data_{{ $getgaransi->id }}" onclick="Actions({{ $getgaransi->id }})">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="2">
                      <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                        <i class="fas fa-magic" style="color: #ffffff"></i>
                    </div>
                    </td>
                    <td><b><div style="font-size: 15px">{{ $getgaransi->name }}</div></b></td>
                  </tr>
                  <tr>
                    <td><b><div style="font-size: 10px">Jangka Waktu : {{ $getgaransi->jangka_garansi }} {{ $getgaransi->type_waktu }}</div></b></td>
                  </tr>
                </table>
                <div style="display: none;" id="content_{{ $getgaransi->id }}">
                  <hr>
                  <table width="100%">
                    <tr>
                      <td align="center"><button class="btn btn-sm btn-info editgaransi" data-id="{{ $getgaransi->id }}" data-name="{{ $getgaransi->name }}" data-jangka="{{ $getgaransi->jangka_garansi }}" data-waktu="{{ $getgaransi->type_waktu }}" data-text="{{ $getgaransi->ket }}" type="button"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-sm btn-danger deletegaransi" data-id="{{ $getgaransi->id }}" type="button"><i class="fa fa-trash"></i> Delete</button></td>
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
      @include('content.garansi.modal')
      @include('layout.footer')
      @include('script.garansi')

</body>

</html>