<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
  use RefreshDatabase;

  public function test_current_profile_information_is_available()
  {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(UpdateProfileInformationForm::class);
    $this->assertEquals($user->name, $component->state['name']);
    $this->assertEquals($user->email, $component->state['email']);
  }

  public function test_profile_information_can_be_updated()
  {
    $this->actingAs($user = User::factory()->create());

    $test = Livewire::test(UpdateProfileInformationForm::class);

    $arr = [
      'email' => 'test@example.com',
      'name' => 'Test Name', 
    ];

    $set = $test->set('state', $arr);
    $set->call('updateProfileInformation');
    $fresh = $user->fresh();
    $this->assertEquals('Test Name', $fresh->name);
    $fresh = $user->fresh();
    $this->assertEquals('test@example.com', $fresh->email);
  }
}
