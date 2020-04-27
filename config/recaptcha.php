<?php

return [

    'keys' => [
        'sitekey' => env('RECAPTCHA_SITE_KEY'),
        'secret' => env('RECAPTCHA_PRIVATE_KEY')
    ],

    'verify' => [
        'apiurl' => env('RECAPTCHA_VERIFY_URL')
    ]

];
