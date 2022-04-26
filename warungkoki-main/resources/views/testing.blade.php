@include('layout.head')
<button class="btn btn-primary" id="testings">Testing</button>
@include('layout.footer')

  <script type="text/javascript">

    $('#testings').on('click', function () {

      $.ajax({        
          type : 'POST',
          url : "https://fcm.googleapis.com/fcm/send",
          headers : {
              Authorization : 'key=' + 'AAAA3bD3JKA:APA91bG_lHl0sNk3eYKTYqRBaxXofKcfr3z-Usx2cqcnAKSGJt9Waxe-pJ1mYipdAsaN3Z95uYDKB163r4eZbzJTjEXOmiUwQf1EssM4GZvJjPG95vTdKflOyTbbS6pxsDiyJZBYacH8'
          },
          contentType : 'application/json',
          dataType: 'json',
          data: JSON.stringify({
              "to": "dg6FNdE8n-c:APA91bE2uJQ0z6RJRcJfRgySI0aRbCg27xQqfsDeLmm3jT0Xny_OdRscQag5q-mLr3iutK_FQsiCdCmhSthUwoNJhSSpopo6XIP9wpOd-HeD5L8bFxEabeaEbD7EIdoUYiH1LA56K7O3", 
              "notification": {
                  "title":"IOLOSMART - Redeem Berhasil!",
                  "body":"Anda Berhasil Mengambil Produk",
                  "icon": "https://iolosmart.com/assets/icon/96x96.png",
              }
          }),
          success : function(response) {
              console.log(response);
          },
          error : function(xhr, status, error) {
              console.log(xhr.error);                   
          }
      });   
    });

           
  </script>
</body>

</html>