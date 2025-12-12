<?php

return [

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        '/products',
        '/login',
        '/logout',
        '*', // (optional) allow everything for dev
    ],

    'allowed_methods' => ['*'],
 
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
