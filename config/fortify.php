<?php

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;

return [
  'domain' => null,
  'email' => 'email',

  'features' => [
    Features::registration(),
    Features::resetPasswords(),
    Features::updateProfileInformation(),
    Features::updatePasswords(),
    Features::twoFactorAuthentication([
      'confirm' => true,
      'confirmPassword' => true,
    ]),
  ],

  'guard' => 'web',
  'home' => RouteServiceProvider::HOME,

  'limiters' => [
    'login' => 'login',
    'two-factor' => 'two-factor',
  ],

  'middleware' => ['web'],
  'passwords' => 'users',
  'prefix' => '',
  'username' => 'email',
  'views' => true,
];
