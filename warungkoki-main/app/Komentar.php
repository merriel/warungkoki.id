<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = ['user_id','diskusi_id'];
    protected $primaryKey = 'id';
}
