<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    protected $table = 'diskusi';
    protected $fillable = ['user_id','post_id'];
    protected $primaryKey = 'id';
}
