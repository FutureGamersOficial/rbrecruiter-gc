<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App;

use App\Traits\HandlesAccountTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use UserHasTeams, Notifiable, HasRoles, SoftDeletes, HandlesAccountTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'originalIP', 'username', 'uuid', 'dob',
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

    // RELATIONSHIPS

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

    public function files()
    {
        return $this->hasMany('App\TeamFile', 'uploaded_by');
    }

    // UTILITY LOGIC

    public function isBanned()
    {
        return ! $this->bans()->get()->isEmpty();
    }

    public function isStaffMember()
    {
        return $this->hasAnyRole('reviewer', 'admin', 'hiringManager');
    }

    public function has2FA()
    {
        return ! is_null($this->twofa_secret);
    }

    public function hasTeam($team): bool
    {
        if ($team instanceof Team || is_int($team))
        {
            return $this->teams->contains($team);
        }
        else
        {
            /**
             * In PHP 8, we can just use union types and let PHP enforce this for us.
             */
            throw new \InvalidArgumentException('Please pass either a Team object or an integer identifying a Team.');
        }
    }

    public function routeNotificationForSlack($notification)
    {
        return config('slack.webhook.integrationURL');
    }
}
