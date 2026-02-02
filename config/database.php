<?php

// Parse DATABASE_URL if provided (for Railway/Heroku compatibility)
$url = parse_url(env('DATABASE_URL', ''));

$db_host = $url['host'] ?? env('DB_HOST', 'localhost');
$db_port = $url['port'] ?? env('DB_PORT', 5432);
$db_database = ltrim($url['path'] ?? '', '/') ?: env('DB_DATABASE', 'shipment_tracker');
$db_username = $url['user'] ?? env('DB_USERNAME', 'postgres');
$db_password = $url['pass'] ?? env('DB_PASSWORD', '');

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => $db_host,
            'port' => $db_port,
            'database' => $db_database,
            'username' => $db_username,
            'password' => $db_password,
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
            'prefix_indexes' => true,
            'search_path' => env('DB_SEARCH_PATH', 'public'),
            'sslmode' => env('DB_SSLMODE', 'prefer'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    */

    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],
    ],

];
