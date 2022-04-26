
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme_color" content="#ffffff">   
  <title>IOLOSMART Mobile System</title>
  <!-- Favicon -->
  <link href="/assets/icon/72x72.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Icons -->
  <link href="/assets/content/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="/assets/content/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <!-- CSS Files -->
  <link href="/assets/content/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

    <link rel="manifest" href="/manifest.json">
  <!-- ios support -->
  <link rel="apple-touch-icon" href="/assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">
</head>
<body class="">
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-4">
      <div class="row">
        <div class="col">
            <div class="card shadow">  
              <div class="card-body bg-iolo">
                
                <table border="0" align="center" width="100%">
                  <tr>
                    <td height="100px"> &nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center">
                      <img width="50%" src="./assets/content/img/theme/ceklis_kuning.png">
                    </td>
                  </tr>
                  <tr>
                    <td height="10px"> &nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center"><h1 class="text-white">TERIMA KASIH!</h1></td>
                  </tr>
                  <tr>
                    <td align="center"><h4 class="text-white">Konfirmasi Pendaftaran Akun IOLO-SMART Berhasil dilakukan. Segera lakukan Login pada aplikasi IOLO-SMART di Smartphone Anda.</h4></td>
                  </tr>
                  <tr>
                    <td height="20px"> &nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center"><a href="/login"><button class="btn btn-secondary"> Login</button></a></td>
                  </tr>
                  <tr>
                    <td height="100px"> &nbsp;</td>
                  </tr>

                </table>

              </div>
            </div>
        </div> 
      </div> 
    </div>
  </div>
      @include('layout.footer')

</body>

</html>