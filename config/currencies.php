<?php

return [

    'driver' => env('CURRENCY_CONVERSION_DRIVER', 'fixer'),

    'minutes-between-lookups' => 10,

    'drivers' => [
        'fixer' => [
            'api-key' => env('FIXER_API_KEY'),
            'endpoints' => [
                'latest' => 'https://data.fixer.io/api/latest',
            ],
        ],
    ],

    'supported-currencies' => [
        'EUR',
        'GBP',
        'USD',
    ],
];
