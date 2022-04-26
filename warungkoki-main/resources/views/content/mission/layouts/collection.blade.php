<style>


.circle-step-mission-ongoing img {
    opacity:1;
}

.circle-step-mission-ongoing a:hover > img {
    opacity:0.4;
}

.circle-step-mission-todo img {
    opacity:0.4;
}

.circle-step-mission-todo a:hover > img {
    opacity:1;
}

.circle-mission-reward{
    margin-left:10px;
}


.circle-mission-reward img {
    opacity:1;
}

.step-arrow {
    margin-left:2px;
    margin-right:2px;
}

.circle-mission-reward a:hover > img{
    opacity:0.5;
}

.modal-mission-detail.fade .modal-dialog {
  /* transform: translate3d(0, -15%, 0); */
  height: 0px;
  transition: height 0.3s !important;
  transition: -webkit-transform 0.3s ease-out;
  transition: transform 0.3s ease-out;
  transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
  -webkit-transform: none;
  transform: none;
}
.modal-mission-detail.in .modal-dialog {
  /* transform: translate3d(0, 0, 0); */
  height: 75.5%;
  transform: translate3d(0, 0, 0);
  transition: transform 0.8s ease-out;
}
</style>

@php
$step = $mission['step'];

$reward = $mission['reward'];

$step_size = count($step);
@endphp

<div class="row">

    <div class="col">

        <div class="card-header bg-white shadow-sm">
            <h6 class="text-uppercase ls-1 mb-1">Mission Collection {{ $step_size }}</h6>
        </div>

        <div class="card card-stats mb-2 mb-lg-0 shadow-ss">

            
            
                <!-- @for($i = 0; $i < 5;$i++)
                <div class="col- circle-step-mission-{{ $i == 0 ? 'ongoing' : 'todo' }}" id="step-mission-{{ $i }}">
                    <a href="#" >
                        <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                    </a>

                    <p style="font-size:0.5rem;font-weight:bold;text-align:center;">Mission {{ $i + 1 }}</p>
                </div>
                
                <div class="col- step-arrow step-mission-{{ $i }}"><i class="fa fa-arrow-right"></i></div>
                @endfor -->

                @if($step_size == 1)

                <div class="card-body" style="width:50%;margin-left:30%;display:flex;padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">

                    <div class="col- circle-step-mission-ongoing" class="step-mission-action" data-idx="0" id="step-mission-1">
                        <a href="#"  id="step-mission-action-0">
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                        </a>

                        <p style="font-size:0.5rem;font-weight:bold;text-align:center;">Mission 1</p>
                    </div>
                    

                    <div class="col- circle-mission-reward" style="">
                        <i class="fa fa-arrow-right"></i>
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;">
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;width:50px;text-decoration:none;">Reward</p>
                        </a>
                        
                    </div>

                </div>

                @elseif($step_size == 2)

                <div class="card-body" style="width:70%;margin-left:20%;display:flex;padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">

                    @for($i = 1; $i <= 2;$i++)

                    <div class="col- circle-step-mission-{{ $i == 1 ? 'ongoing' : 'todo' }}" id="step-mission-{{ $i }}">
                        @if($i != 1)
                        <i class="fa fa-arrow-right" style="height:20px;margin-left:10px;"></i>
                        @endif
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;" class="step-mission-action" data-idx="{{ $i - 1 }}" id="step-mission-action-{{ $i - 1 }}" >
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">

                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;">Mission {{ $i }}</p>
                        </a>

                       
                    </div>
                    
                    @endfor

                    <div class="col- circle-mission-reward" style="">
                        <i class="fa fa-arrow-right" style="height:20px;"></i>
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;">
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;width:50px;text-decoration:none;">Reward</p>
                        </a>
                        
                    </div>

                </div>

                @elseif($step_size == 3)

                <div class="card-body" style="width:80%;margin-left:10%;display:flex;padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">

                    @for($i = 1; $i <= 3;$i++)

                    <div class="col- circle-step-mission-{{ $i == 1 ? 'ongoing' : 'todo' }}" id="step-mission-{{ $i }}">
                        @if($i != 1)
                        <i class="fa fa-arrow-right" style="height:20px;margin-left:10px;"></i>
                        @endif
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;" class="step-mission-action" data-idx="{{ $i - 1 }}" id="step-mission-action-{{ $i - 1 }}" >
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">

                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;">Mission {{ $i }}</p>
                        </a>

                       
                    </div>
                    
                    @endfor

                    <div class="col- circle-mission-reward" style="">
                        <i class="fa fa-arrow-right" style="height:20px;"></i>
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;">
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;width:50px;text-decoration:none;">Reward</p>
                        </a>
                        
                    </div>

                </div>

                @elseif($step_size == 4)

                <div class="card-body" style="display:flex;padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;">

                    @for($i = 1; $i <= 4;$i++)

                    <div class="col- circle-step-mission-{{ $i == 1 ? 'ongoing' : 'todo' }}" id="step-mission-{{ $i }}">
                        @if($i != 1)
                        <i class="fa fa-arrow-right" style="height:20px;margin-left:10px;"></i>
                        @endif
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;" >
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;" class="step-mission-action" data-idx="{{ $i - 1 }}"  id="step-mission-action-{{ $i - 1 }}">

                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;">Mission {{ $i }}</p>
                        </a>

                       
                    </div>
                    
                    @endfor

                    <div class="col- circle-mission-reward" style="">
                        <i class="fa fa-arrow-right" style="height:20px;"></i>
                        <a href="#" style="margin-left:5px;display:inline-block;height:50px;">
                            <img src="../assets/icons/ongoing_mission.png" style="width:50px;height:50px;">
                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;width:50px;text-decoration:none;">Reward</p>
                        </a>
                        
                    </div>

                </div>

                @elseif($step_size == 5)

                <div class="card-body" style="display:ruby;padding-right: 1rem;padding-left: 1rem;padding-bottom: 1rem;margin-left:-10px;">

                    @for($i = 1; $i <= 5;$i++)

                    <div class="col- circle-step-mission-{{ $i == 1 ? 'ongoing' : 'todo' }}" id="step-mission-{{ $i }}" style="width:{{ $i == 1 ? '40px' : '69px' }};">
                        @if($i != 1)
                        <i class="fa fa-arrow-right" style="height:20px;margin-left:10px;"></i>
                        @endif
                        <a href="#" style="margin-left:5px;display:inline-block;height:40px;" class="step-mission-action" data-idx="{{ $i - 1 }}" id="step-mission-action-{{ $i - 1 }}">
                            <img src="../assets/icons/ongoing_mission.png" style="width:40px;height:40px;">

                            <p style="font-size:0.4rem;font-weight:bold;text-align:center;">Mission {{ $i }}</p>
                        </a>

                       
                    </div>
                    
                    @endfor

                    <div class="col- circle-mission-reward" style="">
                        <i class="fa fa-arrow-right" style="height:20px;"></i>
                        <a href="#" style="margin-left:5px;display:inline-block;height:40px;">
                            <img src="../assets/icons/ongoing_mission.png" style="width:40px;height:40px;">
                            <p style="font-size:0.5rem;font-weight:bold;text-align:center;width:40px;text-decoration:none;">Reward</p>
                        </a>
                        
                    </div>

                </div>

                @endif

                
                
            

        </div>

    </div>

</div>

@include('content.mission.layouts.modal')

<script src="/assets/content/js/plugins/jquery/dist/jquery.min.js"></script>
<script>


    $('.step-mission-action').on('click', function(){
        idx = $(this).attr('data-idx');

        $('#modal-mission-detail-'+idx).modal('show');

        return false;
    });


    $('.circle-mission-reward a').on('click', function(){

        $('#modal-mission-reward').modal('show');

        return false;
    });

    


</script>