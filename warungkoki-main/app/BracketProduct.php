<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BracketProduct extends Model
{
    protected $table = 'bracket_product';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
