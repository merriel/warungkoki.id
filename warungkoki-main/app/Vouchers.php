<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $table = 'vouchers';
    protected $fillable = ['amount','percent'];
    protected $primaryKey = 'id';
}
