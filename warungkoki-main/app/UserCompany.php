<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $table = 'user_companies';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
