<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{

    protected $table = 'users';
    protected $fillable = ['email','role_id'];
    protected $primaryKey = 'id';

    use SoftDeletes;
    protected $hidden = ['password',  'remember_token'];

    
}
