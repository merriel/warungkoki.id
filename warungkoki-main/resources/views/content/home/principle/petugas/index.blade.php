@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Master Petugas</h1>
            </div>
            <button class="btn btn-sm btn-success" id="tambahpetugas" type="button"><i class="fa fa-plus"></i> Tambah Petugas</button>
            <br><br>

            @if($petugass->count() == '0')
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
            @foreach($petugass as $petugas)

            <div class="card shadow" id="data_{{ $petugas->id }}" onclick="Aksi({{ $petugas->id }})">
              <div class="card-body">
                <table width="100%" border="0">
                  <tr>
                    <td width="25%" rowspan="3">
                      <div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow">
                        <i class="fas fa-child" style="color: #ffffff"></i>
                    </div>
                    </td>
                    @php

                      $biday = new DateTime($petugas->tanggal_lahir);
                      $today = new DateTime();
                      $diff = $today->diff($biday);

                    @endphp

                    <td><b><div style="font-size: 17px">{{ $petugas->name }}</div></b></td>
                  </tr>
                  <tr>
                    <td><h6>{{ $diff->y }} Tahun | {{ $petugas->wilayah_name }}</h6></td>
                  </tr>
                </table>
                <div style="display: none;" id="content_{{ $petugas->id }}">
                  <hr>
                  <table width="100%" >
                    <tr>
                      <td align="center"><button class="btn btn-sm btn-primary editpetugas" data-id="{{ $petugas->id }}" data-username="{{ $petugas->email }}" data-name="{{ $petugas->name }}" data-jenkel="{{ $petugas->jenkel }}" data-tgl="{{ $petugas->tanggal_lahir }}" data-hp="{{ $petugas->no_hp }}" data-alamat="{{ $petugas->alamat }}" data-wilayah="{{ $petugas->wilayah_id }}" type="button"><i class="fa fa-edit"></i> Edit</button><button class="btn btn-sm btn-danger deletepetugas" data-id="{{ $petugas->id }}" type="button"><i class="fa fa-trash"></i> Delete</button><button class="btn btn-sm btn-warning" onclick="ResetPetugas({{ $petugas->id }})" type="button"><i class="fa fa-key"></i> Reset Pass</button></td>
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
      @include('content.home.principle.petugas.modal')
      @include('layout.footer')
      @include('script.createpetugas')

</body>

</html>