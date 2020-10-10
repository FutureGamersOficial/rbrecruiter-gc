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

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $fillable = [

        'applicantUserID',
        'applicantFormResponseID',
        'applicationStatus',

    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'applicantUserID', 'id');
    }

    public function response()
    {
        return $this->hasOne('App\Response', 'id', 'applicantFormResponseID');
    }

    public function appointment() // 1 - 1
    {
        return $this->hasOne('App\Appointment', 'applicationID', 'id');
    }

    public function votes()
    {
        return $this->belongsToMany('App\Vote', 'votes_has_application');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'applicationID', 'id');
    }

    public function setStatus($status)
    {
        return $this->update([
            'applicationStatus' => $status,
        ]);
    }
}
