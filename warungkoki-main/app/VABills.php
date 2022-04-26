<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VABills extends Model
{
    protected $table = 'va_bills';
    protected $fillable = ['company_code','user_id'];
    protected $primaryKey = 'id';
}
