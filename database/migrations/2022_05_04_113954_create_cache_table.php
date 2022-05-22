<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    $fCreate = function (Blueprint $table) {
      $string = $table->string('key');
      $string->primary();
      $table->mediumText('value');
      $table->integer('expiration');
    };

    Schema::create('cache', $fCreate);

    $fCreate = function (Blueprint $table) {
      $string = $table->string('key');
      $string->primary();
      $table->string('owner');
      $table->integer('expiration');
    };

    Schema::create('cache_locks', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('cache');
    Schema::dropIfExists('cache_locks');
  }
};
