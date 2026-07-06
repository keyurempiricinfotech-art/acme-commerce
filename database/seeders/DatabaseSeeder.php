<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory()->count(6)->create();

        $products = Product::factory()
            ->count(30)
            ->sequence(fn () => ['category_id' => $categories->random()->id])
            ->create();

        User::factory()
            ->count(8)
            ->has(Address::factory()->count(2), 'addresses')
            ->create()
            ->each(function (User $user) use ($products): void {
                $address = $user->addresses()->first();

                Order::factory()
                    ->count(2)
                    ->for($user)
                    ->for($address, 'shippingAddress')
                    ->create()
                    ->each(function (Order $order) use ($products): void {
                        $product = $products->random();

                        $order->items()->create([
                            'product_id' => $product->id,
                            'sku' => $product->sku,
                            'name' => $product->name,
                            'quantity' => 1,
                            'unit_price' => $product->price,
                            'line_total' => $product->price,
                        ]);
                    });
            });
    }
}
