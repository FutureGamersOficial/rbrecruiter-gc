<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    public $fillable = [
        'owner_id',
        'name',
        'description',
        'openJoin'
    ];


    public function vacancies()
    {
        return $this->belongsToMany('App\Vacancy', 'team_has_vacancy');
    }
}
