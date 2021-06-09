<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invitecode extends Model
{
    protected $fillable = ['invitecode','user_id','church_id','global'];


    public function church(){

        return $this->hasOne(Church::class,'id','church_id');
    }
    public function user(){

        return $this->hasOne(User::class,'id','user_id');
    }

}
