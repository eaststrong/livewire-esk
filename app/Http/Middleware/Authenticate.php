<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
  protected function redirectTo($request)
  {
    $expectsJson = $request->expectsJson();
    if (! $expectsJson) {return route('login');}
  }
}
