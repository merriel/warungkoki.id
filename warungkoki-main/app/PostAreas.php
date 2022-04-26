<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostAreas extends Model
{
    protected $table = 'post_areas';
    protected $fillable = ['post_id'];
    protected $primaryKey = 'id';
}
