<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailers extends Model
{
    protected $table = 'retailers';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
