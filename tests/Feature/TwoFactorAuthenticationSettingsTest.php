<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TwoFactorAuthenticationForm;
use Livewire\Livewire;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
  use RefreshDatabase;

  public function test_two_factor_authentication_can_be_enabled()
  {
    $this->actingAs($user = User::factory()->create());

    $arr = ['auth.password_confirmed_at' => time()];
    $this->withSession($arr);
    $test = Livewire::test(TwoFactorAuthenticationForm::class);
    $test->call('enableTwoFactorAuthentication');
    $fresh = $user->fresh();
    $this->assertNotNull($fresh->two_factor_secret);
    $recoveryCodes = $fresh->recoveryCodes();
    $this->assertCount(8, $recoveryCodes);
  }

  public function test_recovery_codes_can_be_regenerated()
  {
    $this->actingAs($user = User::factory()->create());

    $arr = ['auth.password_confirmed_at' => time()];
    $this->withSession($arr);
    $test = Livewire::test(TwoFactorAuthenticationForm::class);
    $call = $test->call('enableTwoFactorAuthentication');
    $call = $call->call('regenerateRecoveryCodes');
    $fresh = $user->fresh();
    $call->call('regenerateRecoveryCodes');
    $recoveryCodes = $fresh->recoveryCodes();
    $this->assertCount(8, $recoveryCodes);
    $recoveryCodes1 = $fresh->recoveryCodes();
    $fresh = $fresh->fresh();
    $recoveryCodes2 = $fresh->recoveryCodes();
    $array_diff = array_diff($recoveryCodes1, $recoveryCodes2);
    $this->assertCount(8, $array_diff);
  }

  public function test_two_factor_authentication_can_be_disabled()
  {
    $this->actingAs($user = User::factory()->create());

    $arr = ['auth.password_confirmed_at' => time()];
    $this->withSession($arr);
    $test = Livewire::test(TwoFactorAuthenticationForm::class);
    $call = $test->call('enableTwoFactorAuthentication');
    $fresh = $user->fresh();
    $this->assertNotNull($fresh->two_factor_secret);
    $call->call('disableTwoFactorAuthentication');
    $fresh = $user->fresh();
    $this->assertNull($fresh->two_factor_secret);
  }
}
