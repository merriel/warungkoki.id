@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-4 pt-md-8">
          <!-- Card stats -->
          <a href="/home"><button type="button" class='btn btn-sm btn-success'>Kembali</button></a><br><br>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="type">
                  <span class="badge badge-pill badge-primary">{{ $postnews->type }}</span>
                </div>
                <img class="card-img-top" src="{{ asset('assets/img_post/') }}/{{ $postnews->imgname }}" alt="Card image cap">
                <div class="love">
                  
                  <div class="circle3"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                  
                </div>
                <div class="card-body">
                  <h2> <b>{{ $postnews->name }}</b></h2>
                 <h5 style="text-decoration:line-through;">{{ $postnews->type == 'Products' ? '' : rupiah($postnews->harga_crt) }}</h5>
                  <table width="100%">
                    <tr>
                      <td align="left"><h2 style="color: #fb6340;"><b>{{ rupiah($postnews->harga_act) }}</b></h2></td>
                      <td align="right"><a href="/login"><button class="btn btn-kuning" type="button">BELI {{ $postnews->type == 'Products' ? 'PRODUK' : 'PAKET' }}</button></a></td>
                    </tr>
                  </table>
                  <hr>
                    <h4><b>Penjual :</b></h4>
                    <table width="100%" >
                      <tr>
                        <td rowspan="3" width="30%"><img class="shadow" width="100%" src="/assets/img_company/{{ $postnews->photo }}"></td>
                        <td width="5%"></td>
                        <td style="font-size: 16px;"><a href="/company/profilehome/{{ $postnews->wilayah_id }}"><b>{{ $postnews->wilayah_name }}</b></a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><span class="badge badge-pill badge-success">{{ $postnews->regency_name }}</span></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><h6>Sudah Menjual Lebih dari 100 Produk</h6></td>
                      </tr>
                    </table>
                    <br>
                    <table width="100%">
                      <tr align="center">
                        <td>
                            <a href="/login"><button class="btn btn-info btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Follow</button></a>
                        </td>
                        <td><a href="/login"><button class="btn btn-success btn-sm btn-block" type="button"><i class="fa fa-envelope"></i> Messages</button></a></td>
                      </tr>
                    </table>
                  <hr>
                  @php
                    $banyak = DB::table('diskusi')
                    ->where('post_id', $postid)
                    ->count();
                  @endphp
                  <table>
                    <tr>
                      <td><button id="detail" class="btn btn-iolo menus" type="button" style="font-size: 10px;">Detail</button></td>
                      <td><button id="diskusi" class="btn btn-kuning menus" type="button" style="font-size: 10px;">Diskusi <b>({{ $banyak }})</b></button></td>
                    </tr>
                  </table>
                  <br>

                  <!-- ==== Produk Detail ===== -->
                  <div id="produkdetails" class="contentmenu" style="display: block;">
                    <h4><b>Produk Detail :</b></h4>
                    
                    <h6 align="justify">{{ $postnews->desc }}}</h6><hr>
                    @if($postnews->type != 'Products')
                    <div style="font-size: 11px;padding-bottom: 5px;"><b>Produk yang di Dapat :</b></div>
                    <table width="100%" id="customers">
                      <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                      </tr>
                    @foreach($postproducts as $postproduct)
                      <tr>
                        <td align="left"><h5>{{ $postproduct->name }}</h5></td>
                        @if($postproduct->qty >= 1000)
                        <td align="right">{{ rupiah($postproduct->qty) }}</td>
                        @else
                        <td align="right">{{ $postproduct->qty }} Kali</td>
                        @endif
                      </tr>
                    @endforeach
                    </table>
                    <hr>
                    @endif

                    <div style="font-size: 11px;padding-bottom: 5px;"><b>Penukaran dapat dilakukan di :</b></div>
                    <table width="100%" id="customers">
                      <tr>
                        <th>{{ $postnews->wilayah_name }}</th>
                      </tr>
                      <tr>
                        <td>{{ $postnews->alamat }} - {{ $postnews->regency_name }}</td>
                      </tr>
                    </table>
                  </div>
                  <!-- ==== End Of Product Detail ===== -->

                  <!-- ==== Diskusi Detail ===== -->
                  <div id="diskusidetail" class="contentmenu" style="display: none;">
                    <a href="/login"><button type="button" class='btn btn-sm btn-success'><i class="fa fa-plus"></i>Tambah Dikusi</button></a>
                    <br><br>
                      @if($diskusis->count() == '0')
                        <div class="alert alert-secondary shadow" role="alert">
                          <h6>Belum ada Diskusi untuk Saat ini!</h6>
                        </div>
                      @else
                      @foreach($diskusis as $diskusi)
                      <div class="alert alert-secondary shadow" role="alert">
                        <table width="100%">
                          <tr>
                            <td width="15%" rowspan="2">
                              <img width="100%" src="/assets/content/img/theme/team-1-800x800.jpg">
                            </td>
                            <td width="5%"></td>
                            <td><b style="font-size: 13px">{{ $diskusi->user_name }}</b></td>
                          </tr>
                          <tr>
                            <td width="5%"></td>
                            <td style="font-size: 9px;">{{ date('d F Y', strtotime($diskusi->created_at)) }} Pukul {{ date('H:i', strtotime($diskusi->created_at)) }}</td>
                          </tr>
                          <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td style="font-size: 9px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td style="font-size: 12px;">{{ $diskusi->desc }} </td>
                          </tr>
                        </table>
                        @php
                          $komentars = DB::table('komentar')
                          ->select("komentar.*", "users.name as user_name")
                          ->join("users", "komentar.user_id", "=", "users.id")
                          ->where('diskusi_id', $diskusi->id)
                          ->get();
                        @endphp

                        @foreach($komentars as $komentar)
                        <br>
                        <table width="100%">
                          <tr>
                            <td width="15%" rowspan="3">
                              
                            </td>
                            <td width="15%" rowspan="2">
                              <img width="100%" src="/assets/content/img/theme/team-1-800x800.jpg">
                            </td>
                            <td width="5%"></td>
                            <td><b style="font-size: 13px">{{ $komentar->user_name }}</b></td>
                          </tr>
                          <tr>
                            <td width="5%"></td>
                            <td style="font-size: 9px;">{{ date('d F Y', strtotime($komentar->created_at)) }} Pukul {{ date('H:i', strtotime($komentar->created_at)) }}</td>
                          </tr>
                          <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td style="font-size: 4px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                            <td style="font-size: 12px;">{{ $komentar->desc }} </td>
                          </tr>
                        </table>
                        @endforeach
                        <hr>
                        <div align="center">
                          <button type="button" onclick="Komentar({{ $diskusi->id }})" class='btn btn-sm btn-iolo'>Balas Diskusi</button>
                        </div>
                      </div>
                      @endforeach
                      @endif
                  </div>
                  <!-- ==== End Of Diskusi Detail ===== -->

                </div>
              </div>
            </div>    
          </div>
      @include('layout.footer')  
<script type="text/javascript">
  
    $('#detail').on('click', function () {

        $('.menus').attr("class","btn btn-kuning menus");
        $('#detail').attr("class","btn btn-iolo menus");

        $('.contentmenu').attr("style","display: none;");
        $('#produkdetails').attr("style","display: block;");

      });

    $('#diskusi').on('click', function () {

        $('.menus').attr("class","btn btn-kuning menus");
        $('#diskusi').attr("class","btn btn-iolo menus");

        $('.contentmenu').attr("style","display: none;");
        $('#diskusidetail').attr("style","display: block;");

      });

</script>    
</body>

</html>