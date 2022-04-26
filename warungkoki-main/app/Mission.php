<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $table = 'mission';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public function stepCollect() {
        $this->hasMany('App\MissionCollection', 'id', 'id_mission');
    }

    public function step() {
        $this->hasMany('App\MissionStep', 'id', 'id_mission');
    }

    public function reward() {
        $this->hasOne('App\MissionReward', 'id', 'id_mission');
    }

}
