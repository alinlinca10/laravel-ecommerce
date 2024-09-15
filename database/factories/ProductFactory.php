<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'pictures' => fake()->imageUrl($width = 640, $height = 480, 'avatar'),
            'price' => fake()->numberBetween(50,1500),
            'old_price' => fake()->numberBetween(40,1300),
            'code' => fake()->ean13(),
            'qty' => fake()->random(0, 50),
            'description' => fake()->realText($maxNbChars = 200, $indexSize = 2),
            'pictures' => fake()->imageUrl($width = 640, $height = 480),
            'active' => '1',
        ];
    }
}
