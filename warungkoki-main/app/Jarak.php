<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jarak extends Model
{
    protected $table = 'delivery_jarak';
    protected $fillable = ['wilayah_id'];
    protected $primaryKey = 'id';
}
