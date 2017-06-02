<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    | Supported: "apc", "array", "database", "file", "memcached", "redis"
    |
    */

    'default' => env('RPCCALL_DRIVER', 'teegon'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [
        'teegon' => [
            'driver' => 'teegon',
            'url' => env('TEEGON_URL', 'http://api.teegon.com/router'),
            // 'url' => 'http://127.0.0.1/espier/public/index.php/api',
            'key' => env('TEEGON_KEY', '47b7QcS'),
            'secret' => env('TEEGON_SECRET', 'ZmXxR5PXXEz8mjCwary4'),
        ],
    ],

];
