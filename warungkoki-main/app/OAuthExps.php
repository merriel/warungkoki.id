<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuthExps extends Model
{
    protected $table = 'oauth_expireds';
    protected $fillable = ['oauth_id'];
    protected $primaryKey = 'id';
}
