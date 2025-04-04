<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Address;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\CategoryItem;
use App\Models\Category;
use Database\Seeders\CategoriesSeeder;

class DetailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_detail()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);
        Favorite::factory()->count(4)->create(['item_id' => $item->id]);
        $comments = Comment::factory()->count(5)->create(['item_id' => $item->id]);
        $comments_count = Item::withCount('comments')->find($item->id);
        $favorites_count = Item::withCount('favorites')->find($item->id);
        $item_categories = CategoryItem::with('category')->where('item_id',$item->id)->get();

        
        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee($item->image_path);
        $response->assertSee($item->name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->brand);
        $response->assertSee($favorites_count->favorites_count);
        $response->assertSee($comments_count->comments_count);
        $response->assertSee($item->detail);
        foreach ($item_categories as $item_category) {
            $response->assertSee($item_category->category->content);
        }
        $response->assertSee($item->condition);
        foreach ($comments as $comment) {
            $response->assertSee($comment->user->name);
        }
        foreach ($comments as $comment) {
            $response->assertSee($comment->content);
        }
    }

    public function test_detail_categories()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);
        Favorite::factory()->count(4)->create(['item_id' => $item->id]);
        $comments = Comment::factory()->count(5)->create(['item_id' => $item->id]);
        $comments_count = Item::withCount('comments')->find($item->id);
        $favorites_count = Item::withCount('favorites')->find($item->id);
        $item_categories = CategoryItem::with('category')->where('item_id',$item->id)->get();

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        foreach ($item_categories as $item_category) {
            $response->assertSee($item_category->category->content);
        }

    }
}