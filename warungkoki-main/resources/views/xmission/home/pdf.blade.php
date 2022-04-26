<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page { margin: 0px 0px 0px 0px }

            td, tr, img  { padding: 0px; margin: 0px; border: none; }
            table { border-collapse: collapse; }


        </style>
        <style>
        * {
          box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
          float: left;
          width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }
        </style>
    </head>
    <body style="font-family:'Arial', Helvetica, sans-serif ; font-size:12px;">
        <!-- Define header and footer blocks before your content -->
        


        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
          @foreach($vouchers as $vouc)

              @if($vouc->id % 2 == 0)
              <table width="100%">
                <tr>
                    <td width="50%">
                        <table width="100%">
                          <tr>
                            <td width="100%">
                              <img width="100%" src="https://tomxperience.id/assets/img_vouchers/voucher{{ $vouc->voucher_id }}-1.jpg">
                            </td>
                          </tr>
                          <tr>
                            <td>
                            <table width="100%">
                              <tr>
                                <td width="71%">
                                  <img width="100%" src="https://tomxperience.id/assets/img_vouchers/voucher{{ $vouc->voucher_id }}-2.jpg">
                                </td>
                                <td bgcolor="#f2f9f7">
                                  <div style="font-size: 9px;padding-bottom: 2px;padding-left: 14px;">Kode Voucher Anda :</div>
                                  <div style="font-size: 22px;color: #11cdef;padding-left: 14px;"><b>{{ $vouc->kode }}</b></div>
                                </td>
                              </tr>
                            </table>                           
                            </td>
                          </tr>
                        </table>
                    </td>
                    <td width="50%">

                      @php

                        $id = $vouc->id+1; 

                        $v = DB::table('voucher_details')
                        ->select("voucher_details.*")
                        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                        ->where('voucher_details.id', $id)
                        ->first();

                      @endphp
                      <table width="100%">
                          <tr>
                            <td width="100%">
                              <img width="100%" src="https://tomxperience.id/assets/img_vouchers/voucher{{ $vouc->voucher_id }}-1.jpg">
                            </td>
                          </tr>
                          <tr>
                            <td>
                            <table width="100%">
                              <tr>
                                <td width="71%">
                                  <img width="100%" src="https://tomxperience.id/assets/img_vouchers/voucher{{ $vouc->voucher_id }}-2.jpg">
                                </td>
                                <td bgcolor="#f2f9f7">
                                  <div style="font-size: 9px;padding-bottom: 2px;padding-left: 14px;">Kode Voucher Anda :</div>
                                  <div style="font-size: 22px;color: #11cdef;padding-left: 14px;"><b>{{ $v ? $v->kode : 0 }}</b></div>
                                </td>
                              </tr>
                            </table>                           
                            </td>
                          </tr>
                        </table>
                    </td>
                </tr>
              </table>
              @endif
          @endforeach
        </main>
    </body>
</html>
