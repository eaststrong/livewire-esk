<?php

return [
  'default' => env('MAIL_MAILER', 'log'),
  'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
    'name' => env('MAIL_FROM_NAME', 'Example'),
  ],
  'mailers' => [
    'array' => ['transport' => 'array'],
    'failover' => [
      'mailers' => [
        'smtp',
        'log',
      ],
      'transport' => 'failover',
    ],
    'log' => [
      'channel' => env('MAIL_LOG_CHANNEL'),
      'transport' => 'log',
    ],
    'mailgun' => ['transport' => 'mailgun'],
    'postmark' => ['transport' => 'postmark'],
    'sendmail' => [
      'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
      'transport' => 'sendmail',
    ],
    'ses' => ['transport' => 'ses'],
    'smtp' => [
      'encryption' => env('MAIL_ENCRYPTION', 'tls'),
      'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
      'password' => env('MAIL_PASSWORD'),
      'port' => env('MAIL_PORT', 587),
      'timeout' => null,
      'transport' => 'smtp',
      'username' => env('MAIL_USERNAME'),
    ],
  ],
  'markdown' => [
    'paths' => [
      resource_path('views/vendor/mail'),
    ],
    'theme' => 'default',
  ],
];
