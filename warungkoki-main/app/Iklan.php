<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    protected $table = 'iklan';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
