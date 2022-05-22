<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    Fortify::createUsersUsing(CreateNewUser::class);
    Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

    $fFor = function (Request $request) {
      $email = (string) $request->email;
      $perMinute = Limit::perMinute(5);
      $ip = $email.$request->ip();
      return $perMinute->by($ip);
    };

    RateLimiter::for('login', $fFor);

    $fFor = function (Request $request) {
      $perMinute = Limit::perMinute(5);
      $session = $request->session();
      $get = $session->get('login.id');
      return $perMinute->by($get);
    };

    RateLimiter::for('two-factor', $fFor);
  }
}
