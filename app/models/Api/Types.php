<?php

namespace App\models\Api;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    //attributes that are not mass assignable
    protected $guarded = [];

    protected $table = 'message_type';
}
