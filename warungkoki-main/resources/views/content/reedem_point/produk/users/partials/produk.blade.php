<div class="row pop tab-pane fade show active" id="tabs-produk" role="tabpanel" aria-labelledby="tabs-produk">

      <!-- <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab"> -->

            <!-- ===== KATEGORI BBM ====== -->

              
              
              @php $no=0; 

              foreach($bracket_reedem as $bracket){
                $databracket = $bracket['bracket'];
                $datapost = $databracket['posts'];
                
                $i = 0;
               

              @endphp

              <div class="row" style="margin-left:0px;margin-right:0px;display:block;">
                <div class="col">
                  <div class="card card-stats mb-2 mb-lg-0 shadow-ss">
                    <div class="card-body shadow-ss" style="padding-right: 1rem;padding-left: 1rem;padding-bottom: 0px;background-color: #EAFCB8;">
                      
                        <div class="col-12">
                          <div style="font-size: 11px;">
                            {{ strtoupper($databracket['name']) }}
                               
                              <div class='countdown_div' id="div_countdown_{{ $no }}" style="color:red;font-weight:bold;">
                              <input type="hidden" value='{{ $databracket["end_date"] }}' id="time_countdown{{ $no }}">
                              </div> 
                              
                          </div>
                        </div>
                    </div> 
                  </div>
               </div>
              </div>
                
              @php
                $no++;
                foreach($datapost as $post){ 

                  $product = $post['product'];
                  $bracket_product = $post['bracket_product'];

                  $posting = $post['post'];

                  if($no%2==0){
                    $paddings = 'padding-left: 7.5px;';
                  } else {
                    $paddings = 'padding-right: 7.5px;';
                  }

                  $produk_name = $product['name'];
                  
                  $post_name = $posting['name'];
                  $harga_act = $posting['harga_act'];
                  $prod_img = $posting['img'];
                  $id = $posting['id'];
                  $id_bracket_product = $bracket_product['id'];
                   
              @endphp

              <div class="col-6" style="{{ $paddings }}">
                
                <div class="card shadow-sm">
                  <div class="gambar">
                    
                      <img class="card-img-top" width="50px" src="/assets/img_post/{{ $prod_img }}" alt="Card image cap">
 
                  </div>
                  <div class="card-body" style="padding-right: 1rem;padding-left: 1rem;">
                    <h5> <b>{{ $produk_name." ".$post_name }}</b></h5>
                    <div class="progress">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="height:15px;width: {{  $bracket_product['stock'] / $bracket_product['stock_first'] * 100 }}%;" aria-valuenow="{{  $bracket_product['stock'] }}" aria-valuemin="0" aria-valuemax="100">{{  $bracket_product['stock'] .' / '.$bracket_product['stock_first'] }}</div>
                  </div>

                    <div style="padding-top: 8px;">
                    </div>
                    <hr>
                    

                    <button class="btn btn-sm btn-block btn-kuning addKeranjang" data-id_bracket_product="{{  $id_bracket_product  }}" data-id="{{  $id  }}"  type="button">
                    {{ butir_padi($harga_act) }} <img width="25px;" src="/assets/content/img/icons/padi.png">
                   </button>
                              
                  </div>
                </div>
              </div> 
                  @php } @endphp
                @php } @endphp 
          <!-- </div>
      </div> -->

    </div>

<script type="text/javascript">
  
</script>