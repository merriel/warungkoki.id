@include('xmission.layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-purple pt-4 pt-md-8" style="padding-bottom: 14rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/users/transaksi"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="row justify-content-center">
              <h3 class="text-white">Mission Anda Saat ini</h3>   
          </div>
          <br>
          @if($missions->count() == 0)
            <div class="row">
              <div class="col-12">
                <div class="card shadow">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <table width="100%">
                          <tr>
                            <td align="center">
                              <img src="/assets/content/img/theme/nothing.jpg" width="90%">
                              <br>
                              <div style="font-size: 14px;color: black;padding-bottom: 6px;"><b>Kosong!</b></div>
                              <h6>Tidak ada Mission yang Berlangsung untuk saat ini!</h6>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
          @else
            @foreach($missions as $mis)
            <a class="menusxx" href="/xmission/proses/detail?uuid={{ $mis->transuuid }}" style="color: #525f7f;">
            <div class="card shadow-ss" style="border-radius: 1rem;">
              <div class="gambar">
                <img class="card-img-top" style="border-top-left-radius: calc(1rem - 1px);border-top-right-radius: calc(1rem - 1px);" width="50px" src="/assets/content/img/theme/promcat4.jpg" alt="Card image cap">
              </div>
              <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                <div style="font-size: 14px;font-weight: bold;padding-bottom: 9px;">
                  {{ $mis->name }}
                </div>
                <div style="font-size: 11px;">
                  {{ $mis->little }}
                </div>
                
              </div>
            </div>
            </a>
            <br>
            @endforeach
          @endif
      </div>
    </div>

  @include('xmission.layout.footer')
  @include('xhome.history.modal')
</body>

<script type="text/javascript">

  function Selesai(id){

    $('#id').val(id);
  
    $('#konfirmasi').modal('show');

  }

  function YakinUtama(){
  
    $.ajax({
     type: 'POST',
     url: "{{ route('xhome.history.selesai') }}",
     data: {
          '_token': $('input[name=_token]').val(),
          'id': $('#id').val(),
      },
     success: function(data) {

      swal({
          title: "Berhasil",
          text: "Pesanan Anda sudah Selesai!",
          icon: "success",
          buttons: false,
          timer: 2000,
      });

      setTimeout(function(){ window.location.href = '/xhome/history'; }, 1500);

     }

   });

  }

</script>

</html>