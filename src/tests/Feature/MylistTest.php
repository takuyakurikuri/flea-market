<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;

use function PHPUnit\Framework\assertCount;

class MylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mylist()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $items = Item::factory()->count(10)->create();
        $favorites = Favorite::factory()->count(2)->create(['user_id'=> $user->id ]);
        
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response = $this->get('/?tab=mylist',);
        $response->assertStatus(200);
        
        foreach($favorites as $favorite){
            $response->assertSee($favorite->item_id);
        }
    }

    public function test_mylist_sold()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $items = Item::factory()->count(8)->create();
        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();
        Favorite::factory()->create(['user_id'=> $user->id,'item_id' => $item1->id]);
        Favorite::factory()->create(['user_id'=> $user->id,'item_id' => $item2->id]);
        Favorite::factory()->count(4)->create(['user_id'=> $user->id,]);
        Purchase::factory()->create(['item_id'=> $item1->id]);
        Purchase::factory()->create(['item_id'=> $item2->id]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach($items as $item){
            if($item->purchases()->exists()){
                $response->assertSee('<label',false);
                $response->assertSee('sold');
            }
        }

    }

    public function test_mylist_my_item()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $items = Item::factory()->count(8)->create();
        
        $myItem1 = Item::factory()->create(['user_id' => $user->id,'name'=>'MyItem1']);
        $myItem2 = Item::factory()->create(['user_id' => $user->id,'name'=>'MyItem1']);
        
        $otherItem1 = Item::factory()->create();
        $otherItem2 = Item::factory()->create();
        
        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $otherItem1->id]);
        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $otherItem2->id]);
    


        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertDontSeeText('MyItem1');
        $response->assertDontSeeText('MyItem2');

        $response->assertSeeText($otherItem1->name);
        $response->assertSeeText($otherItem2->name);

    }

    public function test_mylist_no_auth()
    {
        Address::factory()->create();
        $user = User::factory()->create();
        $items = Item::factory()->count(8)->create();

        $myItem1 = Item::factory()->create(['user_id' => $user->id,'name'=>'MyItem1']);
        $myItem2 = Item::factory()->create(['user_id' => $user->id,'name'=>'MyItem1']);

        $otherItem1 = Item::factory()->create();
        $otherItem2 = Item::factory()->create();

        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $otherItem1->id]);
        Favorite::factory()->create(['user_id' => $user->id, 'item_id' => $otherItem2->id]);

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        foreach (Item::all() as $item) {
        $response->assertDontSeeText($item->name);
    }

    }
}