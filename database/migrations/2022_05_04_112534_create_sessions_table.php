<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    $fCreate = function (Blueprint $table) {
      $string = $table->string('id');
      $string->primary();
      $foreignId = $table->foreignId('user_id');
      $nullable = $foreignId->nullable();
      $nullable->index();
      $string = $table->string('ip_address', 45);
      $string->nullable();
      $text = $table->text('user_agent');
      $text->nullable();
      $table->text('payload');
      $integer = $table->integer('last_activity');
      $integer->index();
    };

    Schema::create('sessions', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('sessions');
  }
};
