<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('order')
            ? ($this->user()?->can('update', $this->route('order')) ?? false)
            : false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_FULFILLED,
                Order::STATUS_CANCELLED,
            ])],
        ];
    }
}
