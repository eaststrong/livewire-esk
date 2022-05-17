<?php

use Illuminate\Support\Str;

return [
  'default' => env('CACHE_DRIVER', 'database'),
  'prefix' => env('CACHE_PREFIX', Str::slug('laravel', '_') . '_cache_'),

  'stores' => [
    'apc' => ['driver' => 'apc'],

    'array' => [
      'driver' => 'array',
      'serialize' => false,
    ],

    'database' => [
      'connection' => null,
      'driver' => 'database',
      'lock_connection' => null,
      'table' => 'cache',
    ],

    'file' => [
      'driver' => 'file',
      'path' => storage_path('framework/cache/data'),
    ],

    'octane' => ['driver' => 'octane'],
  ],
];
