@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 10.2rem;">
      <div class="row">
        <div class="col">
            <video id="preview" width="100%"></video>
        </div> 
      </div> 
    </div>
  </div>
  @include('layout.footer')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
   let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
   Instascan.Camera.getCameras().then(function(cameras){
       if(cameras.length > 0 ){
           scanner.start(cameras[1]);
       } else{
           alert('No cameras found');
       }

   }).catch(function(e) {
       console.error(e);
   });

   scanner.addListener('scan',function(c){
       
       setTimeout(function(){ window.location.href='/reedem/view?code='+c+''; }, 500);

       
   });

</script>
</body>
</html>