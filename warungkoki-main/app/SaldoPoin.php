<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoPoin extends Model
{
    protected $table = 'saldo_poin';
    protected $fillable = ['user_id','transpoin_id'];
    protected $primaryKey = 'id';
}
