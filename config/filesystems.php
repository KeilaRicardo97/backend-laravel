<?php

return [

    'default' => env('FILESYSTEM_DRIVER', 's3'),



    'cloud' => env('FILESYSTEM_CLOUD', 's3'),



    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public/'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'images' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img'),
            'visibility' => 'public',
        ],
        'category' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/category'),
            'visibility' => 'public',
        ],
        'users' => [
            'driver' => 'local',
            'root' => storage_path('app/public/img/user'),
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'visibility' => 'public',
        ],

    ],

];
