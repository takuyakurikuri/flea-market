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
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth_comment()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $beforeCount = Comment::count();

        //$response = $this->get("/item/{$item->id}");
        //$response->assertStatus(200);

        $comment = [
            'content' => 'test comment',
        ];
        $response = $this->post("/item/{$item->id}/comment", ['item_id' => $item->id,'content' => $comment['content']]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'content' => $comment['content']
        ]);

        $this->assertEquals($beforeCount + 1, Comment::count());
    }

    public function test_no_auth_comment()
    {
        Address::factory()->create();
        $item = Item::factory()->create();
        $user = User::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);


        //ログイン処理しない

        $beforeCount = Comment::count();

        $comment = [
            'content' => 'test comment',
        ];
        $response = $this->post("/item/{$item->id}/comment", ['item_id' => $item->id,'content' => $comment['content']]);

        $this->assertEquals($beforeCount, Comment::count());
    }

    public function test_auth_comment_validation_no_comment()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $comment = [
            'content' => '',
        ];
        $response = $this->post("/item/{$item->id}/comment", ['item_id' => $item->id,'content' => $comment['content']]);

        $response->assertSessionHasErrors(['content']);

    }

    public function test_auth_comment_validation_comment_over()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $item = Item::factory()->create();
        category::factory()->count(20)->create();
        CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        //260文字で確認
        $comment = [
            'content' => '2luqwxf5c4m0r8sfnypnglo97vkjmctgj1nc5uzgzpyhh33p1q4c0ilzpclxo3g6h8dftrnimq3er4qx11d9dpe57r5ngz9fvk40fbc2sq78pgptl254334i90fn25jzuls3nxi1pd6tl64v08lm0el4msezw8ui4w2234u9kh77gjet9vgtlazrcnpbfl9ivnyk2e8fmwmvloit2y58uoyfh9nvsfd0nry854fdn5cpx5ikvk08rkjjpdl3mwti9mxx',
        ];
        $response = $this->post("/item/{$item->id}/comment", ['item_id' => $item->id,'content' => $comment['content']]);

        $response->assertSessionHasErrors(['content']);

    }
}