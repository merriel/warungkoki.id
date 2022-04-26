<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeranjangReedemPoint extends Model
{
    protected $table = 'keranjang_reedem_point';
    protected $fillable = ['user_id','post_id'];
    protected $primaryKey = 'id';
}
