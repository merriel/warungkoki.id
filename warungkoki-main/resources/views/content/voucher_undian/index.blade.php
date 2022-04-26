@include('layout.head')
<style type="text/css">
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
    border-right: 2px dashed #dadde6
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
    background-color: #D0F2E3;
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
    font-size: 165%
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

.containers {
  position: relative;
  text-align: center;
}
.top-left {
  position: absolute;
  top: 60px;
  left: 20px;
  font-weight: 600;
  font-size: 180%;
  color: black;
}
</style>
<div class="main-content">
<!-- Header -->
<div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 12rem;">
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
        <div class="ct-page-title">
          <h2 class="ct-title" style="margin-bottom:0px;font-size: 21px;font-weight: bold;" id="content">VOUCHER UNDIAN ANDA</h2>
          <div style="font-size:11px;">Berikut adalah Voucher Undian Anda, Voucher ini akan diundi pada periode tertentu.</div>
        </div>
        <div class="row">
          <div class="col" style="padding: 0px 0px 20px 0px;">
            <div class="card-body shadow-ss bg-success" style="border-radius: 2rem;">
              <table width="100%">
                <tr>
                  <td>
                    <div style="font-size: 11px; color:white;">
                        <i class="fa fa-money"></i>
                        Total Voucher yang Anda miliki : <b>{{ $vouchers->count() }} Voucher</b>
                    </div>
                  </td>
                </tr>
              </table>        
            </div>
          </div>
        </div>

          <div class="row">
            <div class="col" style="padding: 0px 0px 20px 0px;">
            @foreach($vouchers as $vouc)
            <a href="/voucherundian/detail?id={{ $vouc->id }}"><article class="cards fl-left">
              <section class="date">
                <time datetime="23th feb">
                  <span>{{ strtoupper($vouc->code) }}</span>
                </time>
              </section>
              <section class="cards-cont">
                <small>Nama Undian</small>
                <h3>{{ strtoupper($vouc->name) }}</h3>
                <small>Di Undi Tanggal :</small>
                <h3>{{ date('d F Y', strtotime($vouc->diundi)) }}</h3>   
              </section>
            </article></a>
            @endforeach
          </div>
          
        </div>
        
    </div>
  </div>
</div>
        
@include('layout.footer')
        
</body>

</html>