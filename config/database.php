<?php

use Illuminate\Support\Str;

return [
  'connections' => [
    'pgsql' => [
      'charset' => 'utf8',
      'database' => env('DB_DATABASE'),
      'driver' => 'pgsql',
      'host' => env('DB_HOST'),
      'password' => env('DB_PASSWORD'),
      'port' => env('DB_PORT'),
      'prefix' => '',
      'prefix_indexes' => true,
      'search_path' => 'public',
      'sslmode' => 'prefer',
      'url' => env('DATABASE_URL', 'postgres://esk_user:8GHSmHbttAJx8OsgyAv5cDMPttbjoFHs@dpg-ca066r319n097u1g9r30-a.oregon-postgres.render.com/esk'),
      'username' => env('DB_USERNAME'),
    ],
    'sqlite' => [
      'database' => env('DB_DATABASE', database_path('database.sqlite')),
      'driver' => 'sqlite',
      'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
      'prefix' => '',
      'url' => env('DATABASE_URL'),
    ],
  ],
  'default' => env('DB_CONNECTION', 'pgsql'),
  'migrations' => 'migrations',
];
