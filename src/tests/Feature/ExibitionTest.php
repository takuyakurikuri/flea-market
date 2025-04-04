<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Address;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryItem;

class ExibitionTest extends TestCase
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

        category::factory()->count(18)->create();
        $category1 = category::factory()->create();
        $category2 = category::factory()->create();
        
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/sell');
        $response->assertStatus(200);

        Storage::fake('public');
        $inputData = [
            'image_path' => UploadedFile::fake()->image('test.jpg'),
            'user_id' => $user->id,
            'condition' => 1,
            'name' => '腕時計',
            'brand' => 'armani',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            'category_id' => [$category1->id,$category2->id]
        ];

        $response = $this->post('/sell', $inputData);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'armani',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
        ]);

        $this->assertDatabaseHas('Category_item', [
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('Category_item', [
            'category_id' => $category2->id
        ]);
    }
}