<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCategories extends Model
{
    protected $table = 'promocategories';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';
}
