<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\CustomFacades;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IP
{
    // Central source of truth for all operations that deal with IP addresses.
    // For views, this is in a service provider, and is shared with all of them
    /**
     * Determines whether you should collect/display IP addresses in the app.
     * @return bool Whether you should collect/display IPs, in the context in which this is called
     */
    public function shouldCollect(): bool
    {
        // should collect or display IPs?

        if (config('demo.is_enabled') || config('app.hide_ips'))
        {
            return false; // do not collect!
        }

        return true;
    }

    /**
     * Looks up information on a specified IP address. Caches results automatically.
     * @param string $IP IP address to lookup
     * @return object
     */
    public function lookup(string $IP): object
    {
        $params = [
            'apiKey' => config('general.keys.ipapi.apikey'),
            'ip' => $IP,
        ];

        if ($this->shouldCollect()) {


            return json_decode(Cache::remember($IP, 3600, function () use ($IP) {
                return Http::get(config('general.urls.ipapi.ipcheck'), [
                    'apiKey' => config('general.keys.ipapi.apikey'),
                    'ip' => $IP,
                ])->body();
            }));

        }

        return new class {
            public $message = "This feature is disabled.";
        };
    }
}
