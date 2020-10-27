<?php

return [

    'driver' => env('SESSION_DRIVER', 'file'), //"file", "cookie", "database", "apc","memcached", "redis", "array"

    'lifetime' => env('SESSION_LIFETIME', 1440),

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => null,

    'table' => 'vn_sessions',

    'store' => null,

    'lottery' => [2, 100],

    'cookie' => env('SESSION_COOKIE', 'vn_session'),

    'path' => '/',

    'domain' => env('SESSION_DOMAIN', null),

    'secure' => env('SESSION_SECURE_COOKIE', false),

    'http_only' => true,

    'same_site' => null,

];
