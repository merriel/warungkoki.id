<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page { margin: 0px 0px 0px 0px }

            

            .code {
              
              font-size: 18px;
              font-weight: bold;
            }

            .button {
              background-color: white; /* Green */
              border: none;
              color: black;
              padding: 15px 32px;
              text-align: center;
              font-size: 16px;
              border-radius: 1.5rem;
              font-weight: bold
            }
        </style>
    </head>
    <body style="font-family:'Arial', Helvetica, sans-serif ; font-size:12px;">
        <!-- Define header and footer blocks before your content -->
        


        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
          @foreach($vouchers as $vouc)
          <div style="padding-bottom: 5px;">
            <table width="100%" border="0" style="background-color: @if($vouc->voucher_id == 1 || $vouc->voucher_id == 3) #ee2e23; @else #fdcd00; @endif" >
              <tr>
                <td colspan="2">
                  <img style="padding-bottom: 0px;" width="100%" src="https://tomxperience.id/assets/img_vouchers/{{ $vouc->img }}">
                </td>
              </tr>
              <tr>
                <td>
                  <div style="padding-left: 18px;">
                    <button class="button">
                      Code Voucher Anda : {{ strtoupper($vouc->kode) }}
                    </button>
                  </div>
                </td>
                <td width="70%">
                  <div style="font-size: 10px; padding-right:15px; color: @if($vouc->voucher_id == 1 || $vouc->voucher_id == 3) white; @else black; @endif">
                    <table width="100%">
                      <tr>
                        <td>Berlaku Sampai</td>
                        <td>:</td>
                        <td><b>{{ date('d F Y', strtotime($vouc->sampai)) }}</b></td>
                      </tr>
                      <tr>
                        <td>Lokasi Penggunaan</td>
                        <td>:</td>
                        <td>Shell BSD1, Shell BSD4, Shell Karawaci, Shell Puspitek, Shell Gading Serpong</td>
                      </tr>
                    </table>
                    
                  </div>
                </td>
              </tr>
            </table>
          </div>
          @endforeach

         <!--  -->
          </div>
        </main>
    </body>
</html>
