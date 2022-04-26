<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rewards extends Model
{
    protected $table = 'rewards';
    protected $fillable = ['hadiah_id'];
    protected $primaryKey = 'id';
}
