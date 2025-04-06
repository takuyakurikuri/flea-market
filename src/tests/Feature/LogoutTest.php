<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
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

        $response = $this->post(route('logout'),);
    }
}