@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Transaksi</h1>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="card bg-iolo-blue shadow" id="dealss" onclick="Beli();">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td align="center"><i class="fa fa-shopping-bag" id="icondeals" style="font-size: 24px; color: #ffffff"></i></td>
                           <td align="center"><h5 id="textdeals" class="text-white"><b>BELI</b></h5></td>
                        </tr>
                      </table>
                    </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card shadow" id="challangess" onclick="Reedem();">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td align="center"><i class="fa fa-gamepad" id="iconchallanges" style="font-size: 24px; color: #01497f"></i></td>
                          <td align="center"><h5 id="textchallenges"><b>REEDEM</b></h5></td>
                        </tr>
                        
                      </table>
                    </div>
                </div>
              </div>
            </div>

            <div id="beli" style="display: block;">
              <table class="table align-items-center datatables">
                <thead class="thead-light">
                  <tr>
                      <th scope="col" style="display: none;">
                          Nama
                      </th>
                      <th scope="col" style="display: none;">
                          Tanggal
                      </th>
                      <th scope="col">
                          Nama
                      </th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>

            <div id="reedem" style="display: none;">
              <table class="table align-items-center datatabless">
                <thead class="thead-light">
                  <tr>
                      <th scope="col" style="display: none;">
                          Nama
                      </th>
                      <th scope="col" style="display: none;">
                          Tanggal
                      </th>
                      <th scope="col">
                          Nama
                      </th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>

        </div> 
      </div> 
    </div>
  </div>
@include('layout.footer')
<script type="text/javascript">

  function Reedem(){

    $('#reedem').attr("style","display: block;");
    $('#beli').attr("style","display: none;");

    $('#iconchallanges').attr("style","font-size: 24px; color: #ffffff;");
    $('#textchallenges').attr("class","text-white");
    $('#challangess').attr("class","card bg-iolo-blue shadow");

    $('#icondeals').attr("style","font-size: 24px; color: #01497f;");
    $('#textdeals').attr("class","");
    $('#dealss').attr("class","card shadow");

  }

  function Beli(){

    $('#reedem').attr("style","display: none;");
    $('#beli').attr("style","display: block;");

    $('#icondeals').attr("style","font-size: 24px; color: #ffffff;");
    $('#textdeals').attr("class","text-white");
    $('#dealss').attr("class","card bg-iolo-blue shadow");

    $('#iconchallanges').attr("style","font-size: 24px; color: #01497f;");
    $('#textchallenges').attr("class","");
    $('#challangess').attr("class","card shadow");

  }
        
    var table = "";
    $(function() {
        table = $('.datatables').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false
                },
                {
                    "targets": [ 1 ],
                    "visible": false
                }
            ],
            order: [[ 1, 'desc' ]],
            ajax:{
                 url: "{{ route('getdatatransaksi') }}",
                 dataType: "json",
                 type: "GET",
            },
            columns: [
                { data: 'post_name', name: 'post_name' },
                { data: 'created_at', name: 'created_at' },
                { 
                    render: function ( data, type, row ) {
                        return '<div class="card shadow"><div class="card-body"><table width="100%"><tr><td width="20%" rowspan="3"><div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow"><i class="fas fa-shopping-bag" style="color: #ffffff;font-size= 10px"></i></div></td><td><b><div style="font-size: 15px">'+row.post_name+'</div></b><div style="font-size: 10px; padding-top: 2px;">'+row.date+' | '+row.amount+'</div></td></tr><tr><td style="padding-top: 0px;"><span class="badge badge-primary"><i class="fa fa-credit-card"></i>  '+row.type_bayar+'</span> <span class="badge badge-success"><i class="fa fa-exclamation-triangle"></i>  '+row.status+'</span></td></tr></table></div></div>';
                    }
                }
            ]
        });
    });


    var table = "";
    $(function() {
        table = $('.datatabless').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            columnDefs: [
                {
                    "targets": [ 0 ],
                    "visible": false
                },
                {
                    "targets": [ 1 ],
                    "visible": false
                }
            ],
            order: [[ 1, 'desc' ]],
            ajax:{
                 url: "{{ route('getdatareedem') }}",
                 dataType: "json",
                 type: "GET",
            },
            columns: [
                { data: 'post_name', name: 'post_name' },
                { data: 'created_at', name: 'created_at' },
                { 
                    render: function ( data, type, row ) {
                        return '<div class="card shadow"><div class="card-body"><table width="100%"><tr><td width="20%" rowspan="3"><div class="icon icon-shape bg-blue-par2 text-white rounded-circle shadow"><i class="fas fa-shopping-bag" style="color: #ffffff;font-size= 10px"></i></div></td><td><b><div style="font-size: 15px">'+row.prod_name+'</div></b><div style="font-size: 10px; padding-top: 2px;">'+row.date+' | Ambil : '+row.qty+'</div></td></tr><tr><td style="padding-top: 0px;"><span class="badge badge-primary"><i class="fa fa-credit-card"></i>  '+row.status+'</span> <span class="badge badge-success"><i class="fa fa-user-secret"></i>  '+row.user_name+'</span></td></tr></table></div></div>';
                    }
                }
            ]
        });
    });

</script>

</body>


</html>