<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Cart")
 */
class CartController extends Controller
{
    public function __construct(private readonly CartService $carts)
    {
    }

    /**
     * @OA\Get(path="/api/v1/cart", tags={"Cart"}, summary="Show current cart")
     */
    public function show(Request $request): CartResource
    {
        return new CartResource($this->carts->forUser($request->user())->load('items.product'));
    }

    /**
     * @OA\Post(path="/api/v1/cart/items", tags={"Cart"}, summary="Add an item to cart")
     */
    public function store(StoreCartRequest $request): CartResource
    {
        return new CartResource(
            $this->carts->addItem($request->user(), $request->validated())->load('items.product')
        );
    }

    /**
     * @OA\Patch(path="/api/v1/cart/items/{cartItem}", tags={"Cart"}, summary="Update a cart item")
     */
    public function update(UpdateCartRequest $request, int $cartItem): CartResource
    {
        return new CartResource(
            $this->carts->updateItem($request->user(), $cartItem, $request->validated())->load('items.product')
        );
    }

    /**
     * @OA\Delete(path="/api/v1/cart/items/{cartItem}", tags={"Cart"}, summary="Remove a cart item")
     */
    public function destroy(Request $request, int $cartItem)
    {
        $this->carts->removeItem($request->user(), $cartItem);

        return response()->noContent();
    }
}
