<?php

use Illuminate\Support\Facades\Route;

$fFunction = function () {return view('welcome');};
Route::get('/', $fFunction);

$arr = [
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified'
];

$middleware = Route::middleware($arr);

$fFunction = function () {
  $fFunction = function () {return view('dashboard');};
  $get = Route::get('/dashboard', $fFunction);
  $get->name('dashboard');
};

$middleware->group($fFunction);
