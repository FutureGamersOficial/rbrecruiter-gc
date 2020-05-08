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
}
