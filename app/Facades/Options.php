<?php


namespace App\Facades;
use \Illuminate\Support\Facades\Facade;

class Options extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'smOptions';
    }
}
