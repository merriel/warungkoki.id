<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $table = 'tours';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
