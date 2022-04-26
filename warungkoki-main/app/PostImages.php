<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    protected $table = 'post_images';
    protected $fillable = ['post_id'];
    protected $primaryKey = 'id';
}
