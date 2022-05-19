<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
  use RefreshDatabase;

  public function test_confirm_password_screen_can_be_rendered()
  {
    $factory = User::factory();
    $withPersonalTeam = $factory->withPersonalTeam();
    $create = $withPersonalTeam->create();
    $actingAs = $this->actingAs($create);
    $get = $actingAs->get('/user/confirm-password');
    $get->assertStatus(200);
  }

  public function test_password_can_be_confirmed()
  {
    $factory = User::factory();
    $create = $factory->create();
    $actingAs = $this->actingAs($create);
    $arr = ['password' => 'password'];
    $post = $actingAs->post('/user/confirm-password', $arr);
    $post->assertRedirect();
    $post->assertSessionHasNoErrors();
  }

  public function test_password_is_not_confirmed_with_invalid_password()
  {
    $factory = User::factory();
    $create = $factory->create();
    $actingAs = $this->actingAs($create);
    $arr = ['password' => 'wrong-password'];
    $post = $actingAs->post('/user/confirm-password', $arr);
    $post->assertSessionHasErrors();
  }
}
