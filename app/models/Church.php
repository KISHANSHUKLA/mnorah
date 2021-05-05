<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{

    protected $fillable = ['user_id', 'denomination', 'venue', 'days','language','Social','vision','leadership','ministries','event'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
