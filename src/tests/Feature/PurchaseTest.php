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

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase()
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

        $zip1 = substr($user->address->zipcode,0,3);
        $zip2 = substr($user->address->zipcode,3);
        $zipcode = $zip1 . "-" . $zip2;

        $inputData = [
            'item_id' => $item->id,
            'payment_method' => 1,//支払い方法は仮置き
            'zipcode' => $zipcode,
            'address' => $user->address->address,
            'building' => $user->address->building,
            'modify' => 'false',
        ];

        $response = $this->post("/item/{$item->id}/checkout",$inputData);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'payment_method' => 1,
            'address_id' => $user->address_id,
            'user_id' => $user->id,
        ]);
    }

    public function test_purchase_sold()
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

        $zip1 = substr($user->address->zipcode,0,3);
        $zip2 = substr($user->address->zipcode,3);
        $zipcode = $zip1 . "-" . $zip2;

        $inputData = [
            'item_id' => $item->id,
            'payment_method' => 1,//支払い方法は仮置き
            'zipcode' => $zipcode,
            'address' => $user->address->address,
            'building' => $user->address->building,
            'modify' => 'false',
        ];

        $response = $this->post("/item/{$item->id}/checkout",$inputData);

        $response = $this->get("/");

        $response->assertSee($item->image_path);
        $response->assertSee($item->name);
        $response->assertSee('<label',false);
        $response->assertSee('sold');

    }

    public function test_purchase_sold_mypage()
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

        $zip1 = substr($user->address->zipcode,0,3);
        $zip2 = substr($user->address->zipcode,3);
        $zipcode = $zip1 . "-" . $zip2;

        $inputData = [
            'item_id' => $item->id,
            'payment_method' => 1,//支払い方法は仮置き
            'zipcode' => $zipcode,
            'address' => $user->address->address,
            'building' => $user->address->building,
            'modify' => 'false',
        ];

        $response = $this->post("/item/{$item->id}/checkout",$inputData);

        $response = $this->get("/",['tab'=>'buy']);

        $response->assertSee($item->image_path);
        $response->assertSee($item->name);
        $response->assertSee('<label',false);
        $response->assertSee('sold');

    }
}