<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$middleware = Route::middleware('auth:sanctum');
$fGet = function (Request $request) {return $request->user();};
$middleware->get('/user', $fGet);
