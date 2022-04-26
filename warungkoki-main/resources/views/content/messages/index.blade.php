@include('layout.head')
<div class="main-content">   
  <div class="container-fluid pb-4 pt-md-8" style="padding-top: 5rem;">
    <div class="row">
      <div class="col">
        <div class="ct-page-title">
          <h1 class="ct-title" id="content">Inbox</h1>
        </div>

        @foreach($inboxes as $inb)

        @php
        $cek = DB::table('inbox_users')
        ->where("inbox_id", $inb->id)
        ->where("user_id", $userid)
        ->first();
        @endphp

        <div onclick="Show({{ $inb->id }})" class="card shadow" style="border-radius:1rem;{{ $cek ? 'background-color: #ccc;' : '' }}">
          <div class="card-body">
            <div class="row">
              <div class="col-3" style="padding-bottom:0px;">
                <div class="icon icon-shape {{ $cek ? 'bg-white' : 'bg-iolo' }} text-white rounded-circle shadow-ss">
                    <i class="fas fa-envelope" style="color: {{ $cek ? '#ccc' : '#ffffff' }}"></i>
                </div>
              </div>
              <div class="col-9" style="padding-left:0px;padding-bottom: 0px;">
                <div {{ $cek ? '' : "class=text-warning" }} style="font-size:15px;"><b>{{ $inb->title }}</b></div>
                <div style="font-size:10px;">{{ substr($inb->desc,0,60) }} ...</div>
              </div>
            </div>
          </div>
        </div>
        <br>
        @endforeach

      </div> 
    </div> 
  </div>
</div>

@include('content.messages.modal')
@include('layout.footer')

<script type="text/javascript">
  
  function Show(id){

    $.ajax({
      type: 'POST',
      url: "{{ route('messages.show') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
      },
      success: function(data) {

        $('#judul').html(data.title.toUpperCase());
        $('#images').html('<img src="/assets/img_messages/'+data.images+'" width="100%">');
        $('#desc').html(data.desc);

        $('#poin').html('');
        
        if(data.poin != null){

            $.ajax({
              type: 'POST',
              url: "{{ route('messages.cekpoin') }}",
              data: {
                  '_token': $('input[name=_token]').val(),
                  'id': data.id,
              },
              success: function(datax) {

                if(datax.status == 0){

                  $('#poin').html('<hr><button style="border-radius:1.5rem;" onclick=Claim('+data.id+','+data.poin+'); id="cliam_id_'+data.id+'" class="btn btn-success btn-block"><img width="8%" src="/assets/content/img/icons/rices.png">&nbsp;&nbsp;<b>'+data.poin+'</b></button>');

                } else if(datax.status == 2){

                  $('#poin').html('<hr><button style="border-radius:1.5rem;" id="cliam_id_'+data.id+'" class="btn btn-danger btn-block" disabled>Kadaluarsa</b></button>');

                } else {

                  $('#poin').html('<hr><button style="border-radius:1.5rem;" id="cliam_id_'+data.id+'" class="btn btn-success btn-block" disabled>Sudah dI Claim</b></button>');

                }
              }

            });
        }

        $('#isinya').modal('show');

      }


    });

  }

  function Closed(){

    $('#isinya').modal('hide');

    setTimeout(function(){ window.location.reload() }, 100);

  }

  function Claim(id,poin){

    $('#cliam_id_'+id).attr("disabled", "disabled");

    $.ajax({
      type: 'POST',
      url: "{{ route('messages.poin') }}",
      data: {
          '_token': $('input[name=_token]').val(),
          'id': id,
          'poin': poin,
      },
      success: function(data) {

        swal({
            title: "Sukses!!",
            text: "Claim Poin Berhasil!",
            icon: "success",
            buttons: false,
            timer: 2000,
        });


      }

    });


  }


</script>

</body>

</html>