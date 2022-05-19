<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Tests\TestCase;

class ApiTokenPermissionsTest extends TestCase
{
  use RefreshDatabase;

  public function test_api_token_permissions_can_be_updated()
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
    $arr = ['managingPermissionsFor' => $create];
    $set = $test->set($arr);

    $arr = [
      'delete',
      'missing-permission',
    ];

    $arr = ['permissions' => $arr];
    $arr = ['updateApiTokenForm' => $arr];
    $set = $set->set($arr);
    $set->call('updateApiToken');
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $can = $first->can('delete');
    $this->assertTrue($can);
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $can = $first->can('read');
    $this->assertFalse($can);
    $fresh = $user->fresh();
    $first = $fresh->tokens->first();
    $can = $first->can('missing-permission');
    $this->assertFalse($can);
  }
}
