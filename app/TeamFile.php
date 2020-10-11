<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mpociot\Teamwork\Traits\UsedByTeams;

class TeamFile extends Model
{
    use HasFactory, UsedByTeams;


    protected $fillable = [
        'uploaded_by',
        'team_id',
        'name',
        'fs_location',
        'extension'
    ];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'uploaded_by', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
