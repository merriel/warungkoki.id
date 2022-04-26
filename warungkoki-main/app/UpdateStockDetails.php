<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateStockDetails extends Model
{
    protected $table = 'updatestock_details';
    protected $fillable = ['user_id'];
    protected $primaryKey = 'id';
}
