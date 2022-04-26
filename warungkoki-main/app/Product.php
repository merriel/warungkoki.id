<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
