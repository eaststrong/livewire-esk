<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$microtime = microtime(true);
define('LARAVEL_START', $microtime);

$file_exists = file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php');
if ($file_exists) {require $maintenance;}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$handle = $kernel->handle($request = Request::capture());
$response = $handle->send();
$kernel->terminate($request, $response);
