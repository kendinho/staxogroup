<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucwords($this->faker->word()),
            'price' => rand(100, 1000),
            'image' => 'https://picsum.photos/200/300?random=' . rand(1, 25)
        ];
    }
}
