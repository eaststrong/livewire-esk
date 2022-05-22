<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
  use RefreshDatabase;

  public function test_reset_password_link_screen_can_be_rendered()
  {
    $resetPasswords = Features::resetPasswords();
    $enabled = Features::enabled($resetPasswords);
    if (! $enabled) {return $this->markTestSkipped('Password updates are not enabled.');}
    $get = $this->get('/forgot-password');
    $get->assertStatus(200);
  }

  public function test_reset_password_link_can_be_requested()
  {
    $resetPasswords = Features::resetPasswords();
    $enabled = Features::enabled($resetPasswords);
    if (! $enabled) {return $this->markTestSkipped('Password updates are not enabled.');}
    Notification::fake();
    $factory = User::factory();
    $create = $factory->create();
    $arr = ['email' => $create->email];
    $this->post('/forgot-password', $arr);
    Notification::assertSentTo($create, ResetPassword::class);
  }

  public function test_reset_password_screen_can_be_rendered()
  {
    $resetPasswords = Features::resetPasswords();
    $enabled = Features::enabled($resetPasswords);
    if (! $enabled) {return $this->markTestSkipped('Password updates are not enabled.');}
    Notification::fake();
    $factory = User::factory();
    $create = $factory->create();
    $arr = ['email' => $create->email];
    $response = $this->post('/forgot-password', $arr);

    $fAssertSentTo = function ($notification) {
      $get = $this->get('/reset-password/'.$notification->token);
      $get->assertStatus(200);
      return true;
    };

    Notification::assertSentTo($create, ResetPassword::class, $fAssertSentTo);
  }

  public function test_password_can_be_reset_with_valid_token()
  {
    $resetPasswords = Features::resetPasswords();
    $enabled = Features::enabled($resetPasswords);
    if (! $enabled) {return $this->markTestSkipped('Password updates are not enabled.');}
    Notification::fake();
    $factory = User::factory();
    $create = $factory->create();
    $arr = ['email' => $create->email];
    $this->post('/forgot-password', $arr);

    Notification::assertSentTo($create, ResetPassword::class, function ($notification) use ($create) {
      $arr = [
        'email' => $create->email,
        'password' => 'password',
        'password_confirmation' => 'password',
        'token' => $notification->token,
      ];

      $post = $this->post('/reset-password', $arr);
      $post->assertSessionHasNoErrors();
      return true;
    });
  }
}
