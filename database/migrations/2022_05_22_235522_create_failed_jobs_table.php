<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    $fCreate = function (Blueprint $table) {
      $table->id();
      $string = $table->string('uuid');
      $string->unique();
      $table->text('connection');
      $table->text('queue');
      $table->longText('payload');
      $table->longText('exception');
      $timestamp = $table->timestamp('failed_at');
      $timestamp->useCurrent();
    };

    Schema::create('failed_jobs', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('failed_jobs');
  }
};
