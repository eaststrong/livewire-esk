<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
  use RefreshDatabase;

  public function test_teams_can_be_created()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $test = Livewire::test(CreateTeamForm::class);
    $arr = ['name' => 'Test Team'];
    $arr = ['state' => $arr];
    $set = $test->set($arr);
    $set->call('createTeam');
    $fresh = $user->fresh();
    $this->assertCount(2, $fresh->ownedTeams);
    $fresh = $user->fresh();
    $ownedTeams = $fresh->ownedTeams();
    $latest = $ownedTeams->latest('id');
    $first = $latest->first();
    $this->assertEquals('Test Team', $first->name);
  }
}
