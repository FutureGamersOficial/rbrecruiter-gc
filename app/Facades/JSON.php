<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class JSON extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'json';
    }

}
