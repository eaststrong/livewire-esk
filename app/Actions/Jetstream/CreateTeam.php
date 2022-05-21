<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
  public function create($user, array $input)
  {
    $forUser = Gate::forUser($user);
    $newTeamModel = Jetstream::newTeamModel();
    $forUser->authorize('create', $newTeamModel);

    $arr = [
      'required',
      'string',
      'max:255',
    ];

    $arr = ['name' => $arr];
    $make = Validator::make($input, $arr);
    $make->validateWithBag('createTeam');
    AddingTeam::dispatch($user);

    $arr = [
      'name' => $input['name'],
      'personal_team' => false,
    ];

    $user->switchTeam($team = $user->ownedTeams()->create($arr));
    return $team;
  }
}
