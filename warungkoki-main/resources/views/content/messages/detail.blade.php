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

  <link rel="stylesheet" type="text/css" href="/assets/content/css/loading.css">
  <!-- CSS Files -->
  <link href="/assets/content/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" />

    <link rel="manifest" href="/manifest.json">
  <!-- ios support -->
  <link rel="apple-touch-icon" href="/assets/icon/96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#aa7700">

  <style type="text/css" media="screen">
    .drawingBuffer {
      position: absolute;
      top: 0;
      left: 0;
    }

    .swal-text {    
      text-align: center;
    }
    
    .swal-overlay {
      background-color: rgba(1, 73, 127, 0.7);
    }

    #customers {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #003168;
      color: white;
    }

    .footer {
      position: absolute;
      right: 0;
      bottom: 0;
      left: 0;
      padding: 1rem;
      background-color: #efefef;
      text-align: center;
    }

  </style>
</head>
<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main" style="padding-bottom: 0.6rem;">
    <div class="container-fluid">
      <!-- Toggler -->
      {{ csrf_field() }}
      
      @if(Auth::user() != null)
        <input type="hidden" class="form-control" id="role" value="{{ Auth::user()->role_id }}">
      @else
        <input type="hidden" class="form-control" id="role" value="0">
      @endif

      <table width="100%">
        <tr>
          <td width="10%" rowspan="2"><a href="/messages" class="menusxx"><i style="font-size: 20px;" class="fa fa-arrow-circle-left"></i></a></td>
          <td width="20%" rowspan="2">
            <a href="#" class="avatar rounded-circle mr-3">
              <img alt="Image placeholder" src="/assets/content/img/theme/noname.png">
            </a>
          </td>
          <td align="left">
            <div style="font-size: 18px;"><b>Doni Prastyo</b></div>
          </td>
          <tr>
            <td>
              <div style="font-size: 10px;color: #A9A9A9;">Online</div>
            </td>
          </tr>
        </tr>
      </table>
      <div class="loading" style="display: none;">Loading&#8230;</div>
    </div>
  </nav>

  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-4 pt-md-8">
          <!-- Card stats -->
        <div class="row">
          <div class="col">
            
          </div>
        </div>

    </div>
  </div>    
@include('layout.footer')
<div class="footer" style="padding-bottom: 0rem;padding-top: 0rem;">
    <div class="row">
      <div class="col-12" style="padding: 0px;">
        <div class="card">
          <div class="card-body bg-iolo">
            <div class="row">
              <div class="col-12" align="right" style="padding-bottom: 0px; padding-top: 10px;">
                <table width="100%">
                  <tr>
                    <td>
                      <input type="text" placeholder="Chat Disini" class="form-control">
                    </td>
                    <td width="3%">
                      &nbsp;
                    </td>
                    <td width="8%">
                      <button class="btn btn-success"><i class="fa fa-comment"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</body>
</html>