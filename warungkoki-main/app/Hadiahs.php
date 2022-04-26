<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hadiahs extends Model
{
    protected $table = 'hadiah';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
