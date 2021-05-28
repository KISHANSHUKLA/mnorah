<?php

namespace App\models;

use App\models\Api\followers;
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
        $b = new followers();
        $commentCount['isfollow'] = $b->followget($commentCount->id);
        $commentCount['days'] = json_decode($commentCount->days);
        $commentCount['eventimage'] = json_decode($commentCount->eventimage);
        return $commentCount;   


    }
}
