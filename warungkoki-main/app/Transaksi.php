<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['uuid'];
    protected $primaryKey = 'id';
}
