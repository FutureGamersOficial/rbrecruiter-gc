<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'authorID',
        'applicationID',
        'text'
    ];

    public function application()
    {
        return $this->belongsTo('App\Application', 'applicationID', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'authorID', 'id');
    }

}
