@include('layout.head')
<style type="text/css">
  input[type=checkbox]
  {
    -webkit-appearance:checkbox;
  }
</style>
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-7 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          <button type="button" onclick="Cetak();" class='btn btn-sm btn-info'>
            <i class="fa fa-download"></i>&nbsp;Cetak Voucher
          </button>
            <div class="ct-page-title">
              <h1 class="ct-title" id="content">Master Voucher</h1>
            </div>
            <button class="btn btn-sm btn-success" onclick="Tambah()" type="button"><i class="fa fa-plus"></i>Tambah Voucher</button>
            <input type="hidden" value="{{ $date }}" id="tanggal">
           <hr>
           <table id="customers" class="datatables">
              <thead>
                <tr>
                  <th style="display: none;">ID</th>
                  <th>Kode</th>
                  <th>Status</th>
                  <th width="10%">Opsi</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
           </table> 
        </div> 
      </div> 
    </div>
  </div>
  @include('content.voucher.modal')
  @include('layout.footer')
</body>
<script type="text/javascript">
  
  var table = "";
  $(function() {

    var tanggal = $('#tanggal').val();

    table = $('.datatables').DataTable({
      pageLength: 20,
      processing: true,
      serverSide: true,
      columnDefs: [
          {
              "targets": [ 0 ],
              "visible": false
          }
      ],
      order: [[ 0, 'desc' ]],
      ajax:{
           url: "{{ route('voucher.data') }}",
           dataType: "json",
           type: "GET",
      },
      columns: [
        { data: 'id', name: 'id' },
        { data: 'kode', name: 'kode' },
        { 
            render: function ( data, type, row ) {

              if(row.status == 'selesai'){
                return '<div style="color:red;"><b>Selesai</b></div>';
              } else {

                if(tanggal >= row.dari && tanggal <= row.sampai){
                  return '<div style="color:green;"><b>Available</b></div>';
                } else {
                  return '<div style="color:red;"><b>Kadaluarsa</b></div>';
                }

              }
 
            }
        },
        { 
            render: function ( data, type, row ) {

              if(row.status == 'selesai'){
                return '<button disabled class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
              } else {

                if(tanggal >= row.dari && tanggal <= row.sampai){
                  return '<button onclick="Delete('+row.id+')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                } else {
                  return '<button disabled class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                }

              }
 
            }
        }
      ]
    });
  });

  $(function() {

    var tanggal = $('#tanggal').val();

    table = $('.datatables22').DataTable({
      pageLength: 30,
      processing: true,
      serverSide: true,
      searching: false, 
      paging: false, 
      info: false,
      columnDefs: [
          {
              "targets": [ 0 ],
              "visible": false
          }
      ],
      order: [[ 0, 'desc' ]],
      ajax:{
           url: "{{ route('voucher.pilih') }}",
           dataType: "json",
           type: "GET",
      },
      columns: [
        { data: 'id', name: 'id' },
        { 
            render: function ( data, type, row ) {
                return '<div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" value="'+row.id+'" class="voucher"></div></div>';
            }
        },
        { data: 'kode', name: 'kode' },
        { data: 'name', name: 'name' },
      ]
    });
  });

  function Tambah(){

    $('#tambah').modal('show');

  }

  function Simpan(){

      var empty = false;
      $('input.isi, select.isi').each(function() {
          if ($(this).val() == '') {
              empty = true;
          }
      });
      if (empty) { 
          swal({
              text: "Isian Tidak Boleh Kosong!",
              icon: "error",
              buttons: false,
              timer: 2000,
          });

      } else {

        $.ajax({
          type: 'POST',
          url: "{{ route('voucher.store') }}",
          data: {
            '_token': $('input[name=_token]').val(),
            'voucher_id': $('#voucher_id').val(),
            'banyak': $('#banyak').val(),
            'dari': $('#dari').val(),
            'sampai': $('#sampai').val(),
          },
          success: function(data) {

              $('#new').modal('hide');

              swal({
                title: "Success",
                text: "Voucher Berhasil Dibuat",
                icon: "success",
                buttons: false,
                timer: 2000,
              });

              setTimeout(function(){ window.location.href = '/voucher'; }, 2000);

          }

        });

      }

    }

    function Delete(id){

      $('#iddel').val(id);

      $('#delete').modal('show');

    }

    function YakinDelete(){

      $('#delete').modal('hide');

      var ids = $('#iddel').val();

      $.ajax({
        type: 'POST',
        url: "{{ route('voucher.delete') }}",
        data: {
          '_token': $('input[name=_token]').val(),
          'id': ids,
        },
        success: function(data) {

          swal({
              title: "Success",
              text: "Voucher Berhasil di Hapus!",
              icon: "success",
              buttons: false,
              timer: 2000,
          });

          setTimeout(function(){ window.location.href = '/voucher'; }, 2000);

        }

      });

    }

    function Cetak(){

      $('#cetak').modal('show');

    }

    function Download(){

      var tes = $('.voucher:checkbox:checked').val();

      var voucher = [];

      $('.voucher').each(function(){
          if ($(this).is(":checked")){
            voucher.push($(this).val());
          }
      });

      setTimeout(function(){ window.location.href = 'voucher/print?id='+voucher+''; }, 1000);

    }

</script>
</html>