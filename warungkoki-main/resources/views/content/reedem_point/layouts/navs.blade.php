<style>
#tabs-menu .circlekeranjang {
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  font-size: 12px;
  color: #fff;
  line-height: 19px;
  text-align: center;
  background: #feac3b;
  top: -6px;
  margin-left: 10px;
}
</style>

<div class="">
    <ul class="nav nav-pills nav-fill flex-column flex-sm-row " id="tabs-menu" role="tablist" style="box-shadow:none;background:none;position:inherit;padding-bottom:0px;">
        @foreach($listNav as $nav)
        @php 
        $width = '';
        $margin = '';
        if($nav['order'] == 1){$margin = 'margin-left:2px;margin-right:2px;';}
        if($nav['order'] == 1){$width = (1 / count($listNav)) * 100 - 2;}
        if($nav['order'] != 1){$width = (1 / count($listNav)) * 100;}
        @endphp
        <li class="nav-item " style="width:{{ $width }}%;{{ $margin }}">
            <a style="{{ $nav['active'] ? 'background-color:#feac3b;color:#fff;' : 'background-color:#fff;color:#feac3b;' }}" class="nav-link mb-sm-3 mb-md-0 {{ $nav['active'] ? 'active' : '' }}" href="/reedem_point/{{ $nav['href'] }}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                <!-- <i class="ni ni-cloud-upload-96 mr-2"></i> -->
                {{ $nav['name'] }}
                @if($nav['order'] == 1) <span class="circlekeranjang" style="border: 1px solid;{{ !$nav['active'] ? 'background-color:#feac3b;color:#fff;' : 'background-color:#fff;color:#feac3b;' }}" ><b id="keranjangreedemcount">0</b></span> @endif
            </a>
        </li>
        @endforeach
    </ul>
</div>

