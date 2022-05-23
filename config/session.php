<?php

use Illuminate\Support\Str;

return [
  'connection' => env('SESSION_CONNECTION'),
  'cookie' => env('SESSION_COOKIE', Str::slug('laravel', '_') . '_session'),
  'domain' => env('SESSION_DOMAIN'),
  'driver' => env('SESSION_DRIVER', 'array'),
  'encrypt' => false,
  'expire_on_close' => false,
  'files' => storage_path('framework/sessions'),
  'http_only' => true,
  'lifetime' => env('SESSION_LIFETIME', 120),
  'lottery' => [2, 100],
  'path' => '/',
  'same_site' => 'lax',
  'secure' => env('SESSION_SECURE_COOKIE'),
  'store' => env('SESSION_STORE'),
  'table' => 'sessions',
];
