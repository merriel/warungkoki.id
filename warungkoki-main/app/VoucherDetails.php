<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherDetails extends Model
{
    protected $table = 'voucher_details';
    protected $fillable = ['kode','status'];
    protected $primaryKey = 'id';
}
