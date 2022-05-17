<?php

return [
  'argon' => [
    'memory' => 65536,
    'threads' => 1,
    'time' => 4,
  ],

  'bcrypt' => [
    'rounds' => env('BCRYPT_ROUNDS', 10),
  ],

  'driver' => 'bcrypt',
];
