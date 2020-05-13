<?php

return [

    'urls' =>
    [

        'mojang' => [

            'statuscheck' => env('MOJANG_STATUS_URL') ?? 'https://status.mojang.com/check',
            'api' => env('MOJANG_API_URL') ?? ' https://api.mojang.com'

        ]
    ]

];
