<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Garansi extends Model
{
    protected $table = 'garansi';
    protected $fillable = ['name','jangka_garansi'];
    protected $primaryKey = 'id';

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
