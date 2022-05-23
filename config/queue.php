<?php

return [
  'connections' => [
    'database' => [
      'after_commit' => false,
      'driver' => 'database',
      'queue' => 'default',
      'retry_after' => 90,
      'table' => 'jobs',
    ],
    'sync' => ['driver' => 'sync'],
  ],
  'default' => env('QUEUE_CONNECTION', 'database'),
  'failed' => [
    'database' => env('DB_CONNECTION', 'pgsql'),
    'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
    'table' => 'failed_jobs',
  ],
];
