<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReedemKet extends Model
{
    protected $table = 'reedem_ket';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
