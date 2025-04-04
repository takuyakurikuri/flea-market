<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validation_email()
    {
        $address = Address::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' =>
            now(),
            'address_id' => $address->id,
        ]);

        $response = $this->get('/login');

        $response->assertStatus(200);

        $userData = [
            'email' => '',
            'password' => 'password',
        ];

        $response = $this->post(route('login'), $userData);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_validation_password()
    {
        $address = Address::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' =>
            now(),
            'address_id' => $address->id,
        ]);

        $response = $this->get('/login');

        $response->assertStatus(200);

        $userData = [
            'email' => 'test@example.com',
            'password' => '',
        ];

        $response = $this->post(route('login'), $userData);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_validation_no_user()
    {
        $address = Address::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' =>
            now(),
            'address_id' => $address->id,
        ]);

        $response = $this->get('/login');

        $response->assertStatus(200);

        $userData = [
            'email' => 'testtest@example.com',
            'password' => 'passwordpassword',
        ];

        $response = $this->post(route('login'), $userData);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_validation_success()
    {
        $address = Address::factory()->create();
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' =>
            now(),
            'address_id' => $address->id,
        ]);

        $response = $this->get('/login');

        $response->assertStatus(200);

        $userData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->post(route('login'), $userData);

        $response->assertRedirect('/');
    }
}