<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RecalculateProductPopularity implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly int $productId)
    {
    }

    public function handle(): void
    {
        $product = Product::query()->withCount('orderItems')->find($this->productId);

        if ($product) {
            Log::info('Product popularity recalculated', [
                'product_id' => $product->id,
                'order_item_count' => $product->order_items_count,
            ]);
        }
    }
}
