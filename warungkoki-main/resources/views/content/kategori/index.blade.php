@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Kesehatan</h1>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <img class="card-img-top" src="./assets/content/img/theme/service.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="nama1"> <b>Paket Service Mantap</b></h5>
                    <p align="justify">Some quick example text to build on the card title.</p>
                    <h4 style="color: #fb6340;"><b>Rp. 150.000</b></h4>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                  </div>
                </div>
              </div> 
              <div class="col-6">
                <div class="card">
                  <img class="card-img-top" src="./assets/content/img/theme/ojol.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="nama1"> <b>Paket On Bit Ojol Standar </b></h5>
                    <p align="justify">Some quick example text to build on the card title.</p>
                    <h4 style="color: #fb6340;"><b>Rp. 73.500</b></h4>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                  </div>
                </div>
              </div>   
            </div>
            <br>
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <img class="card-img-top" src="./assets/content/img/theme/bensin.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="nama1"> <b>Paket Isi Bensin Ceria</b></h5>
                    <p align="justify">Some quick example text to build on the card title.</p>
                    <h4 style="color: #fb6340;"><b>Rp. 82.000</b></h4>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                  </div>
                </div>
              </div> 
              <div class="col-6">
                <div class="card">
                  <img class="card-img-top" src="./assets/content/img/theme/oilchange.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="nama1"> <b>Paket Ganti Oli Keren</b></h5>
                    <p align="justify">Some quick example text to build on the card title.</p>
                    <h4 style="color: #fb6340;"><b>Rp. 57.500</b></h4>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;color:orange;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                    <span class='fa fa-star' style='font-size:10px;'></span>
                  </div>
                </div>
              </div>   
            </div>
          </div> 
        </div> 
      </div>
    </div>
      
      @include('layout.footer')

      <script type="text/javascript">
  
        $('.nama1').on('click', function () {

          setTimeout(function(){ window.location.href='details'; }, 10);

        });
      </script>

</body>

</html>