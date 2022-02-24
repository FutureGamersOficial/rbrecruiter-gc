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

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mpociot\Teamwork\Traits\UsedByTeams;

class Vacancy extends Model
{
    //use UsedByTeams;

    public $fillable = [

        'permissionGroupName',
        'vacancyName',
        'vacancyDescription',
        'vacancyFullDescription',
        'discordRoleID',
        'vacancyFormID',
        'vacancyCount',
        'vacancyStatus',
        'vacancySlug',
        'team_id',

    ];

    /**
     * Get the HTML variant of the vacancyFullDescription attribute.
     *
     * @param string $value The original value
     * @return string
     */
    public function getVacancyFullDescriptionAttribute($value)
    {
        if (! is_null($value)) {
            return Markdown::convertToHTML($value);
        } else {
            return null;
        }
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team', 'team_has_vacancy');
    }

    public function forms()
    {
        return $this->belongsTo('App\Form', 'vacancyFormID', 'id');
    }

    public function open()
    {
        $this->update([
            'vacancyStatus' => 'OPEN',
        ]);

        Log::info('Vacancies: Vacancy '.$this->id.' ('.$this->vacancyName.') opened by '.Auth::user()->name);
    }

    public function close()
    {
        $this->update([
            'vacancyStatus' => 'CLOSED',
        ]);

        Log::warning('Vacancies: Vacancy '.$this->id.' ('.$this->vacancyName.') closed by '.Auth::user()->name);
    }

    public function decrease()
    {
        if ($this->vacancyCount !== 0)
        {
            $this->update([
                'vacancyCount' => $this->vacancyCount - 1
            ]);

            Log::info('Vacancies: Decreased vacancy slots by one.', [
                'vacancyId' => $this->id,
                'vacancyName' => $this->vacancyName
            ]);
        }
    }

    /**
     * Check if the Modal is attached to the $checkingTeam Model.
     *
     * @param Team $checkingTeam The mdoel you want to check against
     * @return bool Whether the models are attached
     */
    public function hasTeam(Team $checkingTeam): bool
    {
        $myTeams = $this->teams;

        if (empty($myTeams)) {
            // no associated teams
            return false;
        }

        foreach ($myTeams as $team) {
            if ($team->id === $checkingTeam->id) {
                return true;
            }
        }

        return false;
    }
}
