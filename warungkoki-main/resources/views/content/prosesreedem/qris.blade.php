@include('layout.head')
<style type="text/css">
  #customers {
    border-collapse: collapse;
    width: 100%;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 11px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers th {
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: #feac3b;
    color: white;
  }
</style>
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 6rem;">
      <!-- Card stats -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-ss" style="border-radius:2rem;">
            <div class="card-body">

              @if($data == 0)

              <img src="/assets/content/img/theme/error.jpg" width="100%">
              <hr>
              <div class="text-warning"><b style="font-size: 15px;">PERHATIKAN!</b></div>
              <div>
                Wilayah Toko Beda! Pastikan Pelanggan membeli atau memesan pesanannya di Lokasi yang sesuai
              </div>

              @elseif($data == 2)

              <img src="/assets/content/img/theme/dealempty.jpg" width="100%">
              <hr>
              <div class="text-warning"><b style="font-size: 15px;">BERHASIL!</b></div>
              <div>
                Transaksi Tersebut sudah Selesai, Terimakasih!
              </div>

              @else

              <table width="100%" border="0">
                <tr>
                  <td align="center">
                    <img width="100%" src="{{ $transxx->qris }}"><br>
                    <div style="font-size:24px;font-weight: bold; padding-bottom: 10px;" id="countdown">{{ $waktu }}</div>
                    <a download="{{ $transxx->uuid }}.jpg" href="{{ $transxx->qris }}" title="ImageName"><button class="btn btn-sm btn-success">Download</button></a>
                  </td>
                </tr>
              </table>
              <hr>
              <div class="text-warning"><b style="font-size: 15px;">PERHATIKAN!</b></div>
              <div>
                Tunjukan QRCode QRIS ini kepada Pelanggan untuk melanjutkan Pembayaran. Pastikan Anda melihat status pembayaran pelanggan di selesai pembayaran, sebelum memberikan barang yang dibeli ke Pelanggan
              </div>

              @endif
            </div>
          </div>
          <br><br><br>
        </div>
      </div>
    </div>

@include('layout.footer')  

<script type="text/javascript">
  
var seconds;
var temp;
var GivenTime = document.getElementById('countdown').innerHTML

function countdown() {
  time = document.getElementById('countdown').innerHTML;
  timeArray = time.split(':')
  seconds = timeToSeconds(timeArray);
  if (seconds == '') {
    temp = document.getElementById('countdown');
    temp.innerHTML = GivenTime;
    time = document.getElementById('countdown').innerHTML;
    timeArray = time.split(':')
    seconds = timeToSeconds(timeArray);
  }
  seconds--;
  temp = document.getElementById('countdown');
  temp.innerHTML = secondsToTime(seconds);
  var timeoutMyOswego = setTimeout(countdown, 1000);
  if (secondsToTime(seconds) == '00:00') {
    clearTimeout(timeoutMyOswego); //stop timer
    $('.loading').attr('style','display: block');

    swal("Waktu Pembayaran Habis!", {
       icon: "warning",
       buttons: false,
       timer: 2000,
    });

    setTimeout(function(){ window.location.href = '/home'; }, 1500);
  }
}

function timeToSeconds(timeArray) {
  var minutes = (timeArray[0] * 1);
  var seconds = (minutes * 60) + (timeArray[1] * 1);
  return seconds;
}

function secondsToTime(secs) {
  var hours = Math.floor(secs / (60 * 60));
  hours = hours < 10 ? '0' + hours : hours;
  var divisor_for_minutes = secs % (60 * 60);
  var minutes = Math.floor(divisor_for_minutes / 60);
  minutes = minutes < 10 ? '0' + minutes : minutes;
  var divisor_for_seconds = divisor_for_minutes % 60;
  var seconds = Math.ceil(divisor_for_seconds);
  seconds = seconds < 10 ? '0' + seconds : seconds;

  return minutes + ':' + seconds;
  //hours + ':' + 

}
countdown();
</script>
</body>

</html>