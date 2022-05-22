<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
  public function up()
  {
    $fCreate = function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->morphs('tokenable');
      $table->string('name');
      $string = $table->string('token', 64);
      $string->unique();
      $text = $table->text('abilities');
      $text->nullable();
      $timestamp = $table->timestamp('last_used_at');
      $timestamp->nullable();
      $table->timestamps();
    };

    Schema::create('personal_access_tokens', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('personal_access_tokens');
  }
}
