<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KurirLocal extends Model
{
    protected $table = 'kurir_local';
    protected $fillable = ['jarak','amount'];
    protected $primaryKey = 'id';
}
