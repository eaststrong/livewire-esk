<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteApiTokenTest extends TestCase
{
  use RefreshDatabase;

  public function test_api_tokens_can_be_deleted()
  {
    $hasApiFeatures = Features::hasApiFeatures();
    if (! $hasApiFeatures) {return $this->markTestSkipped('API support is not enabled.');}

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $tokens = $user->tokens();

    $arr = [
      'create', 
      'read'
    ];

    $arr = [
      'abilities' => $arr,
      'name' => 'Test Token',
      'token' => Str::random(40),
    ];

    $create = $tokens->create($arr);

    $test = Livewire::test(ApiTokenManager::class);
    $arr = ['apiTokenIdBeingDeleted' => $create->id];
    $set = $test->set($arr);
    $set->call('deleteApiToken');
    $fresh = $user->fresh();
    $this->assertCount(0, $fresh->tokens);
  }
}
