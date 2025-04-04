<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ItemFactory extends Factory
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
            'image_path' =>'images/Armani+Mens+Clock.jpg',
            'condition' => $this->faker->numberBetween(1,4),
            'name' => $this->faker->name(),
            'brand' => $this->faker->word(),
            'detail' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1,20000),
        ];
    }
}