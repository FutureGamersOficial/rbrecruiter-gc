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

return [

    'urls' => [

        'mojang' => [

            'statuscheck' => env('MOJANG_STATUS_URL') ?? 'https://status.mojang.com/check',
            'api' => env('MOJANG_API_URL') ?? ' https://api.mojang.com',
            'session' => env('MOJANG_SESSIONAPI_URL') ?? 'https://sessionserver.mojang.com',

        ],
        'ipapi' => [
            'ipcheck' => env('IPGEO_API_URL') ?? 'https://api.ipgeolocation.io/ipgeo',
        ],
    ],
    'keys' => [

        'ipapi' => [
            'apikey' => env('IPGEO_API_KEY'),
        ],

    ],

];
