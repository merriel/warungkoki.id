<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionReward extends Model
{
    protected $table = 'mission_reward';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public function product() {
        $this->hasOne('App\Posts','id', 'id_product');
    }

}
