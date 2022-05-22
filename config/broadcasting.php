<?php

return [
  'connections' => [
    'log' => ['driver' => 'log'],
    'null' => ['driver' => 'null'],
  ],
  'default' => env('BROADCAST_DRIVER', 'log'),
];
