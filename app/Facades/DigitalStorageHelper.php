<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class DigitalStorageHelper extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'digitalStorageHelperFacadeRoot';
    }

}
