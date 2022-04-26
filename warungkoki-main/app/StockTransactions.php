<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransactions extends Model
{
    protected $table = 'stock_transactions';
    protected $fillable = ['wilayah_id'];
    protected $primaryKey = 'id';
}
