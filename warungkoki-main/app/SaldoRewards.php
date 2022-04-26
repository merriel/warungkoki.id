<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoRewards extends Model
{
    protected $table = 'saldo_rewards';
    protected $fillable = ['user_id','product_id','transaction_id','join_id'];
    protected $primaryKey = 'id';
}
