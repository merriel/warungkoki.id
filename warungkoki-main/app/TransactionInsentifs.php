<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionInsentifs extends Model
{
    protected $table = 'transaction_insentif';
    protected $fillable = ['transaction_id'];
    protected $primaryKey = 'id';
}
