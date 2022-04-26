<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSTimes extends Model
{
    protected $table = 'ws-times';
    protected $fillable = ['trans_id'];
    protected $primaryKey = 'id';
}
