<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTeamMemberRoleTest extends TestCase
{
  use RefreshDatabase;

  public function test_team_member_roles_can_be_updated()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $users = $user->currentTeam->users();
    $arr = ['role' => 'admin'];
    $users->attach($otherUser = User::factory()->create(), $arr);
    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);
    $set = $test->set('managingRoleFor', $otherUser);
    $set = $set->set('currentRole', 'editor');
    $set->call('updateRole');
    $otherFresh = $otherUser->fresh();
    $currentFresh = $user->currentTeam->fresh();
    $hasTeamRole = $otherFresh->hasTeamRole($currentFresh, 'editor');
    $this->assertTrue($hasTeamRole);
  }

  public function test_only_team_owner_can_update_team_member_roles()
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
    $set = $test->set('managingRoleFor', $otherUser);
    $set = $set->set('currentRole', 'editor');
    $call = $set->call('updateRole');
    $call->assertStatus(403);
    $otherFresh = $otherUser->fresh();
    $currentFresh = $create->currentTeam->fresh();
    $hasTeamRole = $otherFresh->hasTeamRole($currentFresh, 'admin');
    $this->assertTrue($hasTeamRole);
  }
}
