<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallangeJoins extends Model
{
    protected $table = 'challange_joins';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
