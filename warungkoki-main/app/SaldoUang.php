<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoUang extends Model
{
    protected $table = 'saldo_uang';
    protected $fillable = ['user_id','before'];
    protected $primaryKey = 'id';
}
