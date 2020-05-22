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

    public function vacancies()
    {
        return $this->hasMany('vacancies', 'vacancyFormID', 'id');
    }

    public function responses()
    {
        return $this->belongsTo('App\Response', 'id', 'id');
    }
}
