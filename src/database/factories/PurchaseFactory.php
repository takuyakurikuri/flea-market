<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'payment_method' => $this->faker->numberBetween(1,2),
            'item_id' => Item::factory(),
            'address_id' => Address::factory(),
            'status' => 'beforeShipping',
        ];
    }
}