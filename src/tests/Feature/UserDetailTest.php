<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use App\Models\Purchase;

class UserDetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->count(8)->create();
        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();
        $item3 = Item::factory()->create(['user_id' => $user->id]);
        $item4 = Item::factory()->create(['user_id' => $user->id]);
        Purchase::factory()->create(['item_id'=> $item1->id,'user_id' => $user->id]);
        Purchase::factory()->create(['item_id'=> $item2->id,'user_id' => $user->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/mypage?tab=sell');
        $response->assertStatus(200);

        $response->assertSee($user->image_path);
        $response->assertSee($user->name);

        $response->assertSee($item3->image_path);
        $response->assertSee($item3->name);
        $response->assertSee($item4->image_path);
        $response->assertSee($item4->name);

        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);

        $response->assertSee($item1->image_path);
        $response->assertSee($item1->name);
        $response->assertSee($item2->image_path);
        $response->assertSee($item2->name);
    }
}