<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    protected $fillable = ['user_id','company_id'];
    protected $primaryKey = 'id';
}
