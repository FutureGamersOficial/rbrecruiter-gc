<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    public $fillable = [
        'option_name',
        'option_value'
    ];
}
