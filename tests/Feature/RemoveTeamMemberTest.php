<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{
  use RefreshDatabase;

  public function test_team_members_can_be_removed_from_teams()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['role' => 'admin'];
    $users = $user->currentTeam->users();

    $users->attach($otherUser = User::factory()->create(), $arr);

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);
    $set = $test->set('teamMemberIdBeingRemoved', $otherUser->id);
    $set->call('removeTeamMember');
    $fresh = $user->currentTeam->fresh();
    $this->assertCount(0, $fresh->users);
  }

  public function test_only_team_owner_can_remove_team_members()
  {
    $factory = User::factory();
    $withPersonalTeam = $factory->withPersonalTeam();
    $create = $withPersonalTeam->create();
    $users = $create->currentTeam->users();
    $arr = ['role' => 'admin'];

    $users->attach($otherUser = User::factory()->create(), $arr);

    $this->actingAs($otherUser);
    $arr = ['team' => $create->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);
    $set = $test->set('teamMemberIdBeingRemoved', $create->id);
    $call = $set->call('removeTeamMember');
    $call->assertStatus(403);
  }
}
