<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoTrans extends Model
{
    protected $table = 'saldo_trans';
    protected $fillable = ['user_id','type'];
    protected $primaryKey = 'id';
}
