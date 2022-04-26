<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndianVouchers extends Model
{
    protected $table = 'undian_vouchers';
    protected $fillable = ['undian_id','code'];
    protected $primaryKey = 'id';
}
