<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    protected $table = 'shipper';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
