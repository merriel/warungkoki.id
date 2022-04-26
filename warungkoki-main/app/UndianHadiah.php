<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UndianHadiah extends Model
{
    protected $table = 'undian_hadiahs';
    protected $fillable = ['undian_id','hadiah'];
    protected $primaryKey = 'id';
}
