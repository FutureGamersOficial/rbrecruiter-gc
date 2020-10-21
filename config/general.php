<?php

return [

    'urls' =>
    [

        'mojang' => [

            'statuscheck' => env('MOJANG_STATUS_URL') ?? 'https://status.mojang.com/check',
            'api' => env('MOJANG_API_URL') ?? ' https://api.mojang.com',
            'session' => env('MOJANG_SESSIONAPI_URL') ?? 'https://sessionserver.mojang.com'

        ],
        'ipapi' => [
            'ipcheck' => env('IPGEO_API_URL') ?? 'https://api.ipgeolocation.io/ipgeo'
        ]
    ],
    'keys' => [

        'ipapi' => [
          'apikey' => env('IPGEO_API_KEY')
        ]

    ]

];
