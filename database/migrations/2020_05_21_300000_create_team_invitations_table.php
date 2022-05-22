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
      $foreignId = $table->foreignId('team_id');
      $constrained = $foreignId->constrained();
      $constrained->cascadeOnDelete();
      $table->string('email');
      $string = $table->string('role');
      $string->nullable();
      $table->timestamps();

      $arr = [
        'team_id',
        'email',
      ];

      $table->unique($arr);
    };

    Schema::create('team_invitations', $fCreate);
  }

  public function down()
  {
    Schema::dropIfExists('team_invitations');
  }
};
