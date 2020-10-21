<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    public $fillable = [

        'profileShortBio',
        'profileAboutMe',
        'avatarPreference',
        'socialLinks',
        'userID'

    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'userID', 'id');
    }

}
