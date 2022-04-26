<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Undian extends Model
{
    protected $table = 'undians';
    protected $fillable = ['uuid','dari'];
    protected $primaryKey = 'id';

}
