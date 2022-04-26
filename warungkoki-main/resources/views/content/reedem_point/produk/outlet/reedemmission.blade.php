@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Aktivitas Reedem Mission</h1>
            </div>

            <table id="customers">
              <tr>
                <th>Tanggal</th>
                <th>Banyaknya Item</th>
              </tr>
              @foreach($missions as $miss)
              @php

              $hari = date('D', strtotime($miss->date));

              if($hari == 'Sun'){
                  $hari_ini = "Minggu";
              } else if($hari == 'Mon'){
                  $hari_ini = "Senin";
              } else if($hari == 'Tue'){
                  $hari_ini = "Selasa";
              } else if($hari == 'Wed'){
                  $hari_ini = "Rabu";
              } else if($hari == 'Thu'){
                  $hari_ini = "Kamis";
              } else if($hari == 'Fri'){
                  $hari_ini = "Jumat";
              } else {
                  $hari_ini = "Sabtu";
              }

              @endphp
              
              <tr>
                <td>{{ $hari_ini }}, {{ date('d F Y', strtotime($miss->date)) }}</td>
                
              </tr>
              @endforeach
              
            </table>
           
        </div> 
      </div> 
    </div>
  </div>

@include('layout.footer')

</body>

</html>