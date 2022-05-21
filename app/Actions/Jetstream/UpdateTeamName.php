<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
  public function update($user, $team, array $input)
  {
    $forUser = Gate::forUser($user);
    $forUser->authorize('update', $team);

    $arr = [
      'required',
      'string',
      'max:255',
    ];

    $arr = ['name' => $arr];
    $make = Validator::make($input, $arr);
    $make->validateWithBag('updateTeamName');
    $arr = ['name' => $input['name']];
    $forceFill = $team->forceFill($arr);
    $forceFill->save();
  }
}
