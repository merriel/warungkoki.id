<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesPost extends Model
{
    protected $table = 'imgpost';
    protected $fillable = ['company_id'];
    protected $primaryKey = 'id';
}
