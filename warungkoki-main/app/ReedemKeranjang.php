<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReedemKeranjang extends Model
{
    protected $table = 'reedem';
    protected $fillable = ['saldo_id'];
    protected $primaryKey = 'id';
}
