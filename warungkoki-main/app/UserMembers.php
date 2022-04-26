<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMembers extends Model
{
    protected $table = 'user_members';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';

}
