<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionRetur extends Model
{
    protected $table = 'transaction_retur';
    protected $fillable = ['transaction_id'];
    protected $primaryKey = 'id';
}
