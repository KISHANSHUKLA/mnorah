<?php

namespace App\models\Api;

use App\models\Church;
use App\models\Invitecode;
use App\User;
use Illuminate\Database\Eloquent\Model;

class inviteCodeRequest extends Model
{
    protected $fillable = ['user_id', 'church_id','invitecode','status','created_at', 'updated_at'];

    protected $table = 'invitecode_request';

    public function church(){

        return $this->hasOne(Church::class,'id','church_id');
    }
    public function user(){

        return $this->hasOne(User::class,'id','user_id');
    }
    public function invitecodedata(){

        return $this->hasOne(Invitecode::class,'id','invitecode');
    }

}
