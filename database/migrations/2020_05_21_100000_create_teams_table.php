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
      $foreignId = $table->foreignId('user_id');
      $foreignId->index();
      $table->string('name');
      $table->boolean('personal_team');
      $table->timestamps();
      $table->softDeletes();
    };

    Schema::create('teams', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('teams');
  }
};
