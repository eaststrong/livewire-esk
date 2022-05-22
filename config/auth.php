<?php

return [
  'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
  ],
  'guards' => [
    'web' => [
      'driver' => 'session',
      'provider' => 'users',
    ],
  ],
  'password_timeout' => 10800,
  'passwords' => [
    'users' => [
      'expire' => 60,
      'provider' => 'users',
      'table' => 'password_resets',
      'throttle' => 60,
    ],
  ],
  'providers' => [
    'users' => [
      'driver' => 'eloquent',
      'model' => App\Models\User::class,
    ],
  ],
];
