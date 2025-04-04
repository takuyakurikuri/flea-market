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

class MethodTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_change_method()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/item/{$item->id}/purchase");
        $response->assertStatus(200);
        
    }
}