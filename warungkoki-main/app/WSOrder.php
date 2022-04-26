<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSOrder extends Model
{
   	protected $table = 'ws-orders';
    protected $fillable = ['transaction_id'];
    protected $primaryKey = 'id';
}
