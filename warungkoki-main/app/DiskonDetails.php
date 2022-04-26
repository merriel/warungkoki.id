<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiskonDetails extends Model
{
     protected $table = 'diskon_details';
    protected $fillable = ['diskon_id'];
    protected $primaryKey = 'id';
}
