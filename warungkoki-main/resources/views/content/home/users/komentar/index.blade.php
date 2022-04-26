@include('layout.head')
  <div class="main-content">   
    <div class="container-fluid pb-4 pt-3 pt-md-8">
      <div class="row">
        <div class="col">
          <a href="/users"><button type="button" id="back" class='btn btn-sm btn-success'>Back</button></a>
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
            @if($komentars->count() == '0')
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

            @foreach($komentars as $komentar)

            @php

              $comments = DB::table('komentar')
              ->where([
                  ['diskusi_id', '=', $komentar->diskusi_id],
                  ['read', '=', '0'],
                  ['user_id', '!=', $userid],
              ])
              ->count();

              if($comments == '0'){
                $colortxt = '';

                $koment = DB::table('komentar')
                ->where([
                    ['diskusi_id', '=', $komentar->diskusi_id],
                    ['read', '=', '1'],
                ])
                ->orderBy("id","desc")
                ->first();

              } else {
                $colortxt = 'text-white';
              }

            @endphp

            @if($comments == '0')
              <div class="card shadow" onclick="View({{ $komentar->diskusi_id }})">
            @else
              <div class="card bg-iolo shadow" onclick="Read({{ $komentar->diskusi_id }})">
            @endif
                <div class="card-body">
                  <table width="100%">
                    <tr>
                      <td width="17%" rowspan="2">
                        <img width="100%" src="/assets/img_post/{{ $komentar->img }}">
                      </td>
                      <td width="6%"></td>
                      <td class="{{ $colortxt }}" style="font-size: 15px;"><b>{{ $komentar->post_name }} ({{ $komentar->post_type }})</b></td>
                    </tr>
                    @if($comments == '0')
                    <tr>
                      <td></td>
                      <td style="font-size: 11px;">{{ $koment->desc }}</td>
                    </tr>
                    @else 
                    <tr>
                      <td></td>
                      <td class="text-white" style="font-size: 11px;"><span class="badge badge-secondary"> {{ $comments }} Pesan Baru</span></td>
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
        url: "{{ route('bacadiskusiusers') }}",
        data: {
            '_token': $('input[name=_token]').val(),
            'id': id,
        },
        success: function(data) {

          setTimeout(function(){ window.location.href = '/users/komentar/'+id; }, 10);

        }

      });

    }

    function View(id){

      setTimeout(function(){ window.location.href = '/users/komentar/'+id; }, 10);

    }
    

</script>
</body>

</html>