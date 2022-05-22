<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  public const HOME = '/dashboard';

  public function boot()
  {
    $this->configureRateLimiting();

    $fRoutes = function () {
      $middleware = Route::middleware('api');
      $prefix = $middleware->prefix('api');
      $base_path = base_path('routes/api.php');
      $prefix->group($base_path);
      $middleware = Route::middleware('web');
      $base_path = base_path('routes/web.php');
      $middleware->group($base_path);
    };

    $this->routes($fRoutes);
  }

  protected function configureRateLimiting()
  {
    $fFor = function (Request $request) {
      $perMinute = Limit::perMinute(60);
      $user = $request->user();
      $par = $user?->id ?: $request->ip();
      return $perMinute->by($par);
    };

    RateLimiter::for('api', $fFor);
  }
}
