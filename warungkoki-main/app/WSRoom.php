<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSRoom extends Model
{
    protected $table = 'ws-room';
    protected $fillable = ['wilayah_id','room_name'];
    protected $primaryKey = 'id';
}
