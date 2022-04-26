<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = 'districts';
    protected $fillable = ['regency_id','name'];
    protected $primaryKey = 'id';
}
