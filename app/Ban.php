<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{

    public $fillable = [

        'userID',
        'reason',
        'bannedUntil',
        'userAgent',
        'authorUserID'

    ];

    public $dates = [
        'bannedUntil'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'userID', 'id');
    }

}
