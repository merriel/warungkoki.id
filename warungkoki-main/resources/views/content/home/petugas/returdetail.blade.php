@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-warung-3 pt-4 pt-md-8" style="padding-bottom: 15rem;">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <!-- <a href="/users/transaksi"><button type="button" class='btn btn-sm btn-success menusxx'>Kembali</button></a><br><br> -->
        </div>
      </div>
    </div>

    <div class="container-fluid mt--9">
      
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="row justify-content-center">
              <h3>Rincian Transaksi Retur</h3>   
          </div>
          <br>

          @if($saldos->count() == '0')
            <div class="card shadow">
                <div class="card-body">
                  <h5>Waktu Pembelian Anda Sudah Expired.</h5>
                </div>
            </div>
          @else

          <div class="card shadow">
            <div class="card-body">
              <div style="padding-bottom: 16px;">

                <b>Tanggal Pembelian :</b>
                <br>
                <div style="padding-top: 5px;">{{ date('d F Y', strtotime($trans->created_at)) }}</div>
                <hr>

                <b>Toko :</b>
                <br>
                <div style="padding-top: 5px;">@foreach($wilayah as $lokasi) {{ $lokasi->name }} @endforeach</div>
                <hr>

              </div>


              <!-- ========== DETAIL PRODUK YANG DIBELI ========== -->
              <div style="font-size: 12px;"><b>Produk yang di Beli :</b></div><br>
              @php $total=0; @endphp
              @foreach($saldos as $saldo)

                @php
                $total += $saldo->amount;

                @endphp
                <div class="card shadow-ss" style="margin-bottom: 6px;">
                  <div class="card-body">
                      <table width="100%">
                        <tr>
                          <td style="font-size: 11px;" width="65%"><b>{{ $saldo->qty  }} {{ $saldo->prod_name }} {{ $saldo->name }} @ {{ rupiah($saldo->amount / $saldo->qty) }}</b></td>
                          <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->amount)  }}</b></td>
                        </tr>
                      </table>
                  </div>
                </div>
              @endforeach
              @if($trans->alamat_id != null)
              <div class="card shadow-ss" style="margin-bottom: 6px;">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" width="65%"><b>{{ strtoupper($saldo->delivery_name) }} {{ strtoupper($saldo->delivery_type) }}</b></td>
                        <td align="right"  style="font-size: 11px;"><b>{{ rupiah($saldo->delivery)  }}</b></td>
                      </tr>
                    </table>
                </div>
              </div>
              @endif
              <div class="card shadow-ss bg-iolo">
                <div class="card-body">
                    <table width="100%">
                      <tr>
                        <td style="font-size: 11px;" class="text-white">TOTAL</td>
                        @if($trans->alamat_id != null)
                        <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total+$saldo->delivery)  }}</b></td>
                        @else
                        <td align="right" style="font-size: 11px;" class="text-white"><b>{{ rupiah($total)  }}</b></td>
                        @endif
                      </tr>
                    </table>
                </div>
              </div>

              @if($trans->alamat_id != null)
              <hr>
              <b>Dikirim Ke :</b>
              <br>
              <div style="padding-top: 5px;">
                {{ $trans->penerima }} ({{ $trans->nohp }})
                <div>{{ $trans->alamat }}  Kecamatan {{ $trans->district_name }} {{ $trans->regency_name }} Provinsi {{ $trans->prov_name }} {{ $trans->postal_code }}</div>
              </div>
              
              @endif

              @if($retur)
                <hr>
                <div style="font-size: 12px;"><b>Foto Pengajuan Retur :</b></div><br>
                <div class="lihatphotos">
                    <img width="100%" src="/assets/img_retur/{{ $retur->img }}">
                </div>
                <hr>
                <div style="font-size: 12px; padding-bottom: 7px;"><b>Keterangan Pengajuan :</b></div>
                <div style="font-size: 12px;">
                    {{ $retur->ket }}
                </div>
              @endif
              @if($retur->status == "DIPROSES")
              <hr>
              <button class="btn btn-block btn-danger" onclick="Tolak({{ $trans->id }})"><i class="fa fa-times"></i> &nbsp;Tolak Pengajuan</button>
              <button class="btn btn-block btn-success" onclick="Setuju({{ $trans->id }})"><i class="fa fa-check"></i> &nbsp;Setujui Pengajuan</button>
              @else
              <hr>
              <div style="font-size: 12px;padding-bottom: 10px;"><b>Status Pengajuan Retur :</b></div>
                @if($retur->status == "DITOLAK")
                  <div class="text-danger" style="font-size: 14px;"><b>DITOLAK</b></div>
                @else
                  <div class="text-success" style="font-size: 14px;"><b>DISETUJUI</b></div>
                @endif
              <hr>
              <div style="font-size: 12px;padding-bottom: 7px;"><b>Keterangan Admin :</b></div>
              <div style="font-size: 12px;">{{ $retur->ketadmin }}</div>
              @endif
            </div>
          </div><br>
        </div>
      </div>
      @endif
    </div>

    <!-- ===== MODAL ===== -->

    <div class="modal fade" id="setujumodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
          <div class="modal-content">
              <div class="modal-header" style="padding-bottom: 0px;">
                  <div class="col-12" style="padding: 0px;">
                      <div style="font-size: 18px;">
                          <b>Konfirmasi Setuju</b>
                      </div>
                  </div>
              </div>
              <div class="modal-body"  style="padding-bottom: 0px;padding-top: 16px;">
                  <div class="row content" id="content1">
                      
                      <div class="col-12" style="padding-bottom: 0px;">
   
                          <label>Keterangan  :</label>
                          <textarea class="form-control" id="ketsetuju" placeholder="Isikan Alasan mengapa menyetujui pengajuan retur ini" rows="7"></textarea>
                          <input type="hidden" class="idx">
                          <input type="hidden" class="type">
                      </div>
                  </div>
              </div>
              
              <div class="modal-footer tombol" id="tombol1">
                  <table width="100%">
                      <tr>
                          <td>
                              <button type="button" class="btn btn-secondary btn-block ml-auto" data-dismiss="modal">Batal</button> 
                          </td>
                          <td width="5%">
                              &nbsp;
                          </td>
                          <td>
                              <button type="button" onclick="Kirim()" class="btn btn-block btn-success ml-auto menusxx">Kirim</button> 
                          </td>
                      </tr> 
                  </table>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="tolakmodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
          <div class="modal-content">
              <div class="modal-header" style="padding-bottom: 0px;">
                  <div class="col-12" style="padding: 0px;">
                      <div style="font-size: 18px;">
                          <b>Konfirmasi Tolak</b>
                      </div>
                  </div>
              </div>
              <div class="modal-body"  style="padding-bottom: 0px;padding-top: 16px;">
                  <div class="row content" id="content1">
                      
                      <div class="col-12" style="padding-bottom: 0px;">
   
                          <label>Keterangan  :</label>
                          <textarea class="form-control" id="kettolak" placeholder="Isikan Alasan mengapa Menolak pengajuan retur ini" rows="7"></textarea>
                          <input type="hidden" class="idx">
                          <input type="hidden" class="type">
                      </div>
                  </div>
              </div>
              
              <div class="modal-footer tombol" id="tombol1">
                  <table width="100%">
                      <tr>
                          <td>
                              <button type="button" class="btn btn-secondary btn-block ml-auto" data-dismiss="modal">Batal</button> 
                          </td>
                          <td width="5%">
                              &nbsp;
                          </td>
                          <td>
                              <button type="button" onclick="Kirim()" class="btn btn-block btn-success ml-auto menusxx">Kirim</button> 
                          </td>
                      </tr> 
                  </table>
              </div>
          </div>
      </div>
  </div>
  @include('layout.footer')

  <script type="text/javascript">

  function Setuju(id){

    $('.idx').val(id);
    $('.type').val('setuju');
    $('#setujumodal').modal('show');

  }

  function Tolak(id){

    $('.idx').val(id);
    $('.type').val('tolak');
    $('#tolakmodal').modal('show');

  }

  function Kirim(){

    if($('.type').val() == 'tolak'){
      var ket = $('#kettolak').val();
    } else {
      var ket = $('#ketsetuju').val();
    }

    $.ajax({
      type: 'POST',
      url: "{{ route('petugas.returupdate') }}",
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('.idx').val(),
        'type': $('.type').val(),
        'ket': ket,
      },
      success: function(data) {

          if($('.type').val() == 'tolak'){

            $('#tolakmodal').modal('hide');

            swal({
              title: "Success",
              text: "Pengajuan Retur DITOLAK Berhasil",
              icon: "success",
              buttons: false,
              timer: 2000,
            });

          } else {

            $('#setujumodal').modal('hide');

            swal({
              title: "Success",
              text: "Pengajuan Retur DiSetujui Berhasil",
              icon: "success",
              buttons: false,
              timer: 2000,
            });

          }

          setTimeout(function(){ window.location.href = '/petugas/retur'; }, 1500);

      }

    });


  }

  function LihatRetur(id){

      $('#lihatretur').modal('show');

  }

  </script>

</body>

</html>