<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'currency' => $this->currency,
            'expires_at' => $this->expires_at?->toIso8601String(),
            'items' => CartItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
