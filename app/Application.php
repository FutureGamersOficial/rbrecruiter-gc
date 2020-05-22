<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $fillable = [

        'applicantUserID',
        'applicantFormResponseID',
        'applicationStatus'

    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'applicantUserID', 'id');
    }

    public function response()
    {
        return $this->hasOne('App\Response', 'id', 'applicantFormResponseID');
    }

    public function appointment() // 1 - 1
    {
        return $this->hasOne('App\Appointment', 'applicationID', 'id');
    }

    public function setStatus($status)
    {
        return $this->update([
            'applicationStatus' => $status
        ]);
    }
}
