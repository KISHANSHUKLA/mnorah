<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class limit extends Model
{
    protected $fillable = ['user_id', 'forgot_password','opt', 'created_at', 'updated_at'];

    protected $table = 'limit_recode';
}
