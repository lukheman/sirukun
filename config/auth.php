<?php

return [

    'defaults' => [
        'guard' => 'admin',
        'passwords' => [],
    ],

    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'warga' => [
            'driver' => 'session',
            'provider' => 'wargas',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'wargas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Warga::class,
        ],
    ],

    'passwords' => [],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
