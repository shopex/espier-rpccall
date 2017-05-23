<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "teegon",...
    |
    */

    'default' => env('RPCCALL_DRIVER', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'connections' => [
        'default' => [
            'driver' => 'teegon',
            // 'servers'   => ['192.168.1.1','192.168.1.2,.....'],
        ],
    ],

];
