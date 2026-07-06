<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'sku' => Str::upper(fake()->bothify('SKU-####-??')),
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 300),
            'currency' => 'USD',
            'stock_quantity' => fake()->numberBetween(0, 200),
            'is_active' => true,
            'published_at' => now()->subDays(fake()->numberBetween(1, 90)),
        ];
    }
}
