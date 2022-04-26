<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inboxes extends Model
{
    protected $table = 'inboxes';
    protected $fillable = ['desc'];
    protected $primaryKey = 'id';
}
