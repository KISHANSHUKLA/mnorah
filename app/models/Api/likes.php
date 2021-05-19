<?php

namespace App\models\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\models\Api\comments;
use App\models\Api\witness;
class likes extends Model
{
    protected $fillable = ['user_id','event_id','status', 'created_at', 'updated_at'];


    public function like($id){
        $like = likes::
        where('user_id',auth::user()->id)
        ->where('event_id',$id)->first();

        if ($like === null) {
            return 0;
         }else{
            return 1;
        }

    }

    public function likecount($id){
        $likeCount = likes::
        where('event_id',$id)->count();

        return $likeCount;

    }

    public function comment($id){
        $like = comments::
        where('user_id',auth::user()->id)
        ->where('event_id',$id)->first();

        if ($like === null) {
            return '';
         }else{
            return $like->comment;
        }

    }

    public function commentcount($id){
        $commentCount = comments::
        where('event_id',$id)->count();

        return $commentCount;

    }

    public function witness($id){
        $like = witness::
        where('user_id',auth::user()->id)
        ->where('event_id',$id)->first();

        if ($like === null) {
            return 0;
         }else{
            return 1;
        }

    }

    public function witnesscount($id){
        $commentCount = witness::
        where('event_id',$id)->count();

        return $commentCount;

    }
}
