<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSImages extends Model
{
    protected $table = 'ws-images';
    protected $fillable = ['room_id','imgname'];
    protected $primaryKey = 'id';
}
