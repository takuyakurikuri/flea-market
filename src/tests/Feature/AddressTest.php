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


class AddressTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_address_change()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/purchase/address/{$item->id}");
        $response->assertStatus(200);

        $inputData = [
            'zipcode' => 1234567,
            'address' => '東京都西東京市',
            'building' => '明治アパート202',
        ];

        $response = $this->post("/purchase/address/{$item->id}",$inputData);

        $response = $this->get("/item/{$item->id}/purchase");
        $response->assertSee('123-4567');
        $response->assertSee('東京都西東京市');
        $response->assertSee('明治アパート202');

    }

    public function test_address_change_purchase()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get("/purchase/address/{$item->id}");
        $response->assertStatus(200);

        $inputAddress = [
            'zipcode' => 1234567,
            'address' => '東京都西東京市',
            'building' => '明治アパート202',
        ];

        $response = $this->post("/purchase/address/{$item->id}",$inputAddress);

        $this->assertEquals('123-4567', session('changeAddress.zipcode'));
        $this->assertEquals('東京都西東京市', session('changeAddress.address'));
        $this->assertEquals('明治アパート202', session('changeAddress.building'));

        $inputData = [
            'item_id' => $item->id,
            'payment_method' => 1,//支払い方法は仮置き
            'zipcode' => session('changeAddress.zipcode'),
            'address' => session('changeAddress.address'),
            'building' => session('changeAddress.building'),
            'modify' => 'true',
        ];

        $response = $this->post("/item/{$item->id}/checkout",$inputData);

        $this->assertDatabaseHas('addresses', [
        'zipcode' => 1234567,
        'address' => '東京都西東京市',
        'building' => '明治アパート202',
    ]);

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'payment_method' => 1,
            'user_id' => $user->id,
        ]);

    }
}