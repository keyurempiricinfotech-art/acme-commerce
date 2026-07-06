<?php

namespace App\Services;

use App\Jobs\RecalculateProductPopularity;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function __construct(private readonly ProductRepositoryContract $products)
    {
    }

    public function create(array $data): Product
    {
        $product = $this->products->create($data);

        RecalculateProductPopularity::dispatch($product->id);

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $updated = $this->products->update($product, $data);

        $this->forgetProductCache($updated->id);
        RecalculateProductPopularity::dispatch($updated->id);

        return $updated;
    }

    public function delete(Product $product): void
    {
        $id = $product->id;

        $this->products->delete($product);
        $this->forgetProductCache($id);
    }

    private function forgetProductCache(int $productId): void
    {
        Cache::forget("products.show.{$productId}");
    }
}
