<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'subtotal' => (string) $this->subtotal,
            'tax_total' => (string) $this->tax_total,
            'shipping_total' => (string) $this->shipping_total,
            'grand_total' => (string) $this->grand_total,
            'currency' => $this->currency,
            'placed_at' => $this->placed_at?->toIso8601String(),
            'shipping_address' => new AddressResource($this->whenLoaded('shippingAddress')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
