<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    $fCreate = function (Blueprint $table) {
      $table->bigIncrements('id');
      $string = $table->string('queue');
      $string->index();
      $table->longText('payload');
      $table->unsignedTinyInteger('attempts');
      $unsignedInteger = $table->unsignedInteger('reserved_at');
      $unsignedInteger->nullable();
      $table->unsignedInteger('available_at');
      $table->unsignedInteger('created_at');
    };

    Schema::create('jobs', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('jobs');
  }
};
