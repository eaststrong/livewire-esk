<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddTeamMember implements AddsTeamMembers
{
  public function add($user, $team, string $email, string $role = null)
  {
    $forUser = Gate::forUser($user);
    $forUser->authorize('addTeamMember', $team);
    $this->validate($team, $email, $role);
    $newTeamMember = Jetstream::findUserByEmailOrFail($email);
    AddingTeamMember::dispatch($team, $newTeamMember);
    $users = $team->users();
    $arr = ['role' => $role];
    $users->attach($newTeamMember, $arr);
    TeamMemberAdded::dispatch($team, $newTeamMember);
  }

  protected function validate($team, string $email, ?string $role)
  {
    $arr1 = [
      'email' => $email,
      'role' => $role,
    ];

    $rules = $this->rules();
    $__ = __('We were unable to find a registered user with this email address.');
    $arr2 = ['email.exists' => $__];
    $make = Validator::make($arr1, $rules, $arr2);
    $ensureUserIsNotAlreadyOnTeam = $this->ensureUserIsNotAlreadyOnTeam($team, $email);
    $after = $make->after($ensureUserIsNotAlreadyOnTeam);
    $after->validateWithBag('addTeamMember');
  }

  protected function rules()
  {
    $arr1 = [
      'required',
      'email',
      'exists:users',
    ];

    $hasRoles = Jetstream::hasRoles();

    $arr2 = [
      'required',
      'string',
      new Role,
    ];

    $arr = [
      'email' => $arr1,
      'role' => $hasRoles ? $arr2 : null,
    ];

    return array_filter($arr);
  }

  protected function ensureUserIsNotAlreadyOnTeam($team, string $email)
  {
    return function ($validator) use ($team, $email) {
      $errors = $validator->errors();
      $hasUserWithEmail = $team->hasUserWithEmail($email);
      $__ = __('This user already belongs to the team.');
      $errors->addIf($hasUserWithEmail, 'email', $__);
    };
  }
}
