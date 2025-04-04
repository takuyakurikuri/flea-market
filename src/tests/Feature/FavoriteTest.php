<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Address;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_favorite()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);

        $response = $this->post("/item/{$item->id}", ['item_id' => $item->id]);
        $item->refresh();
        $this->assertGreaterThan(0,$item->favorites()->count());
    }

    public function test_add_favorite_icon()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);

        $response->assertSee('images/addstar.png');
        $response = $this->post("/item/{$item->id}", ['item_id' => $item->id]);
        $item->refresh();
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('images/togglestar.png');
        
    }

    public function test_toggle_favorite()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);

        $response = $this->post("/item/{$item->id}", ['item_id' => $item->id]);
        $item->refresh();
        $this->assertGreaterThan(0,$item->favorites()->count());
        
        $response = $this->get("/item/{$item->id}");
        $response = $this->delete("/item/{$item->id}");
        $this->assertEquals(0,$item->favorites()->count());
        
    }
}