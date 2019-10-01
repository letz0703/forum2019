<?php

return [
    'recaptcha' => [
        'key' => env('RECAPTCHA_SITEKEY'),
        'secret' => env('RECAPTCHA_SECRET'),
    ],

    'pagination' => [
        'perPage' => 25
    ],
    
    'algolia' => [
        'id' => env('ALGOLIA_APP_ID',''),
        'secret' => env('ALGOLIA_SECRET','')
    ]
];
