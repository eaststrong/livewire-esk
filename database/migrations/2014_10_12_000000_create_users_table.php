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
      $table->string('name');
      $string = $table->string('email');
      $string->unique();
      $timestamp = $table->timestamp('email_verified_at');
      $timestamp->nullable();
      $table->string('password');
      $table->rememberToken();
      $foreignId = $table->foreignId('current_team_id');
      $foreignId->nullable();
      $string = $table->string('profile_photo_path', 2048);
      $string->nullable();
      $table->timestamps();
      $table->softDeletes();
    };

    Schema::create('users', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('users');
  }
};
