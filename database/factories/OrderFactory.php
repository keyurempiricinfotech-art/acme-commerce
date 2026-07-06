<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 500);

        return [
            'user_id' => User::factory(),
            'shipping_address_id' => Address::factory(),
            'order_number' => 'ACME-' . fake()->unique()->numerify('########'),
            'status' => Order::STATUS_PAID,
            'subtotal' => $subtotal,
            'tax_total' => 0,
            'shipping_total' => 0,
            'grand_total' => $subtotal,
            'currency' => 'USD',
            'placed_at' => now()->subDays(fake()->numberBetween(0, 60)),
        ];
    }
}
