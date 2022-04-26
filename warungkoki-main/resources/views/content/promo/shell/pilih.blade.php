@include('layout.head2')
<style type="text/css">
  .nav2 {
    position: fixed;
    bottom: 0;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 20px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 60px;
    margin-left: 5%;
    width: 90%;

}

.nav__link2 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #444444;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}
</style>
<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 17rem;">
  <div class="container-fluid">
    <div class="header-body">

    </div>
  </div>
</div>
<br>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
      <section class="container">
        <div class="ct-page-title" style="margin-bottom:0.5rem;">
          <h2 class="ct-title" style="margin-bottom:0px;font-size: 21px;font-weight: bold;" id="content">PILIH PRODUK </h2>
          <div style="font-size:11px;">Pilih Produk yang akan di Beli.</div>
        </div>
        <hr>
        <div class="row">
                
            @php $no=0; @endphp
              @foreach($products as $produk)
              @php
                $no++;

                if($no%2==0){
                  $paddings = 'padding-left: 7.5px;padding-right:0px;';
                } else {
                  $paddings = 'padding-right: 7.5px;padding-left:0px;';
                }

                $post = DB::table('posts')
                ->select("posts.*","product.name as prod_name","wilayah.name as wilayah_name","regencies.name as regency_name","product.img as prod_img","wilayah.uuid")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where([
                    ["wilayah.id", $wilayahid],
                    ["posts.active", "Y"],
                    ['wilayah.active', '=', "Y"],
                    ['posts.deleted_at', '=', null],
                    ['posts.product_id', '=', $produk->product_id],
                ])
                ->first();

              @endphp

            <div class="col-6" style="{{ $paddings }}">
                <div class="card shadow-sm prod" id="cont_{{ $post->id }}" onclick="Memilih({{ $post->id }})">      
                  <div class="gambar"> 
                    <img class="card-img-top" width="50px" src="/assets/img_post/{{ $post->prod_img }}" alt="Card image cap"> 
                  </div>
                  <div class="card-body" id style="padding-right: 1rem;padding-left: 1rem;">
                    <h5> <b>{{ $post->prod_name }}</b></h5>
                    <div style="font-size: 9px;padding-top: 7px; color: black;">
                      Anda Mendapatkan Potongan Voucher sebesar <b>{{ rupiah($voucher->amount) }}</b>
                    </div>
                    <hr>
                    <h6 style="text-decoration:line-through;">{{ rupiah($post->harga_act) }}</h6>
                    <h3 style="color: #fb6340;"><b>{{ rupiah($post->harga_act - $voucher->amount) }}</b></h3>
                  </div>
                </div>
              </div> 
              @endforeach 
            
        </div> 
        <br>
    </div>
  </div>
</div>  
<div id="navnav" style="display:none;">
    <nav class="nav2">
      <a href="#" class="nav__link menusxx">
        <div class="text-white" style="font-size: 10px;">Grand Total :</div> 
          <div class="text-white" style="font-size: 16px;"> 
            <b id="totalsemua"></b>
            <input type="hidden" id="postid">
          </div>
      </a>
      <a href="/users/bayar" class="nav__link menusxx">
            <button class="btn btn-sm btn-secondary pop" type="button">Checkout</button>
      </a>
    </nav>
</div>
@include('layout.footer2')

<script type="text/javascript">
    

    function Memilih(id){

        $('.prod').attr("class","card shadow-sm prod bg-white");
        $('#navnav').attr("style","display:block;");
        $('#cont_'+id).attr("class","card shadow-sm prod bg-success");
        $('#postid').val(id);

        $.ajax({
           type: 'POST',
           url: "{{ route('promo.shell.pilihproduk') }}",
           data: {
                '_token': $('input[name=_token]').val(),
                'id': id
            },
           success: function(data) {

                $('#totalsemua').html(data);

           }

       });

    }

</script>
        
</body>

</html>