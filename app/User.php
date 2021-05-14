<?php
namespace App;

use App\Api\followers;
use App\models\Church;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable,HasApiTokens;
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'remember_token','flag'];
    
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function appuser(){

        return $this->hasOne(Appuser::class);
    }

    
    public function followers()
    {
    return $this->belongsToMany(Church::class, 'followers', 'follower_id', 'church_id')->withTimestamps();
    }


}
