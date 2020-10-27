<?php

return [
    'enabled' => true,
    'except' => [
        'api*'
    ],

    'storage' => [
        'enabled'    => false,
        'driver'     => 'file', // redis, file, pdo, custom
        'path'       => storage_path('debugbar'), // For file driver
        'connection' => null,   // Leave null for default connection (Redis/PDO)
        'provider'   => '' // Instance of StorageInterface for custom driver
    ],

    'include_vendors' => true,

    'capture_ajax' => true,
    'add_ajax_timing' => false,

    'error_handler' => false,
    'clockwork' => false,

    'collectors' => [
        'phpinfo'         => true,  // Php version
        'messages'        => true,  // Messages
        'time'            => true,  // Time Datalogger
        'memory'          => true,  // Memory usage
        'exceptions'      => true,  // Exception displayer
        'log'             => true,  // Logs from Monolog (merged in messages if enabled)
        'db'              => true,  // Show database (PDO) queries and bindings
        'views'           => true,  // Views with their data
        'route'           => true,  // Current route information
        'auth'            => false, // Display Laravel authentication status
        'gate'            => false,  // Display Laravel Gate checks
        'session'         => true,  // Display session data
        'symfony_request' => false,  // Only one can be enabled..
        'mail'            => false,  // Catch mail messages
        'laravel'         => false, // Laravel version and environment
        'events'          => false, // All events fired
        'default_request' => false, // Regular or special Symfony request logger
        'logs'            => true, // Add the latest log messages
        'files'           => false, // Show the included files
        'config'          => false, // Display config settings
        'cache'           => true, // Display cache events
        'models'          => false,  // Display models
    ],

    'options' => [
        'auth' => [
            'show_name' => true,
        ],
        'db' => [
            'with_params'       => true,
            'backtrace'         => true,
            'timeline'          => true,
            'explain' => [
                'enabled' => false,
                'types' => ['SELECT'],
            ],
            'hints'             => true,
        ],
        'mail' => [ 'full_log' => false],
        'views' => ['data' => false],
        'route' => ['label' => true],
        'logs' => ['file' => null],
        'cache' => ['values' => true],
    ],

    'inject' => true,
    'route_prefix' => '_debugbar',
    'route_domain' => null,
];
