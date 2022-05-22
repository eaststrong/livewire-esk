<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
  public function up()
  {
    $fTable = function (Blueprint $table) {
      $text = $table->text('two_factor_secret');
      $after = $text->after('password');
      $after->nullable();
      $text = $table->text('two_factor_recovery_codes');
      $after = $text->after('two_factor_secret');
      $after->nullable();
      $confirmsTwoFactorAuthentication = Fortify::confirmsTwoFactorAuthentication();

      if ($confirmsTwoFactorAuthentication) {
        $timestamp = $table->timestamp('two_factor_confirmed_at');
        $after = $timestamp->after('two_factor_recovery_codes');
        $after->nullable();
      }
    };

    Schema::table('users', $fTable);
  }

  public function down()
  {
    $fTable = function (Blueprint $table) {
      $arr1 = [
        'two_factor_secret',
        'two_factor_recovery_codes',
      ];

      $confirmsTwoFactorAuthentication = Fortify::confirmsTwoFactorAuthentication();
      $arr2 = ['two_factor_confirmed_at'];
      $arr3 = [];
      $array_merge = array_merge($arr1, $confirmsTwoFactorAuthentication ? $arr2 : $arr3);
      $table->dropColumn($array_merge);
    };

    Schema::table('users', $fTable);
  }
};
