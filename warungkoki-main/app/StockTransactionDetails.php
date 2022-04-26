<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransactionDetails extends Model
{
    protected $table = 'stock_transaction_details';
    protected $fillable = ['post_id'];
    protected $primaryKey = 'id';
}
