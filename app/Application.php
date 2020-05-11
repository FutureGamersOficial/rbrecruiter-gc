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

    public function user()
    {
        return $this->belongsTo('App\User', 'applicantUserID', 'id');
    }
}
