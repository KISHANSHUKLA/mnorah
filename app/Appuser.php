<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;


class Appuser extends Model
{
    use Notifiable;
    use HasRoles;
    protected $fillable = ['user_id','json','verifycode','usertype','device_token'];
}
