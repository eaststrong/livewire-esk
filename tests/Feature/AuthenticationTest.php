<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  public function test_login_screen_can_be_rendered()
  {
    $response = $this->get('/login');
    $response->assertStatus(200);
  }

  public function test_users_can_authenticate_using_the_login_screen()
  {
    $factory = User::factory();
    $user = $factory->create();

    $arr = [
      'email' => $user->email,
      'password' => 'password',
    ];

    $response = $this->post('/login', $arr);
    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
  }

  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $factory = User::factory();
    $user = $factory->create();

    $arr = [
      'email' => $user->email,
      'password' => 'wrong-password',
    ];

    $this->post('/login', $arr);
    $this->assertGuest();
  }
}
