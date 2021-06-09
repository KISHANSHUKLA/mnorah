<?php

namespace App\models\Api;

use App\Appuser;
use App\models\Api\likes;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class events extends Model
{
    protected $fillable = ['user_id', 'message','image','status','medicallyverified','communityverified', 'created_at', 'updated_at'];

    public function userget($user_id){

        
        $user =  User::where('id',$user_id)->first();
        $appUser = Appuser::where('user_id',$user->id)->first();

        $user['Leadershipteam'] = $appUser->Leadershipteam;
        $user['mobile'] = $appUser->mobile;
        $user['image'] = URL::to('/').''.$appUser->image;
        
        return $user;
        
    }

    public function user(){

        return $this->hasOne(User::class, 'id','user_id');
    }

    public function event($Id){

        $events =  events::where('id',$Id)->first();
        $events['image'] = URL::to('/').''.$events->image;

        return $events;
    }
}
