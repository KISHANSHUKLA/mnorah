<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    protected $fillable = ['user_id', 'message','image','status', 'created_at', 'updated_at'];
}
