<?php

namespace App\models\Api;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //attributes that are not mass assignable
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function participants()
    {
        return $this->belongsToMany('App\User', 'group_participants', 'group_id', 'user_id');
    }

    public function participantsData()
    {   
        
        return $this->belongsToMany('App\User', 'group_participants', 'group_id', 'user_id');
    }
    public function messages()
    {
        return $this->hasMany('App\models\Api\Message', 'group_id');
    }
}
