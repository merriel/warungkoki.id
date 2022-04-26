<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallangeProses extends Model
{
    protected $table = 'challange_proses';
    protected $fillable = ['join_id'];
    protected $primaryKey = 'id';
}
