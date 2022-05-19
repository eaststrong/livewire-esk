<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
  public function test_the_application_returns_a_successful_response()
  {
    $get = $this->get('/');
    $get->assertStatus(200);
  }
}
