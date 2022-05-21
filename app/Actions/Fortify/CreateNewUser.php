<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  public function create(array $input)
  {
    $arr1 = [
      'required',
      'string',
      'email',
      'max:255',
      'unique:users',
    ];

    $arr2 = [
      'required',
      'string',
      'max:255',
    ];

    $arr3 = [
      'accepted',
      'required',
    ];

    $arr = [
      'email' => $arr1,
      'name' => $arr2,
      'password' => $this->passwordRules(),
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? $arr3 : '',
    ];

    $make = Validator::make($input, $arr);
    $make->validate();

    return DB::transaction(function () use ($input) {
      $make = Hash::make($input['password']);

      $arr = [
        'email' => $input['email'],
        'name' => $input['name'],
        'password' => $make,
      ];

      $create = User::create($arr);
      $fFunction = function (User $user) {$this->createTeam($user);};
      return tap($create, $fFunction);
    });
  }

  protected function createTeam(User $user)
  {
    $ownedTeams = $user->ownedTeams();
    $explode = explode(' ', $user->name, 2);

    $arr = [
      'name' => $explode[0] . "'s Team",
      'personal_team' => true,
      'user_id' => $user->id,
    ];

    $forceCreate = Team::forceCreate($arr);
    $ownedTeams->save($forceCreate);
  }
}
