<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneoffApplicant extends Model
{
    use HasFactory;

    public function application()
    {
        return $this->belongsTo('App\Application', 'id', 'application_id');
    }
}

