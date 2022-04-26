@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Rewards</h1>
            </div>
            <div class="alert alert-primary2" role="alert">
                <button id="yourdeals" class="btn btn-sm btn-success" type="button">YOUR REWARDS</button>
                <button id="past" class="btn btn-sm btn-secondary" type="button">PAST</button>
            </div>
            <br>
            <div id="contentyourdeals" style="display: block;">
                <div class="card shadow">
                  <div class="card-body">
                    <h6>Anda Belum Memiliki Saldo Rewards untuk saat ini</h6>
                  </div>

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