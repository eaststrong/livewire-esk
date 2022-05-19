<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\DeleteUserForm;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_accounts_can_be_deleted()
  {
    $hasAccountDeletionFeatures = Features::hasAccountDeletionFeatures();
    if (! $hasAccountDeletionFeatures) {return $this->markTestSkipped('Account deletion is not enabled.');}

    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(DeleteUserForm::class);
    $set = $test->set('password', 'password');
    $set->call('deleteUser');
    $fresh = $user->fresh();
    $this->assertNull($fresh);
  }

  public function test_correct_password_must_be_provided_before_account_can_be_deleted()
  {
    $hasAccountDeletionFeatures = Features::hasAccountDeletionFeatures();
    if (! $hasAccountDeletionFeatures) {return $this->markTestSkipped('Account deletion is not enabled.');}

    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(DeleteUserForm::class);
    $set = $test->set('password', 'wrong-password');
    $call = $set->call('deleteUser');
    $arr = ['password'];
    $call->assertHasErrors($arr);
    $fresh = $user->fresh();
    $this->assertNotNull($fresh);
  }
}
