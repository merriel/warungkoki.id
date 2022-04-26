@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Saldo Data Hadiah</h1>
            </div>

            <table id="customers">
              <tr>
                <th>Nama Hadiah</th>
                <th>Saldo</th>
                <th>Ambil</th>
              </tr>
              @php
              $totbanyak=0;
              $totambil=0;
              @endphp
              @foreach($hadiah as $h)
              @php

                $banyak = DB::table('hadiah')
                ->where([
                    ['name', $h->name],
                    ['status', null],
                ])
                ->get();

                $ambil = DB::table('hadiah')
                ->where([
                    ['name', $h->name],
                    ['status', 'SELESAI'],
                ])
                ->get();

                $totbanyak += $banyak->count();
                $totambil += $ambil->count();

              @endphp
              <tr>
                <td>{{ $h->name }}</td>
                <td>{{ $banyak->count() }}</td>
                <td>{{ $ambil->count() }}</td>
              </tr>
              @endforeach
              <tr>
                <th><b>TOTAL</b></th>
                <th>{{ $totbanyak }}</th>
                <th>{{ $totambil }}</th>
              </tr>
            </table>
           
        </div> 
      </div> 
    </div>
  </div>

@include('layout.footer')

</body>

</html>