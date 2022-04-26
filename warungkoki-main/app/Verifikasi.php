<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    protected $table = 'verifikasi';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
