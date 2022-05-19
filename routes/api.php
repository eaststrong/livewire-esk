<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$middleware = Route::middleware('auth:sanctum');
$fFunction = function (Request $request) {return $request->user();};
$middleware->get('/user', $fFunction);
