<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_active_products(): void
    {
        $category = Category::factory()->create();
        Product::factory()->for($category)->count(3)->create(['is_active' => true]);

        $this->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonPath('data.0.category_id', $category->id);
    }

    public function test_it_hides_inactive_products(): void
    {
        Product::factory()->create(['is_active' => false]);

        $this->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
