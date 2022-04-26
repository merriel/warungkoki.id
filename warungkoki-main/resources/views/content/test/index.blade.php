@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-iolo pb-9 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="javascript: window.history.go(-1)"><button type="button" id="back" class='btn btn-sm btn-success'>Kembali</button></a> -->
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        
        <div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow-ss">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">My Profile</h3>
                </div>
                
              </div>
            </div>
            <div class="card-body">
              <h6 class="heading-small text-muted mb-4">Informasi User</h6>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Pilih User</label>
                      <select class="form-control" id="fcm">
                        @foreach($datas as $data)
                        <option value="{{ $data->fcm_token }}">{{ $data->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-email">Pesan</label>
                      <textarea class="form-control" id="desc"></textarea>
                    </div>
                  </div>
                </div>
                <button type="button" onclick="Kirim();" class="btn btn-block btn-primary">Kirim Notifikasi</button>
              </div>
            </div>
          </div>
        </div>
      
        @include('layout.footer')

        <script type="text/javascript">

            function Kirim(){

              var desc = $('#desc').val();

              $.ajax({        
                type : 'POST',
                url : "https://fcm.googleapis.com/fcm/send",
                headers : {
                    Authorization : 'key=' + 'AAAAU-mXBsU:APA91bEc3wKuUUQ-NLMojpryH8-516ghVvjFpZVRJUQ0_2ZuOoSQGiUo8M0p15kJ952rdgabjLrJhB7vkeDSiM6RxaaIDLagqllv3VdRsK5BXYG5YxZUSRrt6I-iizZ8gsI-B2db82Q3'
                },
                contentType : 'application/json',
                dataType: 'json',
                data: JSON.stringify({
                    "to": $('#fcm').val(), 
                    "notification": {
                        "title":"IOLOSMART NOTIFICATIONS!",
                        "body":""+desc+"",
                        "icon": "https://iolosmart.com/assets/icon/96x96.png",
                        "click_action": "https://development.iolosmart.com/",
                    }
                }),
                success : function(response) {
                    swal({
                      title: "Berhasil",
                      text: "Notif Berhasil Terkirim!",
                      icon: "success",
                      buttons: false,
                      timer: 2000,
                    });

                    setTimeout(function(){ window.location.reload() }, 1500);
                },
                error : function(xhr, status, error) {
                    console.log(xhr.error);                   
                }
              });


            }

        </script>
</body>

</html>