<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mpociot\Teamwork\Traits\UsedByTeams;


use GrahamCampbell\Markdown\Facades\Markdown;


class Vacancy extends Model
{
    use UsedByTeams;

    public $fillable = [

        'permissionGroupName',
        'vacancyName',
        'vacancyDescription',
        'vacancyFullDescription',
        'discordRoleID',
        'vacancyFormID',
        'vacancyCount',
        'vacancyStatus',
        'vacancySlug'

    ];


    /**
    * Get the HTML variant of the vacancyFullDescription attribute.
    *
    * @param string $value The original value
    * @return string
    */
    public function getVacancyFullDescriptionAttribute($value)
    {
        if (!is_null($value))
        {
          return Markdown::convertToHTML($value);
        }
        else
        {
          return null;
        }
    }


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
