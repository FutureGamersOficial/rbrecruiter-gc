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
}
