@include('layout.head')
  <div class="main-content">
    <!-- Header -->
    <div class="container-fluid pb-4 pt-4 pt-md-8">
          <!-- Card stats -->
          <div class="row">
            <div class="col">
<!--               <a href="/home"><button type="button" id="back" class='btn btn-sm btn-success menusxx'>Back</button></a> -->
              <div class="ct-page-title">
                <h1 class="ct-title" id="content">Other Applications</h1>
              </div>
            </div>
          </div>
          <div class="row">
            <table width="100%">
              <tr>
                <td width="4%;"></td>
                <td width="28%;">
                  <div class="card shadow-ss">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td align="center"><i class="fa fa-motorcycle" style="font-size: 30px; color: #01497f"></i></td>
                        </tr>
                        <tr>
                          <td height="7px"></td>
                        </tr>
                        <tr>
                          <td align="center"><h6><b>Smart Service</b></h6></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </td>
                <td width="4%;"></td>
                <td width="28%;">
                  <div class="card shadow-ss">
                    <a href="/working-space"><div class="card-body menusxx">
                      <table width="100%" border="0">
                        <tr>
                          <td align="center"><i class="fa fa-space-shuttle" style="font-size: 30px; color: #01497f"></i></td>
                        </tr>
                        <tr>
                          <td height="7px"></td>
                        </tr>
                        <tr>
                          <td align="center"><h6><b>Smart Workspace</b></h6></td>
                        </tr>
                      </table>
                    </div></a>
                  </div>
                </td>
                <td width="4%;"></td>
                <td width="28%;">
                  <div class="card shadow-ss">
                    <div class="card-body">
                      <table width="100%" border="0">
                        <tr>
                          <td align="center"><i class="fa fa-thermometer-full" style="font-size: 30px; color: #01497f"></i></td>
                        </tr>
                        <tr>
                          <td height="7px"></td>
                        </tr>
                        <tr>
                          <td align="center"><h6><b>Smart Fueling</b></h6></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </td>
                <td width="4%;"></td>
              </tr>
            </table>
            
          </div>

              </div>
            </div>    
          </div>
      @include('layout.footer')
      @include('script.home')
</body>
</html>