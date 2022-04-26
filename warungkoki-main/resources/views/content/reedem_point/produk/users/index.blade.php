@include('layout.head')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style type="text/css">
  .carousel-inner .carousel-item-right.active,
  .carousel-inner .carousel-item-next {
    transform: translateX(33.33%);
  }

  .carousel-inner .carousel-item-left.active, 
  .carousel-inner .carousel-item-prev {
    transform: translateX(-33.33%)
  }
    
  .carousel-inner .carousel-item-right,
  .carousel-inner .carousel-item-left{ 
    transform: translateX(0);
  }

  .slider .slick-slide {
      
  }

  .slider .slick-slide img {
      width: 100%;
      border-radius: 1rem;
  }

  /* make button larger and change their positions */
  .slick-prev, .slick-next {
      width: 50px;
      height: 50px;
      z-index: 1;
  }
  .slick-prev {
      left: 5px;
  }
  .slick-next {
      right: 5px;
  }
  .slick-prev:before, 
  .slick-next:before {
      font-size: 40px;
      text-shadow: 0 0 10px rgba(0,0,0,0.5);
  }
  
  /* move dotted nav position */
  .slick-dots {
      bottom: 15px;
  }
  /* enlarge dots and change their colors */
  .slick-dots li button:before {
      font-size: 12px;
      color: #fff;
      text-shadow: 0 0 10px rgba(0,0,0,0.5);
      opacity: 1;
  }
  .slick-dots li.slick-active button:before {
      color: #dedede;
  }

  /* hide dots and arrow buttons when slider is not hovered */
  .slider:not(:hover) .slick-arrow,
  .slider:not(:hover) .slick-dots {
      opacity: 0;
  }
  /* transition effects for opacity */
  .slick-arrow,
  .slick-dots {
      transition: opacity 0.5s ease-out;
  }

  .bottom-left {

    position: absolute;
    bottom: 5px;
    left: 30px;
    font-size: 16px;
    font-weight: bold;
    text-align: left;
    color: white;
  }

  .nav2 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 75px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;
  }

  .nav3 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 125px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav31 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 125px;
    border-radius: 1rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav4 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 175px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav41 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 175px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav5 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 225px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav51 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 225px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav6 {
    position: fixed;
    bottom: 0;
    left: 15px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 275px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 40px;
    border-color: whitesmoke;

  }

  .nav61 {
    position: fixed;
    bottom: 0;
    left: 63px;
    background-color: #feac3b;
    display: flex;
    overflow-x: auto;

    margin-bottom: 275px;
    border-radius: 3rem;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
    height: 40px;
    width: 210px;
    border-color: whitesmoke;

  }

  .nav__link{

    padding-left: 10px;
    padding-right: 10px;
    min-width: 0px;
    color: black;

  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-2 pt-md-8" style="padding-bottom: 22rem;">
      <div class="container-fluid">
        <div class="header-body">
          <input type="hidden" id="ktps" value="{{ Auth::user()->token }}">
          <!-- Card stats -->
          <!-- <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Kembali</button></a> -->
          
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid" style="margin-top: -14rem;">
      <div class="row">=
        <!-- <div class="col-6" style="padding-bottom: 20px;padding-left: 0px;">
            <div style="font-size: 12px" align="right" class="text-black">Butiran Padi Anda,</div>
            <div style="font-size: 28px" align="right" class="text-warning"><b>{{ $saldopoin ? $saldopoin->sisa : 0 }}</b><b style="font-size:12px;"> Poin</b></div>
        </div> -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card-body bg-success shadow-ss" style="border-radius: 1rem;padding: 0.5rem 1rem;">    
            <table width="100%">
              <tr>
                <td align="left" width="55%">
                  <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                            <img width="100%" src="/assets/content/img/icons/padi.png">
                          </td>
                          
                          <td>
                            <div style="font-size:10px;">Butiran Padi :</div>
                            <b style="font-size: 13px;">{{ $saldopoin ? $saldopoin->sisa : '0' }}</b>
                          </td>

                        </tr>
                      </table>
                      
                    </div>
                </td>
                <td>&nbsp;</td>
                <td align="left">
                    <div style="color: white;">
                      <table width="100%">
                        <tr>
                          <td width="25%">
                           
                          </td>
                          
                          <td>
                            <div style="font-size:10px;">Beranda:</div>
                            <b style="font-size: 13px;"><a href="/home">Kembali</a></b>
                          </td>
                        </tr>
                      </table>
                      
                    </div>
                </td>
              </tr>
            </table> 
          </div>
        </div>
      </div>

      <!-- ====== TOKO PILIHAN ===== -->

      <div class="row">
        <div class="col">
          <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
            @if(!$toko)

              <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">
                <table width="100%">
                  <tr>
                    <td>
                      <div class="text-warning" style="font-size: 14px;"><b>BELUM PILIH TOKO</b></div>
                      <div style="font-size: 11px; padding-bottom: 8px;">Anda Belum Memilih Toko, Pilih toko untuk melanjutkan transaksi dan rasakan keuntungannya</div>
                      <a href="/search" class="menusxx"><button class="btn btn-sm btn-success">
                        <i class="fa fa-search"></i> Pilih Toko
                      </button></a>
                    </td>
                  </tr>
                </table>
              </div> 

            @else
            <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;background-color: #EAFCB8;">
              <div class="row">
                  
                  <div class="col-12">
                    <div style="font-size: 11px;">
                      Toko Pilihan Anda : <a href="/search?request_from=reedem_point_product" class="menusxx" style="color:black;"><i class="ni ni-bold-down"></i> {{ $toko->name }}</a>
                    </div>
                  </div>
              </div> 
            </div>

            @endif

          </div>
        </div> 
        
       
      </div>

       <!--  ======= NAV =========== -->
      <div class="row">
        <div class="col">
            
            @php 
            $listNav = [
              [ 'id' => 'tabs-produk', 'href' => 'produk', 'active' => true, 'name' => 'Produk', 'order' => 0],
              [ 'id' => 'tabs-keranjang', 'href' => 'keranjang', 'active' => false, 'name' => 'Keranjang', 'order' => 1],
              [ 'id' => 'tabs-history', 'href' => 'history', 'active' => false, 'name' => 'History', 'order' => 2],
            ];
            @endphp
            @include('content.reedem_point.layouts.navs', ['listNav' => $listNav])

        </div> 
        
       
      </div>

    
     
    

    <hr>
    <div class="row">
      
    </div>

    <!-- ====== PRODUK ====== -->
    @include('content.reedem_point.produk.users.partials.produk')

    <div id="tabs-keranjang" role="tabpanel" aria-labelledby="tabs-history"></div>   

    <div id="tabs-history" role="tabpanel" aria-labelledby="tabs-history"></div>                   
          
<!-- ======= SELESAI PILIH DAERAH ======= -->
@include('content.home.users.modal2')
@include('layout.footer')
<!-- Slick JS -->    
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<nav class="nav2" id="first" onclick="Menuss()">
  <div class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/smile.png">
  </div>
</nav>

<nav class="nav2 xx" onclick="Menuss2()" style="display:none;">
  <div href="#" align-items="center" class="nav__link menusxx">
    <img width="70%" src="/assets/content/img/icons/x.png">
  </div>
</nav>

<nav class="nav3 xx" style="display:none;">
  <a href="#" onclick="onShare()" class="nav__link">
    <img width="90%" src="/assets/content/img/icons/share.png">
  </a>
</nav>

<nav class="nav31 xx" style="display:none;">
  <a href="#" onclick="onShare()" class="nav__link" style="padding-left:20px;">
    <div align="left">Bagikan Link Warungkoki</div>
  </a>
</nav>

<nav class="nav4 xx" style="display:none;">
  <a href="https://wa.me/6281808800550" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/wa.png">
  </a>
</nav>

<nav class="nav41 xx" style="display:none;">
  <a href="https://wa.me/6281808800550" class="nav__link menusxx" style="padding-left:20px;">
    Customer Service Warungkoki
  </a>
</nav>

<nav class="nav5 xx" style="display:none;">
  <a href="https://www.instagram.com/warungkoki.id" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/ig.png">
  </a>
</nav>

<nav class="nav51 xx" style="display:none;">
  <a href="https://www.instagram.com/warungkoki.id" class="nav__link menusxx" style="padding-left:20px;">
    Instagram Warungkoki
  </a>
</nav>

<nav class="nav6 xx" style="display:none;">
  <a href="https://www.facebook.com/warungkoki.id" class="nav__link menusxx">
    <img width="90%" src="/assets/content/img/icons/fb.png">
  </a>
</nav>

<nav class="nav61 xx" style="display:none;">
  <a href="https://www.facebook.com/warungkoki.id" class="nav__link menusxx" style="padding-left:20px;">
    Facebook Warungkoki
  </a>
</nav>
@include('script.home')

<script type="text/javascript">
  $(document).ready(function(){

    $('.countdown_div').each(function(i, obj) {
      let endTime = $('#time_countdown'+i).val()
      let target = "div_countdown_"+i;

      console.log(target)
      createCountdown(endTime,target);
    });

    function createCountdown(endTime, target) {
      var countDownDate = new Date(endTime).getTime();
      console.log('end_time', endTime)
      console.log('countDownDate', countDownDate)
      // Update the count down every 1 second
      var x = setInterval(function() {

        

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById(target).innerHTML = days + " Hari " + hours + " Jam "
        + minutes + " Menit " + seconds + " Detik ";

        // If the count down is finished, write some text
        if (distance < 0) {
          clearInterval(x);
          document.getElementById(target).innerHTML = "EXPIRED";
        }
      }, 1000);

    }

    $('.addKeranjang').on('click', function() {

      let id = $(this).attr('data-id');
      let id_bracket_prod = $(this).attr('data-id_bracket_product');

      $('.loading').attr('style','display: block');

      $.ajax({
        type: 'POST',
        url: "{{ route('reedem_point.keranjang.add') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'post_id': id,
            'bracket_product_id' : id_bracket_prod,
        },
        success: function(data) {

          $('#keranjangreedemcount').html(data);

          swal({
              title: "Berhasil",
              text: "Produk Masuk ke Dalam Keranjang Reedem!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          $('.loading').attr('style','display: none');

        }

      });

    });

  });

  async function onShare() {
    const title = document.title;
    const url = document.querySelector("link[rel=canonical]")
      ? document.querySelector("link[rel=canonical]").href
      : document.location.href;
    const text = "Promo Menarik Lainnya di Warungkoki.id yuk!";
    try {
        await navigator
        .share({
          title,
          url,
          text
        })
        
          /*
            Show a message if the user shares something
          */
          alert('Thanks for Sharing!');
      } catch (err) {
         /*
            This error will appear if the user cancels the action of sharing.
          */
         // alert('Couldnt share');
      }
  }

  function Menuss(){

    $('.xx').attr("style","display:flex;");
    $('#first').attr("style","display:none;");

  }

  function Menuss2(){

    $('.xx').attr("style","display:none;");
    $('#first').attr("style","display:flex;");
    
  }

  $(document).ready(function(){
      $('.slider').slick({
          autoplay: true,
          autoplaySpeed: 3000,
          dots: true
      });
  });
 
  $( document ).ready(function() {

    $.ajax({
      type: 'GET',
      url: "{{ route('user.guides') }}",
      success: function (data) {

        if(data != '1'){

           $('#guide').modal({backdrop: 'static', keyboard: false}); 

        } else {

          var ktp = $('#ktps').val();

          if(ktp == ''){

            $('#ktp').modal({backdrop: 'static', keyboard: false}); 
          }

        }
      }
    });

    // $.ajax({
    //   type: 'GET',
    //   url: "{{ route('alamat.cek') }}",
    //   success: function (data) {

    //     if(data.length == 0){

    //       swal({
    //           title: "Perhatian!",
    //           text: "Harap Tentukan Alamat Anda terlebih Dahulu!",
    //           icon: "warning",
    //           buttons: false,
    //           timer: 2000,
    //       });

    //        setTimeout(function(){ window.location.href='/alamatuser'; }, 2000);

    //     } 
    //   }
    // });

    

  });

  

  function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
   
      return false;
      return true;
  }

  function Next(id){
 
  $('.content').attr("style","display: none;");
  $('.tombol').attr("style","display: none;");

  $('#tombol'+id).attr("style","display: block;");
  $('#content'+id).attr("style","display: block;");

  }

  function Back(id){

    $('.content').attr("style","display: none;");
    $('.tombol').attr("style","display: none;");

    $('#tombol'+id).attr("style","display: block;");
    $('#content'+id).attr("style","display: block;");

  }

  function Finish(){

    $.ajax({
      type: 'GET',
      url: "{{ route('selesai.guide') }}",
      success: function(data) {

        $('#guide').modal('hide');

        $('#ktp').modal({backdrop: 'static', keyboard: false}); 

      }
    });

  }

  function SimpanPengaturan(){

    var pin = $('#pin').val();
    var pin2 = $('#pin2').val();
    var ktp = $('#ktpx').val();
    var nohp = $('#nohp').val();

    if(pin == pin2){

      if(pin.length == 6){
          $.ajax({
            type: 'POST',
            url: "{{ route('selesai.pengaturan') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'ktp': ktp,
                'pin': $('#pin').val(),
                'nohp': $('#nohp').val(),
            },
            success: function(data) {

              swal("Terimakasih, Selamat Datang di Warungkoki.id", {
                 icon: "success",
                 buttons: false,
                 timer: 2000,
              });

              $('#ktp').modal('hide');

            }
          });

      } else {

        swal("PIN Harus 6 Digit!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

      }

    } else {

      swal("PIN dan PIN Konfirmasi diharuskan SAMA!", {
           icon: "error",
           buttons: false,
           timer: 2000,
        });

    }

  }

  var input = document.getElementById("cari");

  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
     event.preventDefault();
     document.getElementById("myBtn").click();
    }
  });

  function Cari(){

    var cari = $('#cari').val();

    if(cari == ''){

      swal("Isi Keyword yang diinginkan!", {
         icon: "error",
         buttons: false,
         timer: 2000,
      });

    } else {

      $('.loading').attr('style','display: block');

      setTimeout(function(){ window.location.href='/cari?value='+cari+''; }, 1000);

    }

    
  }

  function IsiSaldo(){

    $('#isi').modal('show');

  }

  function PembayaranInfo(){

    $('#pembayaran').modal('show');

  }

  function PelayananInfo(){

    $('#pelayanan').modal('show');

  }

  function Garansi(){

    $('#garansi').modal('show');

  }

  function createTimerCountDown(time, target_id) {
     
  }

</script>
</body>

</html>
