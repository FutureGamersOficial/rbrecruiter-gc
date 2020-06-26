<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public $fillable = [
        'responseFormID',
        'associatedVacancyID',
        'responseData'
    ];


    public function form()
    {
        return $this->hasOne('App\Form', 'id', 'responseFormID');
    }

    public function application()
    {
        return $this->belongsTo('App\Application', 'applicantFormResponseID', 'id');
    }

    public function vacancy()
    {
        return $this->hasOne('App\Vacancy', 'id', 'associatedVacancyID');
    }
}
