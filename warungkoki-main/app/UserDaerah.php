<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDaerah extends Model
{
    protected $table = 'users_daerah';
    protected $fillable = ['regency_id','user_id'];
    protected $primaryKey = 'id';
}
