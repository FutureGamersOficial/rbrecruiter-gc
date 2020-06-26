<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class IP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ipInformationFacade';
    }
}
