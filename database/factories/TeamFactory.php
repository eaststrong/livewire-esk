<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
  protected $model = Team::class;

  public function definition()
  {
    $unique = $this->faker->unique();
    $company = $unique->company();
    $factory = User::factory();

    return [
      'name' => $company,
      'personal_team' => true,
      'user_id' => $factory,
    ];
  }
}
