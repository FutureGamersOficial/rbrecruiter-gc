<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UUID extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'uuidConversionFacade';
    }
}