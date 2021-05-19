<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class witness extends Model
{   

    protected $table = 'witness';
    protected $fillable = ['user_id','event_id','status', 'created_at', 'updated_at'];
}
