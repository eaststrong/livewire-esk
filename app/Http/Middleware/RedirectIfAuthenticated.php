<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  public function handle(Request $request, Closure $next, ...$guards)
  {
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
      $guard = Auth::guard($guard);
      $check = $guard->check();
      if ($check) {return redirect(RouteServiceProvider::HOME);}
    }

    return $next($request);
  }
}
