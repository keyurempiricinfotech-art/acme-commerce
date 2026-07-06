<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(private readonly OrderRepositoryContract $orders)
    {
    }

    public function place(User $user, array $data): Order
    {
        $addressBelongsToUser = $user->addresses()->whereKey($data['shipping_address_id'])->exists();

        if (! $addressBelongsToUser) {
            throw ValidationException::withMessages([
                'shipping_address_id' => 'The selected address does not belong to the current user.',
            ]);
        }

        $products = Product::query()
            ->whereIn('id', collect($data['items'])->pluck('product_id'))
            ->get()
            ->keyBy('id');

        $items = collect($data['items'])->map(function (array $item) use ($products): array {
            $product = $products->get($item['product_id']);

            if (! $product || ! $product->is_active || $product->stock_quantity < $item['quantity']) {
                throw ValidationException::withMessages([
                    'items' => 'One or more products are unavailable.',
                ]);
            }

            return [
                'product_id' => $product->id,
                'sku' => $product->sku,
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'line_total' => $product->price * $item['quantity'],
            ];
        })->all();

        $order = $this->orders->createWithItems($user, $data, $items);

        OrderPlaced::dispatch($order);

        return $order;
    }

    public function updateStatus(Order $order, string $status): Order
    {
        return $this->orders->updateStatus($order, $status);
    }
}
