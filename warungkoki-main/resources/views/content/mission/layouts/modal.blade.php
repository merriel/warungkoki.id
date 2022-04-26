@for($i = 0;$i < $step_size;$i++)
<div class="modal fade bs-example-modal-lg modal-mission-detail" id="modal-mission-detail-{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> MISSION {{ $i + 1 }}</h4>
      </div>
      <div class="modal-body">
        <img src="assets/img_post/{{ $step[$i]['product']['img']  }}" style="min-width:250px; width: 250px;margin-left: 20%;" />
        <p style="font-size:1.5rem;">{{ $step[$i]['desc'] }}</p>
      </div>
      <div class="modal-footer">
        @if($i == 0) 
        <a type="button" class="btn btn-success"  href="users/detail/{{ $step[$i]['id_product'] }}">Beli</a>
        @endif
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
@endfor

<div class="modal fade bs-example-modal-lg modal-mission-reward" id="modal-mission-reward" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> MISSION REWARD</h4>
      </div>
      <div class="modal-body">
        <img src="assets/img_post/{{ $reward['product']['img'] }}" style="min-width:250px; width: 250px;margin-left: 20%;" />
      </div>
      <div class="modal-footer">
        @if($i == 0) 
        <a type="button" class="btn btn-success"  href="users/detail/{{ $reward['id_product'] }}">Claim</a>
        @endif
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>