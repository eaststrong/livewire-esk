<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
  use RefreshDatabase;

  public function test_registration_screen_can_be_rendered()
  {
    $registration = Features::registration();
    $enabled = Features::enabled($registration);
    if (! $enabled) {return $this->markTestSkipped('Registration support is not enabled.');}
    $get = $this->get('/register');
    $get->assertStatus(200);
  }

  public function test_registration_screen_cannot_be_rendered_if_support_is_disabled()
  {
    $registration = Features::registration();
    $enabled = Features::enabled($registration);
    if ($enabled) {return $this->markTestSkipped('Registration support is enabled.');}
    $get = $this->get('/register');
    $get->assertStatus(404);
  }

  public function test_new_users_can_register()
  {
    $registration = Features::registration();
    $enabled = Features::enabled($registration);
    if (! $enabled) {return $this->markTestSkipped('Registration support is not enabled.');}

    $arr = [
      'email' => 'test@example.com',
      'name' => 'Test User',
      'password' => 'password',
      'password_confirmation' => 'password',
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ];

    $post = $this->post('/register', $arr);
    $this->assertAuthenticated();
    $post->assertRedirect(RouteServiceProvider::HOME);
  }
}
