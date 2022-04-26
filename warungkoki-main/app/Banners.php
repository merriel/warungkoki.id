<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'banners';
    protected $fillable = ['judul'];
    protected $primaryKey = 'id';
}
