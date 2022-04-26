@include('layout.head')
<style type="text/css">
  input[type=checkbox]
  {
    -webkit-appearance:checkbox;
  }
</style>
<div class="main-content">   
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
    <div class="row">
      <div class="col">
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Cek Voucher</h1>
          </div>         
         <hr>
         <input type="text" id="kode" class="form-control" value="{{ $kode }}" placeholder="Masukan Kode Voucher">
         <br>
         <button onclick="Cari();" class="btn btn-block btn-success">Cari</button>

         @if($kode != null)

          <hr>
            @if($voucher)

            <div class="card">
              <div class="card-body">
                <div>Status Voucher :</div>
                <div style="padding-top: 5px;font-size: 18px;"><b class="text-success">{{ strtoupper($voucher->status) }}</b> ({{ $kode }})</div>
                <hr>

                <div>Voucher reedem di Wilayah :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ $voucher->wilayah_name }}</div>
                <hr>

                <div>Waktu Reedem :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ date('d F Y H:i', strtotime($voucher->waktu)) }}</div>
                <hr>

                <div>Nama User :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ $voucher->user_name }}</div>
                <hr>

                <div>Jenis Voucher :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ $voucher->voucher_name }}</div>
                <hr>

                <div>Status Transaksi :</div>
                <div style="padding-top: 5px;font-size: 18px;">{{ strtoupper($voucher->trans_status) }}</div>
                <hr>
                
              </div>
            </div>
            <br><br><br>

            @else

              @if($cekvoucher)

                @if($cekvoucher->status == NULL)

                <div class="card">
                  <div class="card-body">
                    <div>Status Voucher :</div>
                    <div style="padding-top: 5px;font-size: 18px;"><b class="text-warning">Voucher Belum Digunakan</b></div>
                    <hr>

                    <div>Jenis Voucher :</div>
                    <div style="padding-top: 5px;font-size: 18px;">{{ $cekvoucher->name }}</div>
                    <hr>
                    
                  </div>
                </div>
                <br><br><br>

                @endif

              @else

                <div class="card shadow">
                  <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td align="center">
                          <img src="/assets/content/img/theme/error.jpg" width="100%">
                          <br>
                          <h6>Kode Voucher Tersebut tidak ada pada Sistem Kami</h6>
                        </td>
                      </tr>
                    </table>
                  </div>

                </div>
                <br><br><br>

              @endif


            @endif

         @endif
      </div> 
    </div> 
  </div>
</div>
@include('layout.footer')
<script type="text/javascript">
  
function Cari(){

  var kode = $('#kode').val();

  if(kode == ''){

    swal({
      title: "Perhatikan",
      text: "Pastikan Anda Memasukan Kode Voucher",
      icon: "error",
      buttons: false,
      timer: 2000,
    });

  } else {
    setTimeout(function(){ window.location.href = '/voucher/cek?kode='+kode; }, 200);
  }

}

</script>
</body>
</html>