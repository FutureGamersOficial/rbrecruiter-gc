<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    //use MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'originalIP', 'username', 'uuid', 'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


//
    public function applications()
    {
        return $this->hasMany('App\Application', 'applicantUserID', 'id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'userID', 'id');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile', 'userID', 'id');
    }

    public function bans()
    {
        return $this->hasOne('App\Ban', 'userID', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'authorID', 'id');
    }



    public function isBanned()
    {
        return !$this->bans()->get()->isEmpty();
    }


    public function isStaffMember()
    {
        return $this->hasAnyRole('reviewer', 'admin', 'hiringManager');
    }



    public function routeNotificationForSlack($notification)
    {
       return config('slack.webhook.integrationURL');
    }
}
