<?php

return [
  'allowed_headers' => ['*'],
  'allowed_methods' => ['*'],
  'allowed_origins' => ['*'],
  'allowed_origins_patterns' => [],
  'exposed_headers' => [],
  'max_age' => 0,

  'paths' => [
    'api/*', 
    'sanctum/csrf-cookie'
  ],

  'supports_credentials' => false,
];
