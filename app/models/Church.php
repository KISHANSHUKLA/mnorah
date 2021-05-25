<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{

    protected $fillable = ['user_id','name','location', 'denomination', 'venue', 'days','language','Social','vision','leadership','ministries','event','eventimage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function churchRecode($id){
        $commentCount = Church::
        where('id',$id)->first();
        $commentCount['eventimage'] = json_decode($commentCount->eventimage);
        return $commentCount;   


    }
}
