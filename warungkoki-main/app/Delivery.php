<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
