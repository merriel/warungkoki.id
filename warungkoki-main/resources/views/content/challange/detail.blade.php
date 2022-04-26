@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-4 pt-md-8">
          <!-- Card stats -->
          <a href="/users/challanges"><button type="button" class='btn btn-sm btn-success'>Kembali</button></a><br><br>
          <div class="row">
            <div class="col-12">
              <div class="card shadow">
                <div class="type">
                  <span class="badge badge-pill badge-primary">{{ $postnews->type }}</span>
                </div>
                <img class="card-img-top" src="{{ asset('assets/img_post/') }}/{{ $postnews->imgname }}" alt="Card image cap">
                <div class="card-body">
                  <h3><b>{{ $postnews->name }}</b></h3><hr>
                  <button onclick="Ikut({{ $postid }})" class="btn btn-kuning"> Ikut Challange</button>
                 <h5 style="text-decoration:line-through;"></h5>
                  <hr>

                  <!-- ==== Produk Detail ===== -->
                  <div id="produkdetails" class="contentmenu" style="display: block;">
                    
                  <h6 align="justify">{{ $postnews->desc }}</h6><br>

                    <h6><b>SETIAP PEMBELIAN PRODUK BERIKUT :</b></h6>
                    @if($postnews->jenis_challange == 'global')

                      <table id="customers">
                      <tr>
                        <th>Nama Produk</th>
                        <th>Value</th>
                      </tr>     
                      <tr>
                        <td>
                          @foreach($postproducts as $postproduct)
                            {{ $postproduct->name }}, 
                          @endforeach
                        </td>
                        <td width="40%" align="right"><div style="font-size: 9px;">Total Belanja Hingga : </div>{{ rupiah($postnews->value_challange) }}</td> 
                      </tr>

                    </table>

                    @else
                    <table id="customers">
                      <tr>
                        <th>Nama Produk</th>
                        <th>Value</th>
                      </tr>
                      @foreach($postproducts as $postproduct)
                      <tr>
                        <td>{{ $postproduct->name }}</td>
                        @if($postproduct->qty >= 1000)
                          <td>{{ rupiah($postproduct->qty) }}</td>
                        @else
                          <td>{{ $postproduct->qty }} Pcs</td>
                        @endif
                        
                      </tr>
                      @endforeach
                    </table>
                    @endif
                    <br>

                    <table id="customers">
                      <tr>
                        <th>Periode Challange</th>
                      </tr>
                      <tr>
                        <td><b>{{ date('d F Y', strtotime($postnews->dari)) }} s/d {{ date('d F Y', strtotime($postnews->sampai)) }}</b></td>
                      </tr>
                    </table>
                    <hr>

                    <h6><b>HADIAH YANG AKAN DIDAPATKAN :</b></h6>
                    <table id="customers">
                      <tr>
                        <th>Nama Produk</th>
                        <th>Value</th>
                      </tr>
                      @foreach($postrewards as $postreward)
                      <tr>
                        <td>{{ $postreward->name }}</td>
                        @if($postreward->qty >= 1000)
                          <td>{{ rupiah($postreward->qty) }}</td>
                        @else
                          <td>{{ $postreward->qty }} Pcs</td>
                        @endif
                        
                      </tr>
                      @endforeach
                    </table>
                     <br>

                     <table id="customers">
                      <tr>
                        <th>Batas Penukaran Hadiah</th>
                      </tr>
                      <tr>
                        <td><b>{{ date('d F Y', strtotime($postnews->dari_reward)) }} s/d {{ date('d F Y', strtotime($postnews->sampai_reward)) }}</b></td>
                      </tr>
                    </table>
                    <hr>

                    <h6><b>INFO PENUKARAN HADIAH :</b></h6>
                    <table id="customers">
                      <tr>
                        <th>Tempat</th>
                        <th>Alamat</th>
                      </tr>
                      @foreach($postareas as $postarea)
                      <tr>
                        <td>{{ $postarea->name }}</td>
                        <td>{{ $postarea->alamat }}</td>                      
                      </tr>
                      @endforeach
                    </table>

                    <hr>
                    <h4><b>Penjual :</b></h4>
                    <table width="100%" >
                      <tr>
                        <td rowspan="3" width="30%"><img class="shadow" width="100%" src="/assets/img_company/{{ $postnews->photo }}"></td>
                        <td width="5%"></td>
                        <td style="font-size: 16px;"><a href="/company/profile/{{ $postnews->wilayah_id }}"><b>{{ $postnews->wilayah_name }}</b></a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><span class="badge badge-pill badge-success">{{ $postnews->regency_name }}</span></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><h6>Sudah Menjual Lebih dari 100 Produk</h6></td>
                      </tr>
                    </table>
                    <br>
                    @php
                      $ada = DB::table('follow')
                      ->where([
                        ['wilayah_id', '=', $postnews->wilayah_id],
                        ['user_id', '=', $userid],
                      ])
                      ->first();
                    @endphp
                    <table width="100%">
                      <tr align="center">
                        <td>
                          @if(!$ada)
                            <button onclick="Follow({{ $postnews->wilayah_id }})" class="btn btn-info btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Follow</button>
                          @else
                            <button onclick="Unfollow({{ $postnews->wilayah_id }})" class="btn btn-warning btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Unfollow</button>
                          @endif
                        </td>
                        <td><button class="btn btn-success btn-sm btn-block" type="button"><i class="fa fa-envelope"></i> Messages</button></td>
                      </tr>
                    </table>
                  <hr>
                  </div>
                  <!-- ==== End Of Product Detail ===== -->
                  
                </div>
              </div>
            </div>    
          </div>

@include('content.challange.modal')
@include('layout.footer')

<script type="text/javascript">
  
  function Ikut(id){

    $('#ids').val(id);

    $('#ikutan').modal('show');

  }

  $('#ikut').on('click', function () {

    $.ajax({
      type: 'POST',
      url: "{{ route('ikutchallanges') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#ids').val(),  
      },
      success: function(data) {

        if(data == '1'){

          swal({
              title: "Perhatikan",
              text: "Anda sudah Ikut Challange ini!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

        } else {

          swal({
              title: "Berhasil",
              text: "Anda Berhasil ikut Challange ini!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          $('#ikutan').modal('hide');

          setTimeout(function(){ window.location.href = '/users/challanges'; }, 1500);

        }

      }

    });

  });

</script>
      
</body>

</html>