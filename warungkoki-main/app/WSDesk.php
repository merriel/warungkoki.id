<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSDesk extends Model
{
    protected $table = 'ws-desk';
    protected $fillable = ['room_id','desk_code'];
    protected $primaryKey = 'id';
}
