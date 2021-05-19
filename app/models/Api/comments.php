<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $fillable = ['user_id','event_id','comment', 'created_at', 'updated_at'];
}
