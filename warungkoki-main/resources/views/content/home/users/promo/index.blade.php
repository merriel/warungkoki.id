@include('layout.head')
<style type="text/css">
  .nav3 {
    position: fixed;
    bottom: 0;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 90px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 60px;
    margin-left: 5%;
    width: 90%;

}

</style>
<div class="main-content">
  <!-- Header -->
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
    <div class="ct-page-title">
      <div style="font-size: 20px;" id="content"><b>Pilih Promo</b></div>
      <div style="font-size: 11px;">Anda bisa pilih promo yang berlaku disini.</div>
    <div>
  </div>
</div>
    <!-- Card stats -->
   
  <div class="row">
    <div class="col-12">

      @foreach($vouchers as $vouc)

      @php
      $akhir  = strtotime($vouc->sampai);
      $awal = strtotime($hariini);
      $diff  = $akhir - $awal;

      $hari = floor($diff / (60 * 60 * 24));
      $jam = floor($diff / (60 * 60));

      if($vouc->wilayah == "all"){

        $voucwilayah = DB::table('vouchers')
        ->where('id', '=', $vouc->id)
        ->first();

      } else {

        $voucs = explode(",", $vouc->wilayah);

        $voucwilayah = DB::table('users')
        ->whereIn('wilayah_id', $voucs)
        ->where("id", $user->id)
        ->first();

      }
      if($voucwilayah){

        if($vouc->product == "satuan"){

          if($vouc->minimal >= $total){

              $data = 6;
              $keterangan = "Minimal Pembelian Belum Terpenuhi!";

          } else {

            $voucod = explode(",", $vouc->codes);

            $adaprod = DB::table('keranjang')
            ->select("posts.id")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->where('keranjang.user_id', '=', $user->id)
            ->whereIn('posts.code_id', $voucod)
            ->first();

            if($adaprod){

                $data = 1;
                

            } else {

                $data = 4;
                $keterangan = "Promo tidak berlaku pada Produk Tersebut!";
            }

          }

        } else if($vouc->product == "except"){


            if($vouc->minimal >= $total){

                $data = 6;
                $keterangan = "Minimal Pembelian Belum Terpenuhi!";

            } else {


                $voucod = explode(",", $vouc->codes);

                $adaprod = DB::table('keranjang')
                ->select("posts.id")
                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                ->where('keranjang.user_id', '=', $user->id)
                ->whereIn('posts.code_id', $voucod)
                ->first();

                if($adaprod){

                    $data = 4;
                    $keterangan = "Promo tidak berlaku pada Produk Tersebut!";

                } else {


                    $data = 1;
                    
                }

            }


        } else {


            $data = 1;

        } 

        

    } else {

        $data = 3;
        $keterangan = "Promo tidak berlaku pada Wilayah ini!";

    }

    @endphp

    @php
    $harga = $vouc->amount == NULL ? $total * ($vouc->percent/100) : $vouc->amount;
    @endphp

    @if($data == 1)

    @if($adavoucher)
      @if($vouc->id == $adavoucher->id)
      <div class="card shadow-ss" id="cont_{{ $vouc->id }}" onclick="HapusMemilih({{ $vouc->id }},{{ $harga }})" style="border-radius:0.8rem;background-color: #b8ebd6;border-color:#15be77;">
      @else
      <div class="card shadow-ss" id="cont_{{ $vouc->id }}" onclick="Memilih({{ $vouc->id }},{{ $harga }})" style="border-radius:0.8rem;">
      @endif
    @else
      <div class="card shadow-ss" id="cont_{{ $vouc->id }}" onclick="Memilih({{ $vouc->id }},{{ $harga }})" style="border-radius:0.8rem;">
    @endif

        <div class="card-body">
          <div class="row">
            <div class="col-10" style="padding-right:0px;padding-bottom: 0px;">
               <div style="font-size:10px;bord"><b style="font-size:14px;">Potongan {{ rupiah($harga) }}</b> &nbsp;&nbsp;({{ $vouc->name }})</div>

               @if($hari == 0)
                <div style="font-size:10px;"><i class="fa fa-clock"></i>&nbsp;&nbsp;Berakhir {{ $jam }} Jam Lagi</div>
              @else
                <div style="font-size:10px;"><i class="fa fa-clock"></i>&nbsp;&nbsp;Berakhir {{ $hari }} Hari Lagi</div>

              @endif
            </div>

            @if($adavoucher)
              @if($vouc->id == $adavoucher->id)
                <div class="col-2" style="padding-left:0px; padding-top: 8px;padding-bottom: 0px;display:block;" align="center" id="checklist_{{ $vouc->id }}">
              @else
                <div class="col-2" style="display: none;" align="center" id="checklist_{{ $vouc->id }}">
              @endif
            @else
            <div class="col-2" style="display: none;" align="center" id="checklist_{{ $vouc->id }}">
            @endif

              <i class="fa fa-check" style="font-size:24px;color: #15be77;"></i>
            </div>
          </div>
        </div>
      </div>
      <br>
    @else
    <div class="card shadow-ss" style="border-radius:0.8rem;background-color: #f0f3f9; border-color: #c0c2c7;">
        <div class="card-body">
          <div class="row">
            <div class="col-10" style="padding-right:0px;padding-bottom: 0px;">
               <div style="font-size:10px;padding-bottom: 6px; color: #b0b3b9;"><b style="font-size:14px;">Potongan {{ rupiah($harga) }}</b> &nbsp;&nbsp;({{ $vouc->name }})</div>

               @if($hari == 0)
                <div style="font-size:10px;color: #b0b3b9;"><i class="fa fa-clock"></i>&nbsp;&nbsp;Berakhir {{ $jam }} Jam Lagi</div>
              @else
                <div style="font-size:10px;color: #b0b3b9;"><i class="fa fa-clock"></i>&nbsp;&nbsp;Berakhir {{ $hari }} Hari Lagi</div>

              @endif
              <hr style="margin-top:0.5rem; margin-bottom: 0.5rem;">
              <div style="font-size:10px;" class="text-danger"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;{{ $keterangan }}</div>
            </div>
            <div class="col-2" style="display: none;" align="center" id="checklist_{{ $vouc->id }}">
              <i class="fa fa-check" style="font-size:24px;color: #15be77;"></i>
            </div>
          </div>
        </div>
      </div>
      <br>
    @endif
    @endforeach
    <br><br><br>
    </div>    
  </div>

@include('layout.footer')

@if($adavoucher)
    <div id="pakai" style="display: block;">
@else
<div id="pakai" style="display: none;">
@endif

<nav class="nav3">

  <a href="#" class="nav__link menusxx">
    <div class="text-white" style="font-size: 10px;">Kamu Bisa Hemat :</div> 
      <div class="text-white" style="font-size: 16px;"> 

        @if($adavoucher)
          @if($adavoucher->amount == NULL)
            <b id="totalsemua">{{ rupiah($total * ($adavoucher->percent/100)) }}</b>
            <input type="hidden" id="voucherid" value="{{ $adavoucher->id }}">
          @else
            <b id="totalsemua">{{ rupiah($adavoucher->amount) }}</b>
            <input type="hidden" id="voucherid" value="{{ $adavoucher->id }}">
          @endif
        @else
          <b id="totalsemua">0</b>
          <input type="hidden" id="voucherid" value="0">
        @endif

      </div>
  </a>
  <a href="#" class="nav__link menusxx"> 
    <button id="tombolnya" style="font-size:12px;border-radius: 0.8rem;" onclick="PakaiVoucher()" class="btn btn-success pop" type="button">Pakai Voucher</button>
  </a>
</nav>
</div>
<script type="text/javascript">


function PakaiVoucher(){

  $.ajax({
    type: 'POST',
    url: "{{ route('keranjang.pakaivoucher') }}",
    data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#voucherid').val(),
    },
    success: function(data) {


      swal("Voucher Berhasil diambil", {
         icon: "success",
         buttons: false,
         timer: 2000,
      });

      $('.loading').attr('style','display: block');

      setTimeout(function(){ window.location.href='/keranjang'; }, 2000);

    }

  });

}

function Memilih(id,amount){

  $('.card').attr("style","border-radius:0.8rem;");
  $('.col-2').attr("style","display:none;");

  $('#cont_'+id).attr("style","border-radius:0.8rem;background-color: #b8ebd6;border-color:#15be77;");
  $('#pakai').attr("style","display:block;");

  // == GANTI BUTTON ===
  $('#cont_'+id).attr("onclick","HapusMemilih("+id+","+amount+")");

  $('#voucherid').val(id);

  $('#checklist_'+id).attr("style","padding-left:0px; padding-top: 8px;padding-bottom: 0px;display:block;");

  var reverse = amount.toString().split('').reverse().join(''),
    ribuan  = reverse.match(/\d{1,3}/g);
    ribuan  = ribuan.join('.').split('').reverse().join('');

  // Cetak hasil  
  $("#totalsemua").html('Rp '+ribuan);

  $("#tombolnya").attr('class','btn btn-success');
  $("#tombolnya").html('Pakai Voucher');
  $("#tombolnya").attr('onclick','PakaiVoucher()');

}

function HapusMemilih(id,amount){

  $('#checklist_'+id).attr("style","display:none;");

  $('#cont_'+id).attr("style","border-radius:0.8rem;");
  $('#cont_'+id).attr("onclick","Memilih("+id+","+amount+")");

  $("#totalsemua").html('Rp 0');

  $('#voucherid').val(id);

  $("#tombolnya").attr('class','btn btn-danger');
  $("#tombolnya").html('Remove Voucher');
  $("#tombolnya").attr('onclick','RemoveVoucher()');

}


function RemoveVoucher(){

  $.ajax({
    type: 'POST',
    url: "{{ route('keranjang.removevoucher') }}",
    data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#voucherid').val(),
    },
    success: function(data) {

      swal("Voucher Di Remove", {
         icon: "success",
         buttons: false,
         timer: 2000,
      });

      $('.loading').attr('style','display: block');

      setTimeout(function(){ window.location.href='/keranjang'; }, 2000);

    }

  });

}

</script>
</body>

</html>