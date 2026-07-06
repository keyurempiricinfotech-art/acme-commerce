<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

/**
 * @OA\Tag(name="Products")
 */
class ProductController extends Controller
{
    public function __construct(private readonly ProductService $products)
    {
    }

    /**
     * @OA\Get(path="/api/v1/products", tags={"Products"}, summary="List active products")
     */
    public function index(): AnonymousResourceCollection
    {
        $products = Product::query()
            ->where('is_active', true)
            ->latest('published_at')
            ->paginate(20);

        foreach ($products as $product) {
            $product->category_name = $product->category?->name;
        }

        return ProductResource::collection($products);
    }

    /**
     * @OA\Post(path="/api/v1/products", tags={"Products"}, summary="Create a product")
     */
    public function store(StoreProductRequest $request): ProductResource
    {
        $this->authorize('create', Product::class);

        return new ProductResource($this->products->create($request->validated()));
    }

    /**
     * @OA\Get(path="/api/v1/products/{product}", tags={"Products"}, summary="Get one product")
     */
    public function show(Product $product): ProductResource
    {
        $cacheKey = "products.show.{$product->id}";

        $product = Cache::remember($cacheKey, now()->addMinutes(20), function () use ($product): Product {
            return $product->load(['category']);
        });

        return new ProductResource($product);
    }

    /**
     * @OA\Patch(path="/api/v1/products/{product}", tags={"Products"}, summary="Update a product")
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $this->authorize('update', $product);

        return new ProductResource($this->products->update($product, $request->validated()));
    }

    /**
     * @OA\Delete(path="/api/v1/products/{product}", tags={"Products"}, summary="Delete a product")
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $this->products->delete($product);

        return response()->noContent();
    }
}
