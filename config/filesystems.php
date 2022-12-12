<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'fichas' => [
            'driver' => 'local',
            'root' => public_path('fichas'),
        ],
        'fichas-ordinarias-nacim' => [
            'driver' => 'local',
            'root' => public_path('fichas/ordinarias/nacim'),
        ],
        'fichas-ordinarias-matri' => [
            'driver' => 'local',
            'root' => public_path('fichas/ordinarias/matri'),
        ],
        'fichas-ordinarias-defun' => [
            'driver' => 'local',
            'root' => public_path('fichas/ordinarias/defun'),
        ],
        'fichas-extraordinarias-nacim' => [
            'driver' => 'local',
            'root' => public_path('fichas/extraordinarias/nacim'),
        ],
        'fichas-extraordinarias-matri' => [
            'driver' => 'local',
            'root' => public_path('fichas/extraordinarias/matri'),
        ],
        'fichas-extraordinarias-defun' => [
            'driver' => 'local',
            'root' => public_path('fichas/extraordinarias/defun'),
        ],
        'fichas-especiales-nacim' => [
            'driver' => 'local',
            'root' => public_path('fichas/especiales/nacim'),
        ],
        'fichas-especiales-matri' => [
            'driver' => 'local',
            'root' => public_path('fichas/especiales/matri'),
        ],
        'fichas-especiales-defun' => [
            'driver' => 'local',
            'root' => public_path('fichas/especiales/defun'),
        ],
        'fichas-matri' => [
            'driver' => 'local',
            'root' => public_path('fichas/matri'),
        ],
        'fichas-defun' => [
            'driver' => 'local',
            'root' => public_path('fichas/defun'),
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
