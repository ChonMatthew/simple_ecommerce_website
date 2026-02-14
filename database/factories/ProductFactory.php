<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'image' => null,
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 5, 200),
            'stock_quantity' => fake()->numberBetween(0, 20),
        ];
    }
}
