<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    protected $table = 'posts';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
