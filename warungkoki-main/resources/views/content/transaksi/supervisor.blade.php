@include('layout.head')
<style type="text/css">
  td {
    white-space: nowrap;
  }
</style>
<div class="main-content">   
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
    <div class="row">
      <div class="col">
        <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Transaksi Penjualan</h1>
          </div>         
         <hr>
      </div>
      <div class="col-12">
        <div class="card shadow" style="padding: 1.5rem;">
        <label>Pilih Site :</label>
        <select class="form-control" id="site">
          <option value="all"> All Site</option>
          @foreach($sites as $sit)
          <option value="{{ $sit->id }}">{{ $sit->name }}</option>
          @endforeach
        </select>
        <br>
        <label>Dari Tanggal :</label>
        <input type="date" class="form-control" value="{{ $blnawal }}" id="dari">
        <br>
        <label>Sampai Tanggal :</label>
        <input type="date" class="form-control" value="{{ $blnakhir }}" id="sampai">
        <hr>
      
        <div class="table-responsive">
          <!-- Projects table -->
          <table id="customers" class="datatables" width="100%">
            <thead>
              <tr>
                <th style="display: none;">ID</th>
                <th>UserID</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Wilayah</th>
                <th>Invoice</th>
                <th width="10%">Amount</th>
                <th>Bayar</th>
                <th width="7%">Opsi</th>
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


<!-- ===== MODAL ===== -->
<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h3 class="modal-title" id="modal-title-default"> Detail Transaksi</h3>  
      </div>
      
      <div class="modal-body"  style="padding-bottom: 0px;padding-top: 0px;">
        <div class="row content">
          <div class="col-8">
              <label>Nama :</label>
              <br>
              <div style="font-size: 17px;" id="viewname"></div>
              <hr>
          </div>
          <div class="col-4" style="padding-left: 0px;">
              <label>Download Invoice :</label>
              <br>
              <a target = '_blank' id="link"><button class="btn btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;Download</button></a>
          </div>
          <div class="col-12">
              <label>Beli di Toko :</label>
              <br>
              <div style="font-size: 17px;" id="wilayahnya"></div>
              <hr>
              <label>Tanggal Beli :</label>
              <br>
              <div style="font-size: 17px;" id="tanggalnya"></div>
              <hr>
              <label>Petugas :</label>
              <br>
              <div style="font-size: 17px;" id="petugas"></div>
              <hr>
              <label>Total Bayar</label>
              <br>
              <div class="text-success" style="font-size: 17px;font-weight: bold;" id="totalbayar"></div>
              
              <hr>
              <div class="table-responsive">
                <table id="customers" width="100%">
                  <tr>
                      <th>Nama Barang</th>
                      <th id="rupiah">Harga</th>
                      <th>Qty</th>
                      <th id="rupiah">Total</th>
                  </tr>
                  <tbody id="viewcontent">
                      
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
      
      <div class="modal-footer tombol">
          <table width="100%">
              <tr>
                  <td align="left">
                      <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Close</button> 
                  </td>
                  
              </tr> 
          </table>
      </div>
    </div>
  </div>
</div>
@include('layout.footer')
<script type="text/javascript">
  
var table = "";
$(function() {

    table = $('.datatables').DataTable({
        pageLength: 20,
        processing: true,
        serverSide: true,
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "render": $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' )
            },
        ],
        order: [[ 0, 'desc' ]],
        ajax:{
             url: "{{ route('transaksi.datapenjualan') }}",
             dataType: "json",
             type: "POST",  
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
             data: function (d) {
                d.wilayah = $('#site').val();
                d.dari = $('#dari').val();
                d.sampai = $('#sampai').val();
            },
        },
        columns: [
            { data: 'id', name: 'id' },  
            { data: 'user_id', name: 'user_id' },
            { data: 'user_name', name: 'name'},
            { data: 'tanggal', name: 'tanggal' },
            { data: 'wilayah_name', name: 'wilayah_name' },
            { data: 'uuid', name: 'uuid' },
            { data: 'amount', name: 'amount' },
            { 
                render: function ( data, type, row ) {

                  if(row.type_bayar == "ONLINE"){
                    return 'GOPAY';
                  } else if(row.type_bayar == "Cash"){
                    return 'Bayar di Kasir';
                  }else if(row.type_bayar == "Saldo Warungkoki"){
                    return 'SALDO';
                  } else {
                    return row.type_bayar;
                  }
                  

                }
            },
            { 
                render: function ( data, type, row ) {
                  
                  return '</button><button class="btn btn-success btn-sm" onclick="Lihat('+row.id+')"><i class="fa fa-table"></i></button>';

                }
            }
        ]
    });
});

$('#site').on('change', function () {

    table.ajax.reload();

});

$('#dari').on('change', function () {

    table.ajax.reload();

});

$('#sampai').on('change', function () {

    table.ajax.reload();

});

function Lihat(id){

  $('#view').modal('show');

  $.ajax({
    type: 'POST',
    url: "{{ route('transaksi.viewpenjualan') }}",
    data: {
      '_token': $('input[name=_token]').val(),
      'transaction_id': id,
    },
    success: function(data) {

      var content_data="";
      var no = -1;

      $('#viewname').html(data[0]['user_name']);

      var number_string = data[0]['total'].toString(),
        sisa  = number_string.length % 3,
        rupiah3  = number_string.substr(0, sisa),
        ribuan  = number_string.substr(sisa).match(/\d{3}/g);
          
      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah3 += separator + ribuan.join('.');
      }
      $('#totalbayar').html('Rp. '+rupiah3);

      $('#petugas').html(data[0]['petugas']);
      $('#wilayahnya').html(data[0]['wilayah_name']);
      $('#tanggalnya').html(data[0]['tanggal']);
      $('#link').attr('href','/transactions/invoice?transaction_id='+data[0]['trans_id']);
      var delivery = data[0]['alamat_id'];

      var tots = 0;
      $.each(data, function() {

        no++;
        var produk = data[no]['prod_name'];
        var post = data[no]['post_name'];
        var qty = data[no]['qty'];
        var amount = data[no]['amount'];
        var satuan = amount / qty;


        var number_string = amount.toString(),
          sisa  = number_string.length % 3,
          rupiah  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }


        var number_string = satuan.toString(),
          sisa  = number_string.length % 3,
          rupiah2  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah2 += separator + ribuan.join('.');
        }
        content_data += "<tr>";
        content_data += "<td>"+produk+" "+post+"</td>";
        content_data += "<td>"+rupiah2+"</td>";
        content_data += "<td>"+qty+"</td>";
        content_data += "<td align='right'>"+rupiah+"</td>";
        content_data += "</tr>";

        tots += parseInt(amount);

      });

      if(delivery != null){

        var number_string = data[0]['delivery'].toString(),
          sisa  = number_string.length % 3,
          rupiah4  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah4 += separator + ribuan.join('.');
        }

        var semuanya = parseInt(data[0]['delivery']) + parseInt(tots);

        var number_string = semuanya.toString(),
          sisa  = number_string.length % 3,
          rupiah5  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah5 += separator + ribuan.join('.');
        }

        content_data += "<tr>";
        content_data += "<td colspan='3'>Kirim "+data[0]['delivery_name']+" "+data[0]['delivery_type']+"</td>";
        content_data += "<td align='right'>"+rupiah4+"</td>";
        content_data += "</tr>";

        content_data += "<tr>";
        content_data += "<td colspan='3'><b>TOTAL</b></td>";
        content_data += "<td align='right'>"+ rupiah5 +"</td>";
        content_data += "</tr>";

      } else {

        var number_string = tots.toString(),
          sisa  = number_string.length % 3,
          rupiah6  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah6 += separator + ribuan.join('.');
        }

        content_data += "<tr>";
        content_data += "<td colspan='3'><b>TOTAL</b></td>";
        content_data += "<td align='right'>"+ rupiah6 +"</td>";
        content_data += "</tr>";
      }

      // JIKA ADA DISKON 

      if(data[0]['diskon'] != null){

          var disc = data[0]['diskon'].replace("%", "");
          var hasildiskon = parseInt(tots) * (parseInt(disc) / 100);

          var number_string = hasildiskon.toString(),
          sisa  = number_string.length % 3,
          rupiah7  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah7 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Diskon ("+data[0]['diskon']+")</b></td>";
          content_data += "<td align='right'>"+ rupiah7 +"</td>";
          content_data += "</tr>";

          var totalbayar = parseInt(tots) - parseInt(hasildiskon);

          var number_string = totalbayar.toString(),
          sisa  = number_string.length % 3,
          rupiah8  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah8 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Total Bayar</b></td>";
          content_data += "<td align='right'>"+ rupiah8 +"</td>";
          content_data += "</tr>";

      }

      // === JIKA ADA POTONGAN VOUCHER ===

      if(data[0]['voucher_amount'] != null){

          var vouc = data[0]['voucher_amount'];

          var number_string = vouc.toString(),
          sisa  = number_string.length % 3,
          rupiah9  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah9 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Potongan Voucher ("+ data[0]['vouch_kode'] +")</b></td>";
          content_data += "<td align='right'>- "+ rupiah9 +"</td>";
          content_data += "</tr>";

          var totalbayar2 = parseInt(tots) - parseInt(vouc);

          var number_string = totalbayar2.toString(),
          sisa  = number_string.length % 3,
          rupiah10  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah10 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Total Bayar</b></td>";
          content_data += "<td align='right'>"+ rupiah10 +"</td>";
          content_data += "</tr>";

      }

      // === JIKA ADA POTONGAN VOUCHER PERCENT ===

      if(data[0]['voucher_percent'] != null){

          var vouc = data[0]['voucher_percent'];
          var harga = parseInt(tots) * (vouc / 100);

          var number_string = harga.toString(),
          sisa  = number_string.length % 3,
          rupiah9  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah9 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Potongan Voucher ("+ data[0]['vouch_kode'] +")</b></td>";
          content_data += "<td align='right'>- "+ rupiah9 +"</td>";
          content_data += "</tr>";

          var totalbayar2 = parseInt(tots) - parseInt(harga);

          var number_string = totalbayar2.toString(),
          sisa  = number_string.length % 3,
          rupiah10  = number_string.substr(0, sisa),
          ribuan  = number_string.substr(sisa).match(/\d{3}/g);
            
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah10 += separator + ribuan.join('.');
          }

          content_data += "<tr>";
          content_data += "<td colspan='3'><b>Total Bayar</b></td>";
          content_data += "<td align='right'>"+ rupiah10 +"</td>";
          content_data += "</tr>";

      }


      $('#viewcontent').html(content_data);

    }

  });

}

</script>
</body>
</html>