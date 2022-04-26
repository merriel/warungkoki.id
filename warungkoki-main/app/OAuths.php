<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuths extends Model
{
    protected $table = 'oauths';
    protected $fillable = ['client_id'];
    protected $primaryKey = 'id';
}
