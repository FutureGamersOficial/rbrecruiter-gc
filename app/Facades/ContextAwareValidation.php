<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ContextAwareValidation extends Facade
{

   protected static function getFacadeAccessor()
   {
     return 'contextAwareValidator';
   }

}
