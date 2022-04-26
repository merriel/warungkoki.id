@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/principle"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
          <div class="ct-page-title">
            <h1 class="ct-title" id="content">Pesan & Diskusi</h1>
          </div>

          <table>
            <tr>
              <td><button id="diskusi" class="btn btn-iolo menus" type="button" style="font-size: 12px;">Diskusi</button></td>
              <td>&nbsp;</td>
              <td><button id="pesan" class="btn btn-kuning menus" type="button" style="font-size: 12px;">Pesan</button></td>
            </tr>
          </table>
          <br>
          <div id="contentdiscussion">
            @if($disscuss->count() == '0')
              <div class="card shadow">
              <div class="card-body">
                <table width="100%">
                  <tr>
                    <td width="17%" rowspan="2">
                       <h5><b> Tidak Ada Diskusi untuk Saat ini</b></h5>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <br>
            @else

            @foreach($disscuss as $disscus)

              @if($disscus->read == '0')
              <div class="card bg-iolo shadow" onclick="Read({{ $disscus->id }})">
              @else
              <div class="card shadow" onclick="View({{ $disscus->id }})">
              @endif

              @php

                if($disscus->read == '0'){
                  $colortext = 'text-white';

                  $comments = DB::table('komentar')
                  ->where([
                      ['diskusi_id', '=', $disscus->id],
                      ['read', '=', '0'],
                  ])
                  ->count();

                  if($comments == '0'){

                    $data = '1';

                  } else {

                    $data = $comments;

                  }

                } else {

                  $colortext = '';

                  $comments = DB::table('komentar')
                  ->where([
                      ['diskusi_id', '=', $disscus->id],
                      ['read', '=', '0'],
                  ])
                  ->count();

                  if($comments == '0'){

                    $koment = DB::table('diskusi')
                    ->where("id", $disscus->id)
                    ->first();

                    $datakoment = $koment->desc;

                  } else {

                    $koment = DB::table('komentar')
                    ->where("diskusi_id", $disscus->id)
                    ->orderBy("id", "desc")
                    ->first();

                    $datakoment = $koment->desc;

                  }

                }

              @endphp
                <div class="card-body">
                  <table width="100%">
                    <tr>
                      <td width="17%" rowspan="2">
                        <img width="100%" src="/assets/img_post/{{ $disscus->img }}">
                      </td>
                      <td width="6%"></td>
                      <td class="{{ $colortext }}" style="font-size: 15px;"><b>{{ $disscus->post_name }} ({{ $disscus->post_type }})</b></td>
                    </tr>
                    @if($disscus->read == '0')
                    <tr>
                      <td></td>
                      <td class="text-white" style="font-size: 11px;"><span class="badge badge-secondary">{{ $data }} Pesan Baru</span></td>
                    </tr>
                    @else
                    <tr>
                      <td></td>
                      <td style="font-size: 11px;">{{ $datakoment }}</td>
                    </tr>
                    @endif
                    
                  </table>
                </div>
              </div>
            <br>
            @endforeach

            @endif
          </div>
        </div> 
      </div> 
    </div>
  </div>
      @include('layout.footer')
<script type="text/javascript">
    
    function Read(id){

      $.ajax({
        type: 'POST',
        url: "{{ route('bacadiskusi') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
        },
        success: function(data) {

          setTimeout(function(){ window.location.href = '/principle/komentar/'+id; }, 10);

        }

      });

    }

    function View(id){

      setTimeout(function(){ window.location.href = '/principle/komentar/'+id; }, 10);

    }

</script>
</body>

</html>