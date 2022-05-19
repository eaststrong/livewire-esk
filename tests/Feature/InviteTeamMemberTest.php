<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Tests\TestCase;

class InviteTeamMemberTest extends TestCase
{
  use RefreshDatabase;

  public function test_team_members_can_be_invited_to_team()
  {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);

    $arr = [
      'email' => 'test@example.com',
      'role' => 'admin',
    ];

    $set = $test->set('addTeamMemberForm', $arr);
    $set->call('addTeamMember');
    Mail::assertSent(TeamInvitation::class);
    $fresh = $user->currentTeam->fresh();
    $this->assertCount(1, $fresh->teamInvitations);
  }

  public function test_team_member_invitations_can_be_cancelled()
  {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(TeamMemberManager::class, $arr);

    $arr = [
      'email' => 'test@example.com',
      'role' => 'admin',
    ];

    $set = $test->set('addTeamMemberForm', $arr);
    $call = $set->call('addTeamMember');
    $fresh = $user->currentTeam->fresh();
    $first = $fresh->teamInvitations->first();
    $call->call('cancelTeamInvitation', $first->id);
    $fresh = $user->currentTeam->fresh();
    $this->assertCount(0, $fresh->teamInvitations);
  }
}
