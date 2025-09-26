<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $payload = [
            'name'                  => 'Test',
            'email'                 => 't@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        // Register
        $this->postJson('/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => ['user', 'token'],
            ]);

        // Login
        $this->postJson('/api/login', [
            'email'    => 't@example.com',
            'password' => 'password',
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['user', 'token'],
            ]);
    }
}
