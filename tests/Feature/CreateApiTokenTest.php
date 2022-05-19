<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class CreateApiTokenTest extends TestCase
{
  use RefreshDatabase;

  public function test_api_tokens_can_be_created()
  {
    $hasApiFeatures = Features::hasApiFeatures();
    if (! $hasApiFeatures) {return $this->markTestSkipped('API support is not enabled.');}

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $test = Livewire::test(ApiTokenManager::class);

    $arr = [
      'read',
      'update',
    ];

    $arr = [
      'name' => 'Test Token',
      'permissions' => $arr,
    ];

    $arr = ['createApiTokenForm' => $arr];
    $set = $test->set($arr);
    $set->call('createApiToken');
    $fresh = $user->fresh();
    $this->assertCount(1, $fresh->tokens);
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $this->assertEquals('Test Token', $first->name);
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $can = $first->can('read');
    $this->assertTrue($can);
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $can = $first->can('delete');
    $this->assertFalse($can);
  }
}
