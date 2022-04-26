==========================

  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-7 pt-md-8">
          <!-- Card stats -->
          <table width="100%">
            <tr>
              <!-- <td align="left">
                <a href="/users"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a>
              </td> -->
              <td align="left">
                <button type="button" onclick="onShare();" id="share" class='btn btn-sm btn-primary'><i class="fa fa-share"></i>  Share Produk ini</button>
              </td>
            </tr>
          </table>
          <br>
          <!-- <div id="contentshare" style="display: none;">
            <table width="100%">
              <tr>
                <td>
                  <input type="text" id="myInput" class="form-control" value="{{ Request::fullUrl() }}" readonly>
                </td>
                <td width="20%">
                  <button type="button" onclick="myFunction()" class='btn btn-warning'>Copy</button>
                </td>
              </tr>
            </table>
            <br>
          </div> -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="type">
                  <span class="badge badge-pill badge-primary">{{ $postnews->type }}</span>
                </div>
                <div class="gambar">
                  <img class="card-img-top" id="imgpost" src="{{ asset('assets/img_post/') }}/{{ $postnews->img }}" alt="Card image cap">
                </div>
                  
                <div class="card-body">
                  <table width="100%">
                    <tr>
                      <td align="left">
                        <h2> <b>{{ $postnews->prod_name }}</b> <b id="text">{{ $postnews->name }}</b></h2>
                      </td>
                      @if($tour->detailprod != 1)
                      <td align="right" class="pop" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Suka Produk ini, Jadikan Favorite disini">
                      @else
                      <td align="right">
                      @endif
                        @if(!$cekfav)
                        <div class="circle3 shadow" onclick="Favorite({{ $postnews->id }})"><i class="ni ni-favourite-28" style="color: #fff"></i></div>
                        @else
                        <div class="circle3 shadow" onclick="NotFavorite({{ $postnews->id }})"><i class="ni ni-favourite-28" style="color: #f5365c"></i></div>
                        @endif
                      </td>
                    </tr>
                  </table>
                 
                
                 <h5 style="text-decoration:line-through;">{{ $postnews->type == 'Products' ? '' : rupiah($postnews->harga_crt) }}</h5>
                  <table width="100%">
                    <tr>
                      <td align="left"><h2 style="color: #fb6340;"><b id="harga">{{ rupiah($postnews->harga_act) }}</b></h2></td>
                      <td align="right">
                        @if($tour->detailprod != 1)
                        <button class="btn btn-kuning pop" id="beli" onclick="Beli({{ $postnews->id }})" type="button"  data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Kamu bisa beli produk ini disini!">BELI {{ $postnews->type == 'Products' ? 'PRODUK' : 'PAKET' }}</button>
                        @else
                        <button class="btn btn-kuning" id="beli" onclick="Beli({{ $postnews->id }})" type="button">BELI {{ $postnews->type == 'Products' ? 'PRODUK' : 'PAKET' }}</button>

                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left">
                        @if($postnews->deliver == 'yes')
                        <span class="badge badge-pill badge-warning" style="font-size: 8px;"><i class="fa fa-truck"></i> Delivery</span>
                        @endif

                        @if($postnews->po == 'yes')
                        <span class="badge badge-pill badge-info" style="font-size: 8px;"><i class="fa fa-gift"></i> PO</span>
                        @endif
                      </td>
                    </tr>
                  </table>
                  
                  @php
                    $varian = DB::table('posts')
                    ->select("posts.name","posts.img","posts.id")
                    ->join("product", "posts.product_id", "=", "product.id")
                    ->join("users", "posts.user_id", "=", "users.id")
                    ->where([
                      ['users.wilayah_id', '=', $postnews->wilayah_id],
                      ['posts.product_id', '=', $postnews->prod_id],
                      ['posts.active', '=', 'Y'],
                      ['posts.deleted_at', '=', null],
                    ])
                    ->get();

                  @endphp

                  @if($varian->count() > 1)
                  <hr>
                  <h4><b>Pilih Varian :</b></h4>
                  @if($tour->detailprod != '1')
                  <div class="row pop" style="padding-top: 12px;" data-container="body" data-toggle="popover" data-color="success" data-placement="bottom" data-content="Pilih Varian Produk yang Kamu suka disini">
                  @else
                  <div class="row" style="padding-top: 12px;">
                  @endif
                   @foreach($varian as $var)
                      @php
                      if($var->id != $postnews->id){
                        $notselect = 'opacity: 0.6;';
                      } else {
                        $notselect = '';
                      }

                      @endphp
                      <div class="col-4" onclick="Varian({{ $var->id }})">
                        <div class="card shadow-ss">
                          <div class="card-body" style="padding: 0.5px;">
                             <img id="var_{{ $var->id }}" class="vars" style="{{ $notselect  }}" width="100%" src="{{ asset('assets/img_post/') }}/{{ $var->img }}">
                          </div>
                        </div>
                      </div>

                   @endforeach
                  </div>
                  @endif
                  <hr>
                    <h4><b>Penjual :</b></h4>
                    <table width="100%" >
                      <tr>
                        <td rowspan="3" width="30%"><img class="shadow-ss" width="100%" src="/assets/img_company/{{ $postnews->photo }}"></td>
                        <td width="5%"></td>
                        <td style="font-size: 16px;"><a href="#"><b style="color: #33b5e5;">{{ $postnews->wilayah_name }}</b></a></td>
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
                    @php
                      $ada = DB::table('follow')
                      ->where([
                        ['wilayah_id', '=', $postnews->wilayah_id],
                        ['user_id', '=', $userid],
                      ])
                      ->first();
                    @endphp
                    <table width="100%">
                      <tr align="center">
                        <td>
                          @if(!$ada)
                            @if($tour->detailprod != '1')
                            <button onclick="Follow({{ $postnews->wilayah_id }})" class="btn btn-info btn-sm btn-block pop" type="button" data-container="body" data-toggle="popover" data-color="success" data-placement="top" data-content="Follow Toko ini disini"><i class="fa fa-plus"></i> Follow</button>
                            @else
                            <button onclick="Follow({{ $postnews->wilayah_id }})" class="btn btn-info btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Follow</button>
                            @endif
                          @else
                            <button onclick="Unfollow({{ $postnews->wilayah_id }})" class="btn btn-warning btn-sm btn-block" type="button"><i class="fa fa-plus"></i> Unfollow</button>
                          @endif
                        </td>
                        <td><button class="btn btn-success btn-sm btn-block" type="button"><i class="fa fa-envelope"></i> Messages</button></td>
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
                      <td><button id="detail" class="btn btn-kuning menus" type="button" style="font-size: 10px;">Detail</button></td>
                      <td>
                        @if($tour->detailprod != 1)
                        <button id="diskusi" class="btn btn-secondary menus pop" type="button" style="font-size: 10px;" data-container="body" data-toggle="popover" data-color="success" data-placement="left" data-content="Mau Diskusi disini!">Diskusi <b>({{ $banyak }})</b></button>
                        @else
                        <button id="diskusi" class="btn btn-secondary menus" type="button" style="font-size: 10px;">Diskusi <b>({{ $banyak }})</b></button>
                        @endif
                      </td>
                    </tr>
                  </table>
                  <br>

                  <!-- ==== Produk Detail ===== -->
                  <div id="produkdetails" class="contentmenu" style="display: block;">
                    <h4><b>Produk Detail :</b></h4>
                    
                    <div align="justify" style="font-size: 12px;">{{ $postnews->desc }}</div><hr>
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

                    <div class="card shadow-ss" style="background-color: #fb6340;">
                      <div class="card-body">
                        <table>
                          <tr>
                            <td>
                              <i class="fa fa-exclamation-triangle" style="font-size: 24px;color: white;"></i>
                            </td>
                            <td width="3%">&nbsp;</td>
                            <td>
                                <div style="font-size: 13px;" class="text-white">
                                  <b>PERHATIAN!!</b>
                                </div>
                                <div style="font-size: 10px;" class="text-white">
                                  barang ini hanya bisa di ambil/reedem di <b>{{ $postnews->wilayah_name }}</b>, {{ $postnews->alamat }} - {{ $postnews->regency_name }}
                                </div>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>

                    
                  </div>
                  <!-- ==== End Of Product Detail ===== -->


                  <!-- ==== Diskusi Detail ===== -->
                  <div id="diskusidetail" class="contentmenu" style="display: none;">
                    <button type="button" id="tambahdiskusi" class='btn btn-sm btn-success'><i class="fa fa-plus"></i>Tambah Dikusi</button>
                    <br><br>
                      @if($diskusis->count() == '0')
                        <div class="alert alert-secondary shadow-ss" role="alert">
                          <h6>Belum ada Diskusi untuk Saat ini!</h6>
                        </div>
                      @else
                      @foreach($diskusis as $diskusi)
                      <div class="alert alert-secondary shadow-ss" role="alert">
                        <table width="100%">
                          <tr>
                            <td width="15%" rowspan="2">
                              <img width="100%" src="/assets/content/img/theme/noname.png">
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
                              <img width="100%" src="/assets/content/img/theme/noname.png">
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
                      <hr>
                      @endforeach
                      @endif
                  </div>

                  <!-- ==== End Of Diskusi Detail ===== -->

                </div>
              </div>
            </div>    
          </div>