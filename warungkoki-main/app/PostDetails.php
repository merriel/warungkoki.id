<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDetails extends Model
{
    protected $table = 'post_details';
    protected $fillable = ['post_id'];
    protected $primaryKey = 'id';
}
