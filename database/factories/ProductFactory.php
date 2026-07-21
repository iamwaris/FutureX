<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 5, 80),
            'product_url' => $this->faker->url(),
            'is_featured' => true,
            'is_limited_drop' => $this->faker->boolean(20),
            'is_digital_download' => $this->faker->boolean(15),
        ];
    }
}
