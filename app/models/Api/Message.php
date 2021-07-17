<?php

namespace App\models\Api;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{


    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo('App\models\Api\Group', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDateTimeAttribute()
    {
        //we get the date and the time, this will return an array
        $dateAndTime = explode(' ', $this->created_at);

        $date = date('d-M-Y', strtotime($dateAndTime[0]));

        $time = date('H:i', strtotime($dateAndTime[1]));

        return "{$date} {$time}";
    }
}
