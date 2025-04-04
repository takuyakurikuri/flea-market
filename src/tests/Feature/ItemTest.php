<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\ItemsSeeder;
use App\Models\Item;
use App\Models\Address;
use App\Models\User;
use Database\Seeders\PurchasesSeeder;
use App\Models\Purchase;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        Address::factory()->create();
        User::factory()->count(10)->create();
        $items = Item::factory()->count(10)->create();

        $response = $this->get('/');
        

        $response->assertStatus(200);

        foreach($items as $item){
            $response->assertSee($item->image_path);
            $response->assertSee($item->name);
        }
    }

    public function test_sold()
    {
        Address::factory()->create();
        User::factory()->count(10)->create();

        $items = Item::factory()->count(8)->create();
        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();
        Purchase::factory()->create(['item_id'=> $item1->id]);
        Purchase::factory()->create(['item_id'=> $item2->id]);
        $items = $items->concat([$item1, $item2]);

        $response = $this->get('/');
        $response->assertStatus(200);

        foreach($items as $item){
            $response->assertSee($item->image_path);
            $response->assertSee($item->name);
            if($item->purchases()->exists()){
                $response->assertSee('<label',false);
                $response->assertSee('sold');
            }
        }
    }

    public function test_my_item()
    {
        Address::factory()->create();
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $productsA = Item::factory()->count(3)->create(['user_id' => $userA->id]);

        $productB = Item::factory()->create(['user_id' => $userB->id]);

        // ユーザーAとしてログインし、商品一覧を取得
        $this->actingAs($userA);
        $this->assertAuthenticatedAs($userA);
        $responseA = $this->get('/');

        foreach ($productsA as $product) {
            $responseA->assertDontSee($product->name);
        }

        $responseA->assertSee($productB->name);
        
    }
}