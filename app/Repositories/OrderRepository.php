<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryContract
{
    public function forUser(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $user->orders()->with(['items.product', 'shippingAddress'])->latest()->paginate($perPage);
    }

    public function createWithItems(User $user, array $data, array $items): Order
    {
        return DB::transaction(function () use ($user, $data, $items): Order {
            $order = $user->orders()->create([
                'shipping_address_id' => $data['shipping_address_id'],
                'order_number' => 'ACME-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8)),
                'status' => Order::STATUS_PAID,
                'subtotal' => collect($items)->sum('line_total'),
                'tax_total' => 0,
                'shipping_total' => 0,
                'grand_total' => collect($items)->sum('line_total'),
                'currency' => 'USD',
                'placed_at' => now(),
            ]);

            $order->items()->createMany($items);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->forceFill(['status' => $status])->save();

        return $order->refresh();
    }
}
