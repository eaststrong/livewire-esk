<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
  use RefreshDatabase;

  public function test_teams_can_be_deleted()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $ownedTeams = $user->ownedTeams();

    $ownedTeams->save($team = Team::factory()->make(['personal_team' => false]));

    $users = $team->users();
    $arr = ['role' => 'test-role'];

    $users->attach($otherUser = User::factory()->create(), $arr);

    $fresh = $team->fresh();
    $arr = ['team' => $fresh];
    $test = Livewire::test(DeleteTeamForm::class, $arr);
    $test->call('deleteTeam');
    $fresh = $team->fresh();
    $this->assertNull($fresh);
    $fresh = $otherUser->fresh();
    $this->assertCount(0, $fresh->teams);
  }

  public function test_personal_teams_cant_be_deleted()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(DeleteTeamForm::class, $arr);
    $call = $test->call('deleteTeam');
    $arr = ['team'];
    $call->assertHasErrors($arr);
    $fresh = $user->currentTeam->fresh();
    $this->assertNotNull($fresh);
  }
}
