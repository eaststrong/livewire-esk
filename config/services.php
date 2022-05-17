<?php

return [
  'mailgun' => [
    'domain' => env('MAILGUN_DOMAIN'),
    'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    'scheme' => 'https',
    'secret' => env('MAILGUN_SECRET'),
  ],

  'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
  ],
];
