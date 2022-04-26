<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InboxUsers extends Model
{
    protected $table = 'inbox_users';
    protected $fillable = ['inbox_id'];
    protected $primaryKey = 'id';
}
