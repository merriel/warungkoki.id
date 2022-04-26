@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/mypost"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h2 class="ct-title" id="content">Edit Post {{ $detailposts->name }}</h2>
            </div>
        </div>
      </div>
      <div class="card shadow">
        <div class="card-body">
          <div class="row">
            <table>
              <tr>
                <td id="uploadganti" align="center"><img id="images" src="/assets/img_post/{{ $detailposts->img_name }}" width="100%"></td>
              </tr>
              <tr>
                <td align="center"><br>

                  <div onclick="$('#uploadpost').click();" class="alert2 alert-primary" style="padding-top: 12px; padding-bottom: 12px;" role="alert">
                      <div style="font-size: 10px;"><i class="fas fa-camera" style="font-size: 14px;"></i> &nbsp; Ganti Gambar</div>
                  </div>
                  <input id="uploadpost" name="file" type="file" style="display:none;"/>
                  <input type="hidden" id="idx" value="{{ $detailposts->id }}">
                  </div>

                </td>
              </tr>
            </table>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Judul Posting :</label>
                <input type="text" class="form-control" value="{{ $detailposts->name }}" id="editname">
              </div>
            </div>
            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Status Produk :</label>
                <select class="form-control" id="active">
                  @php
                  if($detailposts->active == 'Y'){
                    $yes = 'selected';
                    $no = '';
                  }else{
                    $yes = '';
                    $no = 'selected';
                  }
                  @endphp
                  <option value="Y" {{ $yes }}>AKTIF</option>
                  <option value="N" {{ $no }}>TIDAK AKTIF/STOCK KOSONG</option>
                </select>
              </div>
            </div>
            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Type :</label>
                <input type="text" class="form-control" value="{{ $detailposts->type }}" disabled>
                <input type="hidden" class="form-control" id="typeedit" value="{{ $detailposts->type }}">
              </div>
            </div>
            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Pilih Kategori :</label>
                <select class="form-control" id="kategoriedit">
                    @foreach($kategoris as $kategori)
                    @php
                      if($kategori->id == $detailposts->kategori_id){
                        $selected = 'selected';
                      } else {
                        $selected = '';
                      }

                    @endphp
                    <option value="{{ $kategori->id }}" {{ $selected }}>{{ $kategori->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            @if($detailposts->type == 'Products')
              <div class="col-md-12" style="padding-bottom: 0px;">
                <div class="form-group" align="left">
                  <label class="form-control-label">Barang Bisa Delivery? :</label>
                  <select class="form-control" id="deliveredit">
                    @php
                    if($detailposts->deliver == 'yes'){
                      $selectid = 'selected';
                    } else {
                      $selectid = '';
                    }
                    @endphp
                    <option value="no" {{ $selectid }}> Tidak</option>
                    <option value="yes" {{ $selectid }}> Ya</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12" style="padding-bottom: 0px;">
                <div class="form-group" align="left">
                  <label class="form-control-label">Barang Pre-Order? :</label>
                  <select class="form-control" id="poedit">
                    @php
                    if($detailposts->po == 'yes'){
                      $selectud = 'selected';
                    } else {
                      $selectud = '';
                    }
                    @endphp
                    <option value="no" {{ $selectud }}> Tidak</option>
                    <option value="yes" {{ $selectud }}> Ya</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12" style="padding-bottom: 0px;">
                <div class="form-group" align="left">
                  <label class="form-control-label">Stok Barang :</label>
                  <input type="text" value="{{ $detailposts->banyaknya }}" onkeyup="angka(this);" id="stokedit" class="form-control">
                </div>
              </div>

              <div class="col-md-12" style="padding-bottom: 0px;">
                <div class="form-group" align="left">
                  <label class="form-control-label">Deskirpsi Post :</label>
                  <textarea rows="10" class="form-control" id="descedit">{{ $detailposts->desc }}</textarea>
                </div>
              </div>

              <div class="col-md-12" style="padding-bottom: 0px;">
                <div class="form-group" align="left">
                  <label class="form-control-label">Harga Actual(Rp):</label>
                  <input type="text" onkeyup="angka(this);" id="harga_actedit" value="{{ $detailposts->harga_act }}" class="form-control">
                </div>
              </div>
            @elseif($detailposts->type == 'Deals')
            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Berlaku Dari:</label>
                <input type="date" value="{{ $detailposts->dari }}" id="dariedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Berlaku Sampai:</label>
                <input type="date" value="{{ $detailposts->sampai }}" id="sampaiedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Maksimal Daftar:</label>
                <input type="text" value="{{ $detailposts->banyaknya }}" onkeyup="angka(this);" id="maxedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Deskirpsi Post :</label>
                <textarea rows="10" class="form-control" id="descedit">{{ $detailposts->desc }}</textarea>
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Harga Actual(Rp):</label>
                <input type="text" onkeyup="angka(this);" id="harga_actedit" value="{{ $detailposts->harga_act }}" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Harga Coret(Rp):</label>
                <input type="text" onkeyup="angka(this);" value="{{ $detailposts->harga_crt }}" id="harga_crtedit" class="form-control">
              </div>
            </div>

            @else

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Berlaku Dari:</label>
                <input type="date" value="{{ $detailposts->dari }}" id="dariedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Berlaku Sampai:</label>
                <input type="date" value="{{ $detailposts->sampai }}" id="sampaedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Maksimal Daftar:</label>
                <input type="text" value="{{ $detailposts->banyaknya }}" onkeyup="angka(this);" id="maxedit" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Deskirpsi Post :</label>
                <textarea rows="10" class="form-control" id="descedit">{{ $detailposts->desc }}</textarea>
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Batas Penukaran Reward (Dari):</label>
                <input type="date" id="darirewardedit" value="{{$detailposts->dari_reward }}" class="form-control">
              </div>
            </div>

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="left">
                <label class="form-control-label">Batas Penukaran Reward (Sampai):</label>
                <input type="date" id="sampairewardedit" value="{{$detailposts->sampai_reward }}" class="form-control">
              </div>
            </div>

            @endif

            <div class="col-md-12" style="padding-bottom: 0px;">
              <div class="form-group" align="center">
                <button type="button" id="updatepost" class="btn btn-primary">Update</button>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
      @include('layout.footer')

      <script type="text/javascript">
        
        $("#uploadpost").on("change", function() {

          var id = $('#idx').val();
          var formData = new FormData();
          formData.append('file', $('#uploadpost')[0].files[0]);
          formData.append('id', id);

          $.ajax({
              url: "{{ route('gantigambar') }}",
              method:"POST",
              data: formData,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              dataType:'JSON',
              contentType: false,
              cache: false,
              processData: false,

              success:function(data) {

                  if(data.status == '1'){

                      var content_data = '<img width="80%" src="/assets/img_post/'+data.name+'">';

                      $('#uploadganti').html(content_data);

                      swal({
                          title: "Berhasil!",
                          text: "Gambar Telah Diganti!",
                          icon: "success",
                          buttons: false,
                          timer: 2000,
                      });

                  } else {

                      swal({
                          title: "Gagal!",
                          text: "Pastikan File yang Anda Upload Benar!",
                          icon: "error",
                          buttons: false,
                          timer: 2000,
                      });
                  }
              }
          });

        });

        $("#updatepost").on("click", function() {

          $.ajax({
            type: 'POST',
            url: "{{ route('updatepost') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#idx').val(), 
                'judul': $('#editname').val(),  
                'kategori_id': $('#kategoriedit').val(),  
                'stock': $('#stokedit').val(),  
                'deliver': $('#deliveredit').val(), 
                'po': $('#poedit').val(), 
                'desc': $('#descedit').val(),  
                'harga_act': $('#harga_actedit').val(),  
                'dari': $('#dariedit').val(), 
                'sampai': $('#sampaiedit').val(), 
                'banyaknya': $('#maxedit').val(),
                'harga_crt': $('#harga_crtedit').val(),
                'dari_reward': $('#darirewardedit').val(),
                'sampai_reward': $('#sampairewardedit').val(),  
                'type': $('#typeedit').val(),
                'active': $('#active').val(),
            },
            success: function(data) {

              swal({
                  title: "Berhasil!",
                  text: "Post Sudah Diperbaharui!",
                  icon: "success",
                  buttons: false,
                  timer: 2000,
              });

              setTimeout(function(){ window.location.href='/mypost'; }, 1500);

            }

          });

        });

      </script>

</body>

</html>