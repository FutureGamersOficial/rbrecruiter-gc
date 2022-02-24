<?php

namespace App;

use App\Facades\DigitalStorageHelper;
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
        'extension',
        'size',
        'caption',
        'description'
    ];

    public function uploader()
    {
        return $this->belongsTo('App\User', 'uploaded_by', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }


    public function getSizeAttribute($value)
    {
        return DigitalStorageHelper::setValue($value)->formatBytes(2, true);
    }
}
