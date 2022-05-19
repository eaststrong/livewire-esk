<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTeamNameTest extends TestCase
{
  use RefreshDatabase;

  public function test_team_names_can_be_updated()
  {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $arr = ['team' => $user->currentTeam];
    $test = Livewire::test(UpdateTeamNameForm::class, $arr);
    $arr = ['name' => 'Test Team'];
    $arr = ['state' => $arr];
    $set = $test->set($arr);
    $set->call('updateTeamName');
    $fresh = $user->fresh();
    $this->assertCount(1, $fresh->ownedTeams);
    $fresh = $user->currentTeam->fresh();
    $this->assertEquals('Test Team', $fresh->name);
  }
}
