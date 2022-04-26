<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VAPayments extends Model
{
    protected $table = 'va_payments';
    protected $fillable = ['company_code','user_id'];
    protected $primaryKey = 'id';
}
