<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Vacancy extends Model
{
    public $fillable = [

        'permissionGroupName',
        'vacancyName',
        'vacancyDescription',
        'discordRoleID',
        'vacancyFormID',
        'vacancyCount',
        'vacancyStatus',
        'vacancySlug'

    ];

    public function forms()
    {
        return $this->belongsTo('App\Form', 'vacancyFormID', 'id');
    }

    public function open()
    {
        $this->update([
            'vacancyStatus' => 'OPEN'
        ]);

        Log::info("Vacancies: Vacancy " . $this->id . " (" . $this->vacancyName . ") opened by " . Auth::user()->name);
    }

    public function close()
    {
        $this->update([
           'vacancyStatus' => 'CLOSED'
        ]);

        Log::warning("Vacancies: Vacancy " . $this->id . " (" . $this->vacancyName . ") closed by " . Auth::user()->name);

    }

}
