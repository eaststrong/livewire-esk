<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
  use RefreshDatabase;

  public function test_users_can_leave_teams()
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
    $test->call('leaveTeam');
    $fresh = $create->currentTeam->fresh();
    $this->assertCount(0, $fresh->users);
  }

  public function test_team_owners_cant_leave_their_own_team()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);
    $call = $test->call('leaveTeam');
    $arr = ['team'];
    $call->assertHasErrors($arr);
    $fresh = $user->currentTeam->fresh();
    $this->assertNotNull($fresh);
  }
}
