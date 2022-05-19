<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
  use RefreshDatabase;

  public function test_password_can_be_updated()
  {
    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(UpdatePasswordForm::class);

    $arr = [
      'current_password' => 'password',
      'password' => 'new-password',
      'password_confirmation' => 'new-password',
    ];

    $set = $test->set('state', $arr);
    $set->call('updatePassword');

    $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
  }

  public function test_current_password_must_be_correct()
  {
    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(UpdatePasswordForm::class);

    $arr = [
      'current_password' => 'wrong-password',
      'password' => 'new-password',
      'password_confirmation' => 'new-password',
    ];

    $set = $test->set('state', $arr);
    $call = $set->call('updatePassword');
    $arr = ['current_password'];
    $call->assertHasErrors($arr);
    $fresh = $user->fresh();
    $check = Hash::check('password', $fresh->password);
    $this->assertTrue($check);
  }

  public function test_new_passwords_must_match()
  {
    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(UpdatePasswordForm::class);

    $arr = [
      'current_password' => 'password',
      'password' => 'new-password',
      'password_confirmation' => 'wrong-password',
    ];

    $set = $test->set('state', $arr);
    $call = $set->call('updatePassword');
    $arr = ['password'];
    $call->assertHasErrors($arr);
    $fresh = $user->fresh();
    $check = Hash::check('password', $fresh->password);
    $this->assertTrue($check);
  }
}
