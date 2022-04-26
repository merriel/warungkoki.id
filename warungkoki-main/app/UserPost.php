<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    protected $table = 'user_posts';
    protected $fillable = ['user_id','post_id'];
    protected $primaryKey = 'id';
}
