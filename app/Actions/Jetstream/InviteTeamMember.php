<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteTeamMember implements InvitesTeamMembers
{
  public function invite($user, $team, string $email, string $role = null)
  {
    $forUser = Gate::forUser($user);
    $forUser->authorize('addTeamMember', $team);
    $this->validate($team, $email, $role);
    InvitingTeamMember::dispatch($team, $email, $role);
    $teamInvitations = $team->teamInvitations();

    $arr = [
      'email' => $email,
      'role' => $role,
    ];

    $create = $teamInvitations->create($arr);
    $to = Mail::to($email);
    $teamInvitation = new TeamInvitation($create);
    $to->send($teamInvitation);
  }

  protected function validate($team, string $email, ?string $role)
  {
    $arr1 = [
      'email' => $email,
      'role' => $role,
    ];

    $rules = $this->rules($team);
    $__ = __('This user has already been invited to the team.');
    $arr2 = ['email.unique' => $__];
    $make = Validator::make($arr1, $rules, $arr2);
    $ensureUserIsNotAlreadyOnTeam = $this->ensureUserIsNotAlreadyOnTeam($team, $email);
    $after = $make->after($ensureUserIsNotAlreadyOnTeam);
    $after->validateWithBag('addTeamMember');
  }

  protected function rules($team)
  {
    $unique = Rule::unique('team_invitations');

    $where = $unique->where(function ($query) use ($team) {
      $query->where('team_id', $team->id);
    });

    $arr1 = [
      'required',
      'email',
      $where,
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
