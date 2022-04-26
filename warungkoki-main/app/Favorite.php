<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorite';
    protected $fillable = ['user_id','post_id'];
    protected $primaryKey = 'id';
}
