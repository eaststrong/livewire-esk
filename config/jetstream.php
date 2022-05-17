<?php

use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;

return [
  'auth_session' => AuthenticateSession::class,

  'features' => [
    Features::teams(['invitations' => true]),
    Features::accountDeletion(),
  ],

  'guard' => 'sanctum',
  'middleware' => ['web'],
  'profile_photo_disk' => 'public',
  'stack' => 'livewire',
];
