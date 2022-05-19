<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
  use RefreshDatabase;

  public function test_email_verification_screen_can_be_rendered()
  {
    $emailVerification = Features::emailVerification();
    $enabled = Features::enabled($emailVerification);
    if (! $enabled) {return $this->markTestSkipped('Email verification not enabled.');}
    $factory = User::factory();
    $withPersonalTeam = $factory->withPersonalTeam();
    $unverified = $withPersonalTeam->unverified();
    $create = $unverified->create();
    $actingAs = $this->actingAs($create);
    $get = $actingAs->get('/email/verify');
    $get->assertStatus(200);
  }

  public function test_email_can_be_verified()
  {
    $emailVerification = Features::emailVerification();
    $enabled = Features::enabled($emailVerification);
    if (! $enabled) {return $this->markTestSkipped('Email verification not enabled.');}
    Event::fake();
    $factory = User::factory();
    $unverified = $factory->unverified();
    $create = $unverified->create();
    $now = now();
    $addMinutes = $now->addMinutes(60);
    $sha1 = sha1($create->email);

    $arr = [
      'hash' => $sha1,
      'id' => $create->id, 
    ];

    $temporarySignedRoute = URL::temporarySignedRoute('verification.verify', $addMinutes, $arr);
    $actingAs = $this->actingAs($create);
    $get = $actingAs->get($temporarySignedRoute);
    Event::assertDispatched(Verified::class);
    $fresh = $create->fresh();
    $hasVerifiedEmail = $fresh->hasVerifiedEmail();
    $this->assertTrue($hasVerifiedEmail);
    $get->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
  }

  public function test_email_can_not_verified_with_invalid_hash()
  {
    $emailVerification = Features::emailVerification();
    $enabled = Features::enabled($emailVerification);
    if (! $enabled) {return $this->markTestSkipped('Email verification not enabled.');}
    $factory = User::factory();
    $unverified = $factory->unverified();
    $create = $unverified->create();
    $now = now();
    $addMinutes = $now->addMinutes(60);
    $sha1 = sha1('wrong-email');

    $arr = [
      'hash' => $sha1,
      'id' => $create->id, 
    ];

    $temporarySignedRoute = URL::temporarySignedRoute('verification.verify', $addMinutes, $arr);
    $actingAs = $this->actingAs($create);
    $actingAs->get($temporarySignedRoute);
    $fresh = $create->fresh();
    $hasVerifiedEmail = $fresh->hasVerifiedEmail();
    $this->assertFalse($hasVerifiedEmail);
  }
}
