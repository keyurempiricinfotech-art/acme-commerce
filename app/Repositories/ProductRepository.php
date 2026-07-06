<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryContract
{
    public function activePaginated(int $perPage = 20): LengthAwarePaginator
    {
        return Product::query()
            ->where('is_active', true)
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function find(int $id): ?Product
    {
        return Product::query()->find($id);
    }

    public function create(array $data): Product
    {
        return Product::query()->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->fill($data)->save();

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function findMany(array $ids): Collection
    {
        return Product::query()->whereIn('id', $ids)->get()->keyBy('id');
    }
}
