<?php

namespace App\models\Api;
use Illuminate\Database\Eloquent\Model;

class group_participants extends Model
{
    //attributes that are not mass assignable
    protected $guarded = [];

    protected $table = 'group_participants';
}
