<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $table = 'saldo';
    protected $fillable = ['user_id','product_id','transaction_id','post_id'];
    protected $primaryKey = 'id';
}
