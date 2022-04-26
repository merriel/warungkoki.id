<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDelivery extends Model
{
    protected $table = 'transaction_delivery';
    protected $fillable = ['transaction_id'];
    protected $primaryKey = 'id';
}
