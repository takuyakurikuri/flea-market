<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\User;

class ChangeUserDetailTest extends TestCase
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
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertSee($user->image_path);
        $response->assertSee($user->name);
        $response->assertSee($user->address->zipcode);
        $response->assertSee($user->address->address);
        $response->assertSee($user->address->building);
        
    }
}