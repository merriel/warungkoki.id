<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    protected $table = 'temporary';
    protected $fillable = ['session_id','action'];
    protected $primaryKey = 'id';
}
