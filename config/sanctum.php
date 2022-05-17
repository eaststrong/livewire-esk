<?php

use Laravel\Sanctum\Sanctum;

return [
  'expiration' => null,
  'guard' => ['web'],

  'middleware' => [
    'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
  ],

  'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf('%s%s', 'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1', Sanctum::currentApplicationUrlWithPort()))),
];
