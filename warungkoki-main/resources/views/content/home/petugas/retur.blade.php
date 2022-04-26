@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
      <div class="row">
        <div class="col">
         <!--  <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a> -->
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Pengajuan Retur</h1>
              <!-- <span class="badge badge-pill badge-default">Update Stok Terakhir : Doni Prasetyo (20 Oktober 2020 17:22)</span> -->
            </div>
            <div style="font-size: 12px;padding-bottom: 12px;"> Berikut ini adalah data-data dari pengajuan Retur yang dilakukan oleh pelanggan.</div>
            <table id="customers">
              <tr>
                <th>Inv</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>#</th>
              </tr>

              @if($trans->count() == 0)
              <tr>
                <td colspan="4" align="center" style="font-size:12px;">Tidak ada Pengajuan Apapun untuk saat ini!</td>
              </tr>
              @else
                @foreach($trans as $tr)
                <tr>
                  <td>{{ $tr->uuid }}</td>
                  <td>{{ date('d-m-Y', strtotime($tr->created_at)) }}</td>
                  @if($tr->status == "DIPROSES")
                    <td class="text-warning"><b>DIPROSES</b></td>
                  @elseif($tr->status == "DITOLAK")
                    <td class="text-danger"><b>DITOLAK</b></td>
                  @else
                    <td class="text-success"><b>DISETUJUI</b></td>
                  @endif
                  <td><a href="/petugas/retur/detail?uuid={{ $tr->uuid }}"><button class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button></a></td>
                </tr>
                @endforeach

              @endif
            </table>
        </div> 
      </div> 
      <br><br>
    </div>
  </div>
  @include('layout.footer')

  <script type="text/javascript">
    
    function LihatRetur(id){

      $('#lihatretur').modal('show');

    }

  </script>

</body>

</html>