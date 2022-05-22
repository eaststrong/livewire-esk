<?php

use Illuminate\Support\Facades\Route;

$fGet = function () {return view('welcome');};
Route::get('/', $fGet);

$arr = [
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified'
];

$middleware = Route::middleware($arr);

$fGroup = function () {
  $fGet = function () {return view('dashboard');};
  $get = Route::get('/dashboard', $fGet);
  $get->name('dashboard');
};

$middleware->group($fGroup);
