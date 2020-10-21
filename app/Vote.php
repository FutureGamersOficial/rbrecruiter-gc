<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public $fillable = [

        'userID',
        'allowedVoteType',

    ];

    public $touches = [
      'application'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'userID');
    }

    public function application()
    {
        return $this->belongsToMany('App\Application', 'votes_has_application');
    }
}
