<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateStocks extends Model
{
    protected $table = 'updatestocks';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
