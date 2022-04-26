@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/outlet"><button type="button" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Reporting</h1>
            </div>

            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td colspan="2" style="padding-bottom: 8px;">Dari Tanggal :</td>
                  </tr>
                  <tr>
                    <td><input type="date" id="daritanggal" class="form-control"></td>
                    <td><input type="number" id="jamdariwaktu" value="00" class="form-control"></td>
                    <td><b>:</b></td>
                    <td><input type="number" id="menitdariwaktu" value="00" class="form-control"></td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td colspan="2" style="padding-bottom: 8px;">Sampai Tanggal :</td>
                  </tr>
                  <tr>
                    <td><input type="date" id="sampaitanggal" class="form-control"></td>
                    <td><input type="number" id="jamsampaiwaktu" value="23" class="form-control"></td>
                    <td><b>:</b></td>
                    <td><input type="number" id="menitsampaiwaktu" value="59" class="form-control"></td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr>
                    <td colspan="4" style="padding-bottom: 8px;">Type Report</td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <select class="form-control" id="type">
                        <option></option>
                        <option value="all">All</option>
                        <option value="penjualan">Transaksi Penjualan</option>
                        <option value="reedem">Transaksi Reedem</option>
                      </select>
                    </td>
                  </tr>
                  <tr><td>&nbsp;</td></tr>
                </table>
                <table width="100%"> 
                  <tr>
                    <td align="center" id="caributton">
                      <button class="btn btn-info">Search</button>
                    </td>
                    <td align="center" id="print">
                      <button class="btn btn-success">Print Excel</button>
                    </td>
                  </tr>
                </table>
                
              </div>
            </div>
        </div> 
      </div> 
    </div>
  </div>

  @include('layout.footer')
  <script type="text/javascript">
    
    $('#jamdariwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 23 || angka == ''){

        $('#jamdariwaktu').val('00');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = angka;
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');

    });

    $('#jamsampaiwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 23 || angka == ''){

        $('#jamsampaiwaktu').val('23');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = angka;
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');

    });

    $('#menitdariwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 59 || angka == ''){

        $('#menitdariwaktu').val('00');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = angka;
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');

    });

    $('#menitsampaiwaktu').on('keyup', function () {

      var angka = $(this).val();

      if(angka > 59 || angka == ''){

        $('#menitsampaiwaktu').val('59');

      }

      var type = $('#type').val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = angka;

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');

    });

    $('#daritanggal').on('change', function () {

      var tanggaldari = $(this).val();
      var tanggalsampai = $('#sampaitanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();
      var type = $('#type').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');


    });

    $('#sampaitanggal').on('change', function () {

      var tanggalsampai = $(this).val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();
      var type = $('#type').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


      $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');


    });

    $('#type').on('change', function () {

      var type = $(this).val();
      var tanggalsampai = $('#sampaitanggal').val();
      var tanggaldari= $('#daritanggal').val();
      var jamdari = $('#jamdariwaktu').val();
      var menitdari = $('#menitdariwaktu').val();
      var jamsampai = $('#jamsampaiwaktu').val();
      var menitsampai = $('#menitsampaiwaktu').val();

      var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
      var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;

      if(type == 'all'){

        $('#caributton').html('');

      } else {

        $('#caributton').html('<a href="/report/detail?dari='+dari+'&sampai='+sampai+'&type='+type+'"><button class="btn btn-info">Search</button>');

      }


    });

    $('#print').on('click', function () {

        swal("Report Berhasil di Download!", {
             icon: "success",
             buttons: false,
             timer: 2000,
        });

        var type = $('#type').val();
        var tanggalsampai = $('#sampaitanggal').val();
        var tanggaldari= $('#daritanggal').val();
        var jamdari = $('#jamdariwaktu').val();
        var menitdari = $('#menitdariwaktu').val();
        var jamsampai = $('#jamsampaiwaktu').val();
        var menitsampai = $('#menitsampaiwaktu').val();

        var dari = tanggaldari+ ' '+jamdari+':'+menitdari;
        var sampai = tanggalsampai+ ' '+jamsampai+':'+menitsampai;


        setTimeout(function(){ window.location.href = '/report/printexcel?dari='+dari+'&sampai='+sampai+'&type='+type+''; }, 500);

    });

  </script>
</body>

</html>