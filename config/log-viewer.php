<?php

use Arcanedev\LogViewer\Contracts\Utilities\Filesystem;

return [
  'colors' => [
    'levels' => [
      'alert' => '#D32F2F',
      'all' => '#8A8A8A',
      'critical' => '#F44336',
      'debug' => '#90CAF9',
      'emergency' => '#B71C1C',
      'empty' => '#D1D1D1',
      'error' => '#FF5722',
      'info' => '#1976D2',
      'notice' => '#4CAF50',
      'warning' => '#FF9100',
    ],
  ],

  'download' => [
    'extension' => 'log',
    'prefix' => 'laravel-',
  ],

  'highlight' => [
    '^#\d+',
    '^Stack trace:',
  ],

  'icons' => [
    'alert' => 'fa fa-fw fa-bullhorn',
    'all' => 'fa fa-fw fa-list',
    'critical' => 'fa fa-fw fa-heartbeat',
    'debug' => 'fa fa-fw fa-life-ring',
    'emergency' => 'fa fa-fw fa-bug',
    'error' => 'fa fa-fw fa-times-circle',
    'info' => 'fa fa-fw fa-info-circle',
    'notice' => 'fa fa-fw fa-exclamation-circle',
    'warning' => 'fa fa-fw fa-exclamation-triangle',
  ],

  'locale' => 'auto',

  'menu' => [
    'filter-route' => 'log-viewer::logs.filter',
    'icons-enabled' => true,
  ],

  'pattern' => [
    'date' => Filesystem::PATTERN_DATE,
    'extension' => Filesystem::PATTERN_EXTENSION,
    'prefix' => Filesystem::PATTERN_PREFIX,
  ],

  'per-page' => 30,

  'route' => [
    'attributes' => [
      'middleware' => env('ARCANEDEV_LOGVIEWER_MIDDLEWARE') ? explode(',', env('ARCANEDEV_LOGVIEWER_MIDDLEWARE')) : null,
      'prefix' => 'log-viewer',
    ],

    'enabled' => true,
  ],

  'storage-path' => storage_path('logs'),
  'theme' => 'bootstrap-4',
];
