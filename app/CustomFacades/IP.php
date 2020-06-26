<?php

namespace App\CustomFacades;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IP
{

    /**
     * Looks up information on a specified IP address. Caches results automatically.
     * @param string $IP IP address to lookup
     * @return object
     */
    public function lookup(string $IP): object
    {

      if (empty($IP))
      {
        throw new LogicException(__METHOD__ . 'is missing parameter IP!');
      }

      $params = [
          'apiKey' => config('general.keys.ipapi.apikey'),
          'ip' => $IP
      ];

      // TODO: Maybe unwrap this?  Methods are chained here

      return json_decode(Cache::remember($IP, 3600, function() use ($IP)
      {
          return Http::get(config('general.urls.ipapi.ipcheck'), [
            'apiKey' => config('general.keys.ipapi.apikey'),
            'ip' => $IP
          ])->body();
      }));


    }

}
