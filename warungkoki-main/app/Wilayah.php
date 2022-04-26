<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = ['name','alamat'];
    protected $primaryKey = 'id';

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
