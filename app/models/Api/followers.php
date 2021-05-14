<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class followers extends Model
{
    protected $fillable = ['follower_id', 'church_id', 'created_at', 'updated_at'];

}
