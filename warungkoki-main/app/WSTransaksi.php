<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WSTransaksi extends Model
{
    protected $table = 'ws-transaksi';
    protected $fillable = ['user_id','room_id'];
    protected $primaryKey = 'id';
}
