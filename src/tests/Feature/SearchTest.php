<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Favorite;

class SearchTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search()
    {
        Item::factory()->create(['name' => 'UML入門']);
        Item::factory()->create(['name' => 'Spring入門']);
        Item::factory()->create(['name' => 'PHPの教本']);
        Item::factory()->create(['name' => 'フルスタックweb開発']);

        $response = $this->get('/search?keyword=入門');

        $response->assertStatus(200);

        $response->assertSee('入門');

        $response->assertDontSee('PHPの教本');
        $response->assertDontSee('フルスタックweb開発');
    }

    public function test_search_mylist()
    {
        $user = User::factory()->create();
        $item1 = Item::factory()->create(['name' => 'UML入門']);
        $item2 = Item::factory()->create(['name' => 'Spring入門']);
        $item3 = Item::factory()->create(['name' => 'PHPの教本']);
        $item4 = Item::factory()->create(['name' => 'フルスタックweb開発']);

        Favorite::factory()->create(['user_id'=> $user->id,'item_id' => $item1->id]);
        Favorite::factory()->create(['user_id'=> $user->id,'item_id' => $item3->id]);

        $this->actingAs($user);

        $response = $this->get('/search?tab=mylist&keyword=入門');

        $response->assertStatus(200);

        $response->assertSee('入門');

        $response->assertDontSee('Spring入門');
        $response->assertDontSee('PHPの教本');
        $response->assertDontSee('フルスタックweb開発');
        $response->assertSee('value="入門"', false);
    }
}