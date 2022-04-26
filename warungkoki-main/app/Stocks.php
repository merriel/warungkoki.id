<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table = 'stocks';
    protected $fillable = ['wilayah_id'];
    protected $primaryKey = 'id';
}
