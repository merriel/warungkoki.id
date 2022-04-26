<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <meta name="google-site-verification" content="QQlFHuHFdZ-Lo_AjAaYiJCElYinurhfwQiBVsEG5Xjc" />
  <title>Warungkoki.id</title>
  <!-- Favicon -->
  <link href="/assets/icon/72x72.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icons -->
  <link href="/assets/content/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="/assets/content/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="/assets/content/css/loading.css">
  <!-- CSS Files -->
  <link href="/assets/content/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

  <link href="{{ asset ('assets/content/css/nav-footer.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

  <link rel="manifest" href="/manifest.json">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <!-- ios support -->
  <link rel="apple-touch-icon" href="/assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
<div class="loading" style="display: none;">Loading&#8230;</div>
<style type="text/css" media="screen">

  .container-home {
    text-align: center;
    color: white;
  }

  .photos{
      border-radius: 1rem;
  }

  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 12px 8px 12px 8px;
    font-size: 12px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #feac3b;
    color: white;
  }
  @import url('https://fonts.googleapis.com/css?family=Oswald');
  * {
      margin: 0;
      padding: 0;
      border: 0;
      box-sizing: border-box
  }

  .fl-left {
      float: left
  }

  .fl-right {
      float: right
  }

  h1 {
      text-transform: uppercase;
      font-weight: 900;
      border-left: 10px solid #fec500;
      padding-left: 10px;
      margin-bottom: 30px
  }

  .row {
      overflow: hidden
  }

  .cards {
      display: table-row;
      width: 20%;
      background-image: url('/assets/content/img/theme/voucher.png');
      background-size:cover;
      background-color: #D0F2E3;
      color: #989898;
      margin-bottom: 10px;
      text-transform: uppercase;
      border-radius: 4px;
      position: relative;
  }

  .cards+.cards {
      margin-left: 2%
  }

  .date {
      display: table-cell;
      width: 40%;
      position: relative;
      text-align: center;
      border-right: 2px dashed #E5E5E5
  }
  small{
      color: white;
  }

  .date:before,
  .date:after {
      content: "";
      display: block;
      width: 30px;
      height: 30px;
      background-color: #E5E5E5;
      position: absolute;
      top: -15px;
      right: -15px;
      
      border-radius: 50%
  }

  .date:after {
      top: auto;
      bottom: -15px
  }

  .date time {
      display: block;
      position: absolute;
      top: 50%;
      left: 50%;
      -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%)
  }

  .date time span {
      display: block
  }

  .date time span:first-child {
      color: #2b2b2b;
      font-weight: 600;
      font-size: 185%
  }

  .date time span:last-child {
      text-transform: uppercase;
      font-weight: 600;
      margin-top: -10px
  }

  .cards-cont {
      display: table-cell;
      width: 75%;
      font-size: 80%;
      padding: 25px 10px 20px 30px
  }

  .cards-cont h3 {
      color: #3C3C3C;
      font-size: 120%
  }

  .cards-cont>div {
      display: table-row
  }

  .cards-cont .even-date i,
  .cards-cont .even-info i,
  .cards-cont .even-date time,
  .cards-cont .even-info p {
      display: table-cell
  }

  .cards-cont .even-date i,
  .cards-cont .even-info i {
      padding: 5% 5% 0 0
  }

  .cards-cont .even-info p {
      padding: 30px 50px 0 0
  }

  .cards-cont .even-date time span {
      display: block
  }

  .cards-cont a {
      display: block;
      text-decoration: none;
      width: 80px;
      height: 20px;
      background-color: #D8DDE0;
      color: #fff;
      text-align: center;
      line-height: 30px;
      border-radius: 2px;
      position: absolute;
      right: 10px;
      bottom: 10px
  }

  .row:last-child .card:first-child .cards-cont a {
      background-color: #037FDD
  }

  .row:last-child .card:last-child .cards-cont a {
      background-color: #F8504C
  }

  @media screen and (max-width: 860px) {
      .cards {
          display: block;
          float: none;
          width: 100%;
          margin-bottom: 10px
      }
      .cards+.cards {
          margin-left: 0
      }
      .cards-cont .even-date,
      .cards-cont .even-info {
          font-size: 75%
      }
  }

</style>
</head>
<body class="" style="background-color: #fff">
  
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-detail-promo pt-4 pt-md-8" style="padding-bottom: 8rem;">
      <div class="container-fluid">
        <div class="header-body">
          
          <table width="100%">
            <tr>
              <td width="10%">
                <a href="/home"><i style="font-size: 18px;font-weight: bold;color: black;" class="fa fa-chevron-left"></i></a>
              </td>
              <td align="right">
                
              </td>
            </tr>
            <tr>
              <td colspan="2" height="3%">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <div class="row" style="padding-right: 20px;padding-left: 20px;">
                  <article class="cards fl-left">
                    <section class="date">
                      <time datetime="23th feb">
                        <span>{{ strtoupper($vouchers->code) }}</span><span>Code</span>
                      </time>
                    </section>
                    <section class="cards-cont">
                      <small>Nama Undian</small>
                      <h3>{{ strtoupper($vouchers->name) }}</h3>
                      <small>Di Undi Tanggal :</small>
                      <h3>{{ date('d F Y', strtotime($vouchers->diundi)) }}</h3>   
                    </section>
                  </article>
                </div>
              </td>
            </tr>
          </table>

        </div>
      </div>
    </div>
    
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col-12" style="padding-top: 20px;">
            
        </div>
        <br>
        <div class="col-xl-4 order-xl-2 mb-xl-0" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;">
          <div class="card" style="border-radius: 2rem;border: 0px;">
            <div class="card-body" style="padding: 1rem; height: 100%">
              
              <!-- <div style="font-size: 13px;padding-top: 12px;">Promo :</div> -->
              <div class="row">
                <div class="col-12" style="padding-bottom: 0px;">
                  <div style="font-size: 12px;">
                    Code Voucher:
                  </div>
                  <div style="font-size: 18px;">
                    {{ $vouchers->code }}
                  </div>
                  <hr>

                  <div style="font-size: 12px;">
                    Program Undian:
                  </div>
                  <div style="font-size: 18px;">
                    {{ $vouchers->name }}
                  </div>
                  <hr>

                  <div style="font-size: 12px;">
                    Diundi Tanggal:
                  </div>
                  <div style="font-size: 18px;">
                    {{ date('d F Y', strtotime($vouchers->diundi)) }}
                  </div>
                  <hr>

                  <div style="font-size: 12px;">
                    Deskripsi Program:
                  </div>
                  <div style="font-size: 18px;">
                    {!! $vouchers->ket !!}
                  </div>
                  <hr>

                  <div style="font-size: 12px;">
                    Hadiah yang bisa Anda Dapatkan:
                  </div>
                  <table id="customers">
                    <tr>
                      <th width="5%">No</th>
                      <th>Hadiah</th>
                      <th>Total Hadiah</th>
                    </tr>
                    <tbody>
                      @php $no=0; @endphp
                      @foreach($hadiah as $had)
                      @php $no++; @endphp
                      <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $had->hadiah }}</td>
                        <td>{{ $had->qty }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <hr>
                </div>
              </div>

              <br>
              
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
<script src="/assets/content/js/plugins/jquery/dist/jquery.min.js"></script>
<script src="/assets/content/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--   Argon JS   -->
<script src="/js/app.js"></script>
<script src="/assets/content/js/argon-dashboard.min.js?v=1.1.0"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
</script>

<script src="https://www.gstatic.com/firebasejs/7.21.0/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

  

<script>

  $('.menusxx').on('click', function () {

    $('.loading').attr('style','display: block');

  });

  async function onShare() {
    const title = document.title;
    const url = document.querySelector("link[rel=canonical]")
      ? document.querySelector("link[rel=canonical]").href
      : document.location.href;
    const text = "Promo Menarik Lainnya di warungkoki.id yuk!";
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
</script>
</body>

</html>