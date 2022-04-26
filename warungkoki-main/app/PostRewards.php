<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostRewards extends Model
{
    protected $table = 'post_rewards';
    protected $fillable = ['post_id'];
    protected $primaryKey = 'id';
}
