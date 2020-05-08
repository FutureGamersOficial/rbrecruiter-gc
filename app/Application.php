<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $fillable = [

        'applicantUserID',
        'applicantFormResponseID',
        'applicantStatus'

    ];
}
