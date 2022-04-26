@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="row">
        <div class="col">
         <!--  <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              @if($stock->type == "cek")

                @if($stock->jenis == "awal")
                  <h1 class="ct-title" id="content">Edit Stok Awal/Pagi</h1>
                @else
                  <h1 class="ct-title" id="content">Edit Stok Akhir/Malam</h1>
                @endif

              @elseif($stock->type == "in")

                @if($stock->jenis == "pemasukan")
                  <h1 class="ct-title" id="content">Edit Pemasukan</h1>
                @elseif($stock->jenis == "intratoko")
                  <h1 class="ct-title" id="content">Edit Masuk antar Gudang</h1>
                @else

                @endif

              @else

                @if($stock->jenis == "intratoko")
                  <h1 class="ct-title" id="content">Edit Keluar antar Gudang</h1>
                @else

                @endif

              @endif

              <input type="hidden" id="jenis" value="{{ $stock->jenis }}" name="">
              <input type="hidden" id="type" value="{{ $stock->type }}">
            </div>
            <hr>
            <div style="font-size: 12px;padding-bottom: 20px;"> Edit Stock Actual saat ini yang ada di Toko Anda, Pastikan Anda menghitung qty produk dengan Benar.</div>

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

                  @php

                    $detail = DB::table('stock_transaction_details')
                    ->where([
                        ['post_id', '=', $pos->id],
                        ['stocktransaction_id', '=', $stock->id],
                    ])
                    ->first();

                  @endphp
                  <tr>
                    <td>{{ $pos->name == NULL ? '-' : $pos->name }}</td>
                    <td width="25%">
                      <label class="custom-toggle" style="margin-bottom:0px;">
                        @if($detail)
                          <input type="checkbox" id="tombol_{{ $pos->id }}" onclick="NotReady({{ $pos->id }});" checked>
                        @else
                          <input type="checkbox" id="tombol_{{ $pos->id }}" onclick="Ready({{ $pos->id }});">
                        @endif
                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                      </label>
                      @if($detail)
                      <div style="font-size:10px;"><i id="ket_{{ $pos->id }}"> Stock ada</i></div>
                      <input type="hidden" value="{{ $pos->id }}" class="postid">
                      @else
                      <div style="font-size:10px;"><i id="ket_{{ $pos->id }}"> Kosong</i></div>
                      @endif
                      
                    </td>

                    <td width="35%">
                      @if($detail)
                      <input type="number" value="{{ $detail ? $detail->qty : '' }}" id="qty_{{ $pos->id }}" class="form-control qty" placeholder="Qty">
                      @else
                      <input type="number" id="qty_{{ $pos->id }}" disabled class="form-control" placeholder="Qty">
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
            <br>
            @endforeach
            <hr style="margin-top:0px;">
            <button class="btn btn-success btn-block" onclick="UpdateStock();">
              Update Stock
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
                    <div style="font-size:18px;" class="text-warning"><b>KONFIRMASI UPDATE STOCK?</b></div>
                    <input type="hidden" id="idready">
                </td></tr>
                <tr>
                    <td><div style="font-size:13px;">Apakah Anda yakin akan Update stock ini?</div></td>
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

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.ready') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          $('#ket_'+id).html('Stock Ada');
          $('#tombol_'+id).attr('onclick', 'NotReady('+id+')');
          $('#qty_'+id).attr("disabled", false);

        }

      });

    }

    function NotReady(id){

      $.ajax({
        type: 'POST',
        url: "{{ route('stock.notready') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
            },

        success: function(data) {

          $('#ket_'+id).html('Kosong');
          $('#tombol_'+id).attr('onclick', 'Ready('+id+')');
          $('#qty_'+id).attr("disabled", true);

        }

      });

    }

    function UpdateStock(){

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
        url: "{{ route('stock.editupdate') }}",
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
              text: "Stock Berhasil Di Update!",
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