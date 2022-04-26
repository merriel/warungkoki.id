<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
