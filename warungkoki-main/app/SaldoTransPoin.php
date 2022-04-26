<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoTransPoin extends Model
{
    protected $table = 'saldo_trans_poin';
    protected $fillable = ['user_id','transaction_id'];
    protected $primaryKey = 'id';
}
