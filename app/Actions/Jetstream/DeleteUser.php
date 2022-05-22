<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
  protected $deletesTeams;

  public function __construct(DeletesTeams $deletesTeams)
  {
    $this->deletesTeams = $deletesTeams;
  }

  public function delete($user)
  {
    DB::transaction(function () use ($user) {
      $this->deleteTeams($user);
      $user->deleteProfilePhoto();
      $user->tokens->each->delete();
      $user->delete();
    });
  }

  protected function deleteTeams($user)
  {
    $teams = $user->teams();
    $teams->detach();
    $fEach = function ($team) {$this->deletesTeams->delete($team);};
    $user->ownedTeams->each($fEach);
  }
}
