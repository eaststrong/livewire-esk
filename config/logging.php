<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
  'channels' => [
    'daily' => [
      'days' => 14,
      'driver' => 'daily',
      'level' => env('LOG_LEVEL', 'debug'),
      'path' => storage_path('logs/laravel.log'),
    ],
    'emergency' => [
      'path' => storage_path('logs/laravel.log'),
    ],
    'errorlog' => [
      'driver' => 'errorlog',
      'level' => env('LOG_LEVEL', 'debug'),
    ],
    'null' => [
      'driver' => 'monolog',
      'handler' => NullHandler::class,
    ],
    'single' => [
      'driver' => 'single',
      'level' => env('LOG_LEVEL', 'debug'),
      'path' => storage_path('logs/laravel.log'),
    ],
    'slack' => [
      'driver' => 'slack',
      'emoji' => ':boom:',
      'level' => env('LOG_LEVEL', 'critical'),
      'url' => env('LOG_SLACK_WEBHOOK_URL'),
      'username' => 'Laravel Log',
    ],
    'stack' => [
      'channels' => ['single'],
      'driver' => 'stack',
      'ignore_exceptions' => false,
    ],
    'stderr' => [
      'driver' => 'monolog',
      'formatter' => env('LOG_STDERR_FORMATTER'),
      'handler' => StreamHandler::class,
      'level' => env('LOG_LEVEL', 'debug'),
      'with' => ['stream' => 'php://stderr'],
    ],
    'syslog' => [
      'driver' => 'syslog',
      'level' => env('LOG_LEVEL', 'debug'),
    ],
  ],
  'default' => env('LOG_CHANNEL', 'daily'),
  'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
];
