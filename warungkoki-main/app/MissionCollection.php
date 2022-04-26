<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MissionCollection extends Model
{
    protected $table = 'mission_collection';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public function product() {
        $this->hasOne('App\Posts','id', 'id_product');
    }

}
