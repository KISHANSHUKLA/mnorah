<?php

namespace App\models\Api;

use Illuminate\Database\Eloquent\Model;

class followers extends Model
{
    protected $fillable = ['follower_id', 'church_id', 'created_at', 'updated_at'];


    public function followget($id){
      
        $a = followers::where("church_id",$id)->first();
             if ($a === null) {
                return 0;
             }else{
                return 1;
            }
    }

}
