<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../carousel-12/fonts/icomoon/style.css">

<link rel="stylesheet" href="../carousel-12/css/owl.carousel.min.css">

    

<div class="owl-carousel owl-2">
    @php
    $bracket = $bracket_reedem[0];
    $databracket = $bracket['bracket'];
    $datapost = $databracket['posts'];
    foreach($datapost as $post){ 

        $product = $post['product'];
        $bracket_product = $post['bracket_product'];

        $posting = $post['post'];

        $produk_name = $product['name'];
        
        $post_name = $posting['name'];
        $harga_act = $posting['harga_act'];
        $prod_img = $posting['img'];
        $id = $posting['id'];
        $id_bracket_product = $bracket_product['id'];
        
    @endphp 
    <div class="media-29101" >
        <a href="#"><img src="/assets/img_post/{{ $prod_img }}" alt="Image" class="img-fluid" style="border-radius: 5px 5px;"></a>
        <h7 style="min-height:63px;display: inline-block;"><a href="#">{{ $produk_name." ".$post_name }}</a>
        - {{ butir_padi($harga_act) }} Pts
        </h7>
        <!-- <p>Stock :</p> -->
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="height:15px;width: {{  $bracket_product['stock'] / $bracket_product['stock_first'] * 100 }}%;" aria-valuenow="{{  $bracket_product['stock'] }}" aria-valuemin="0" aria-valuemax="100">{{  $bracket_product['stock'] .' / '.$bracket_product['stock_first'] }}</div>
        </div>

        <button class="btn btn-sm btn-block btn-kuning" >
        Check
        </button>
    </div>
    @php } @endphp
</div>

<!-- <script src="../carousel-12/js/jquery-3.3.1.min.js"></script> -->
<!-- <script src="../carousel-12/js/main.js"></script> -->