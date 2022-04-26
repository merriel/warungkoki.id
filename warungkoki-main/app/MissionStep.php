<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionStep extends Model
{
    protected $table = 'mission_step';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public function product() {
        $this->hasOne('App\Post','id', 'id_product');
    }

}
