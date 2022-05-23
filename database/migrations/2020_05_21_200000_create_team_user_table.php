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
      $table->foreignId('team_id');
      $table->foreignId('user_id');
      $string = $table->string('role');
      $string->nullable();
      $table->timestamps();
      $table->softDeletes();

      $arr = [
        'team_id',
        'user_id',
      ];

      $table->unique($arr);
    };

    Schema::create('team_user', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('team_user');
  }
};
