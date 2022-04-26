<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiMission extends Model
{
    protected $table = 'transaction_mission';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
