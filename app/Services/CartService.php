<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function forUser(User $user): Cart
    {
        return $user->cart()->firstOrCreate([
            'user_id' => $user->id,
        ], [
            'currency' => 'USD',
            'expires_at' => now()->addDays(14),
        ]);
    }

    public function addItem(User $user, array $data): Cart
    {
        $cart = $this->forUser($user);
        $product = Product::query()->findOrFail($data['product_id']);

        if (! $product->is_active || $product->stock_quantity < $data['quantity']) {
            throw ValidationException::withMessages(['product_id' => 'Product is unavailable.']);
        }

        $cart->items()->updateOrCreate([
            'product_id' => $product->id,
        ], [
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
        ]);

        return $cart->refresh();
    }

    public function updateItem(User $user, int $cartItemId, array $data): Cart
    {
        $cart = $this->forUser($user);
        $item = $cart->items()->whereKey($cartItemId)->firstOrFail();

        $item->update(['quantity' => $data['quantity']]);

        return $cart->refresh();
    }

    public function removeItem(User $user, int $cartItemId): void
    {
        $this->forUser($user)->items()->whereKey($cartItemId)->delete();
    }
}
