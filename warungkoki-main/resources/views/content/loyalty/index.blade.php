@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Loyalty</h1>
            </div>
            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td width="25%" rowspan="2">
                      <img class="shadow" width="100%" src="/assets/img_company/001.jpg">
                    </td>
                    <td width="6%"></td>
                    <td style="font-size: 25px;" class="text-warning"><b>50 Point</b></td>
                  </tr>
                  <tr>
                    <td width="6%"></td>
                    <td style="font-size: 10px;">Point yang Anda Dapatkan dari CV Bangun Persada</td>
                  </tr>
                  
                </table>
              </div>
            </div>
            <br>
            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td width="25%" rowspan="2">
                      <img class="shadow" width="100%" src="/assets/img_company/002.jpg">
                    </td>
                    <td width="6%"></td>
                    <td style="font-size: 25px;" class="text-warning"><b>1782 Point</b></td>
                  </tr>
                  <tr>
                    <td width="6%"></td>
                    <td style="font-size: 10px;">Point yang Anda Dapatkan dari CV Organ Padu Rayu</td>
                  </tr>
                  
                </table>
              </div>
            </div>
            <br>
            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td width="25%" rowspan="2">
                      <img class="shadow" width="100%" src="/assets/img_company/003.jpg">
                    </td>
                    <td width="6%"></td>
                    <td style="font-size: 25px;" class="text-warning"><b>119 Point</b></td>
                  </tr>
                  <tr>
                    <td width="6%"></td>
                    <td style="font-size: 10px;">Point yang Anda Dapatkan dari PT Penjaringan Raya</td>
                  </tr>
                  
                </table>
              </div>
            </div>
            <br>
            <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td width="25%" rowspan="2">
                      <img class="shadow" width="100%" src="/assets/img_company/004.jpg">
                    </td>
                    <td width="6%"></td>
                    <td style="font-size: 25px;" class="text-warning"><b>2190 Point</b></td>
                  </tr>
                  <tr>
                    <td width="6%"></td>
                    <td style="font-size: 10px;">Point yang Anda Dapatkan dari PD Maju Mundur</td>
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
    
    $('#past').on('click', function () {

      $('#contentyourdeals').attr('style', 'display: none;');
      $('#contentpast').attr('style', 'display: block;');

      $('#yourdeals').attr('class', 'btn btn-sm btn-secondary');
      $('#past').attr('class', 'btn btn-sm btn-success');

    });

    $('#yourdeals').on('click', function () {

      $('#contentyourdeals').attr('style', 'display: block;');
      $('#contentpast').attr('style', 'display: none;');

      $('#yourdeals').attr('class', 'btn btn-sm btn-success');
      $('#past').attr('class', 'btn btn-sm btn-secondary');

    });

  </script>

</body>

</html>