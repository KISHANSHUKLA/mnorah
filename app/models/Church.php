<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{

    protected $fillable = ['user_id', 'denomination', 'venue', 'days','language','Social','vision','leadership','ministries','event','eventimage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
