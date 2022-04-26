@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <div class="row">
        <div class="col">
         <!--  <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Input Retur Barang</h1>
              <!-- <span class="badge badge-pill badge-default">Update Stok Terakhir : Doni Prasetyo (20 Oktober 2020 17:22)</span> -->
            </div>
            <input type="hidden" value="out" id="type">
            <input type="hidden" value="retur" id="jenis">
            <hr>
            <div style="font-size: 12px;padding-bottom: 20px;"> Isilah Retur Barang sesuai dengan barang yang datang ke toko Anda, pastikan Anda melakukannya dengan benar.</div>

            @foreach($products as $prod)
            <div class="card shadow" style="border-radius: 1.5rem;">
              <div class="card-body">
                <div style="font-size: 15px;"><b>{{ $prod->name }}</b></div>
                <hr>
                @php
                  $posts = DB::table('posts')
                  ->where([
                      ['user_id', '=', $prod->user_id],
                      ['product_id', '=', $prod->id],
                      ['jenis', '=', NULL],
                      ['type', '=', "Products"],
                  ])
                  ->get();

                @endphp

                <table id="customers">
                  @foreach($posts as $pos)
                  <tr>
                    <td>{{ $pos->name == NULL ? '-' : $pos->name }}</td>
                    <td width="25%">
                      <label class="custom-toggle" style="margin-bottom:0px;">
                        <input type="checkbox" id="tombol_{{ $pos->id }}" onclick="Ready({{ $pos->id }});">
                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                      </label>
                      <div style="font-size:10px;"><i id="ket_{{ $pos->id }}"> Kosong</i></div>
                      <input type="hidden" id="input_{{ $pos->id }}" class="" value="{{ $pos->id }}">
                    </td>

                    <td width="35%">
                      <input type="number" id="qty_{{ $pos->id }}" disabled class="form-control" placeholder="Qty">
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
            <br>
            @endforeach
            <hr style="margin-top:0px;">
            <button class="btn btn-success btn-block" onclick="Konfirmasi();">
              Konfirmasi Retur Barang
            </button>
        </div> 
      </div> 
      <br><br>
    </div>
  </div>
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
<div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
        
        <div class="modal-body" align="center">
            <table border="0" align="center" width="100%">
                <tr><td>
                    <div style="font-size:18px;" class="text-warning"><b>KONFIRMASI RETUR?</b></div>
                    <input type="hidden" id="idready">
                </td></tr>
                <tr>
                    <td><div style="font-size:13px;">Apakah Anda yakin akan menyimpan Retur ini?</div></td>
                </tr>
            </table>
            <hr>
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-block btn-danger ml-auto"  data-dismiss="modal">Batal</button> 
              </div>
              <div class="col-8">
                <button type="button" onclick="Yakin();" class="btn btn-block btn-success">Yakin</button> 
              </div>
            </div> 
        </div>
        
    </div>
</div>
</div>
  @include('layout.footer')

  <script type="text/javascript">
    
    function Ready(id){


          $('#ket_'+id).html('Stock Ada');
          $('#tombol_'+id).attr('onclick', 'NotReady('+id+')');
          $('#qty_'+id).attr("disabled", false);
          $('#input_'+id).attr("class", "postid");
          $('#qty_'+id).attr("class", "form-control qty");

    }

    function NotReady(id){


          $('#ket_'+id).html('Kosong');
          $('#tombol_'+id).attr('onclick', 'Ready('+id+')');
          $('#qty_'+id).attr("disabled", true);
          $('#input_'+id).attr("class", "#");
          $('#qty_'+id).attr("class", "form-control");

    }

    function Konfirmasi(){

      $('#konfirmasi').modal('show');
    }

    function Yakin(){

      $('#konfirmasi').modal('hide');

      var postid = [];
      var qty = [];

      $('.postid').each(function(){
          postid.push($(this).val());
      });

      $('.qty').each(function(){
          qty.push($(this).val());
      });

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.update') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'jenis': $('#jenis').val(),
            'type': $('#type').val(),
            'postid': postid,
            'qty': qty,
            },
        success: function(data) {

          swal({
              title: "Berhasil",
              text: "Pemasukan Berhasil Tersimpan!",
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