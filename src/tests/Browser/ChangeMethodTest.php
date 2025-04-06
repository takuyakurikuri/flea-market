<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Address;


class ChangeMethodTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Address::factory()->create();
        // $user = User::factory()->create();
        // $item = Item::factory()->create();
        // category::factory()->count(20)->create();
        // CategoryItem::factory()->count(2)->create(['item_id' =>$item->id]);

        $this->browse(function (Browser $browser) use ($user,$item) {
            $browser->loginAs($user)
                    ->visit("/item/{$item->id}/purchase")
                    ->assertSee('選択して下さい')
                    ->select('payment-method', '1')
                    ->waitForText('カード支払い')
                    ->assertSee('カード支払い');
        });
    }
}