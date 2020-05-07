<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public $fillable = [

        'formName',
        'formStructure',
        'formStatus'

    ];

    public function vacancy()
    {
        return $this->hasMany('App\Vacancy', 'vacancyFormID');
    }
}
