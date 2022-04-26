@include('working-space.layout.head')
<style>
* {box-sizing: border-box}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>
<div class="main-content">
<!-- Header -->
<div class="header bg-gradient-shell pb-8 pt-6 pt-md-8">
  <div class="container-fluid">
    <div class="header-body">
      <!-- Card stats -->
      
    </div>
  </div>
</div>
<div class="container-fluid mt--9">
  <div class="row">
    <div class="col-xl-4 order-xl-2 mb-xl-0">
      <div class="card shadow-ss" style="background-color: #EFDBB2;">
        <div class="gambar">
          <div class="slideshow-container">
            @foreach($images as $img)
            <div class="mySlides">
              <img src="{{ asset ('assets/img_workingspace/'.$img->imgname) }}" style="width:100%">
            </div>
            @endforeach
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

          </div>
          <br>

          <div style="text-align:center">
            @for ($x = 1; $x <= $images->count(); $x++)
            <span class="dot" onclick="currentSlide({{ $x }})"></span> 
            @endfor
          </div>

        </div>
        <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
            <div style="font-size: 18px;padding-bottom: 6px; color: #323232;"><b>{{ $detailroom->room_name }}</b></div>
            <span class="badge badge-pill badge-success" style="font-size: 8px;"><i class="fa fa-map-marker"></i> {{ $detailroom->wilayah_name }}</span>
                <div style="font-size: 9px;color: #323232;padding-top: 6px;">
                  Lokasi berada di {{ $detailroom->alamat }} <b>{{ $detailroom->regency_name }}</b>
                </div>           
            <hr style="margin-bottom: 0.6rem;margin-top: 0.6rem;">
            <table width="100%" style="margin-bottom: 0.5rem;">
              <tr>
                  <td align="left">
                  <table>
                      <tr>
                          <td>
                             <b class="text-warning" style="font-size: 17px;">{{ rupiah($detailroom->harga_hour) }}</b>
                          </td>
                          <td>
                             <div style="font-size: 9px;color: #323232;"><b>/ Per Jam</b></div>
                          </td>
                      </tr>
                  </table>
                  </td>
                  <td>
                    <table>
                      <tr>
                          <td>
                             <b class="text-warning" style="font-size: 17px;">{{ rupiah($detailroom->harga_day) }}</b>
                          </td>
                          <td>
                             <div style="font-size: 9px;color: #323232;"><b>/ Per Hari</b></div>
                          </td>
                      </tr>
                  </table>
                  </td>
              </tr>
            </table>
<!--             <div style="font-size: 12px;margin-bottom: 7px;">
              <b>Diskusi</b> (32)  |  <b>Booked</b>  100
            </div> -->

            <div style="font-size: 10px;color: #323232;">
                {{ $detailroom->desc }}
            </div>
            <br>
            <a href="/working-space/booked?uuid={{ $detailroom->uuid }}"><button class="btn btn-block btn-secondary menusxx" type="button">Booking Sekarang</button></a>
        </div>
      </div>
    </div>
  </div>
</div>
        
      
@include('working-space.layout.footer')
<script type="text/javascript">
  
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

</script>
</body>

</html>