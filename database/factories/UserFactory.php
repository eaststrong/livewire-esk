<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
  protected $model = User::class;

  public function definition()
  {
    $unique = $this->faker->unique();
    $safeEmail = $unique->safeEmail();
    $now = now();
    $name = $this->faker->name();
    $random = Str::random(10);

    return [
      'email' => $safeEmail,
      'email_verified_at' => $now,
      'name' => $name,
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => $random,
    ];
  }

  public function unverified()
  {
    $fState = function (array $attributes) {return ['email_verified_at' => null];};
    return $this->state($fState);
  }

  public function withPersonalTeam()
  {
    $hasTeamFeatures = Features::hasTeamFeatures();

    if (! $hasTeamFeatures) {
      $arr = [];
      return $this->state($arr);
    }

    $factory = Team::factory();

    $fState = function (array $attributes, User $user) {
      return [
        'name' => $user->name . '\'s Team',
        'personal_team' => true,
        'user_id' => $user->id,
      ];
    };

    $state = $factory->state($fState);
    return $this->has($state, 'ownedTeams');
  }
}
