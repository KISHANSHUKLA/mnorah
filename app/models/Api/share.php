<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class share extends Model
{
    protected $fillable = ['user_id','event_id','share_status', 'created_at', 'updated_at'];

}
