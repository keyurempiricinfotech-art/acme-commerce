<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'category_name' => $this->category_name ?? $this->whenLoaded('category', fn () => $this->category->name),
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (string) $this->price,
            'currency' => $this->currency,
            'stock_quantity' => $this->stock_quantity,
            'is_active' => $this->is_active,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
