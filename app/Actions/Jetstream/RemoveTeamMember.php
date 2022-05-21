<?php

namespace App\Actions\Jetstream;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;

class RemoveTeamMember implements RemovesTeamMembers
{
  public function remove($user, $team, $teamMember)
  {
    $this->authorize($user, $team, $teamMember);
    $this->ensureUserDoesNotOwnTeam($teamMember, $team);
    $team->removeUser($teamMember);
    TeamMemberRemoved::dispatch($team, $teamMember);
  }

  protected function authorize($user, $team, $teamMember)
  {
    $forUser = Gate::forUser($user);
    $bln = ! $forUser->check('removeTeamMember', $team);
    $bln = $bln && $user->id !== $teamMember->id;
    if ($bln) {throw new AuthorizationException;}
  }

  protected function ensureUserDoesNotOwnTeam($teamMember, $team)
  {
    if ($teamMember->id === $team->owner->id) {
      $__ = __('You may not leave a team that you created.');
      $arr = [$__];
      $arr = ['team' => $arr];
      $withMessages = ValidationException::withMessages($arr);
      throw $withMessages->errorBag('removeTeamMember');
    }
  }
}
