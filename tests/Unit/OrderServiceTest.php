<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_order_for_available_product(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->for($user)->create();
        $product = Product::factory()->create(['stock_quantity' => 5, 'is_active' => true]);

        $order = app(OrderService::class)->place($user, [
            'shipping_address_id' => $address->id,
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ],
        ]);

        $this->assertSame($user->id, $order->user_id);
        $this->assertCount(1, $order->items);
    }
}
