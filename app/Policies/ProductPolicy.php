<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return str_ends_with($user->email, '@acme.test');
    }

    public function update(User $user, Product $product): bool
    {
        return str_ends_with($user->email, '@acme.test');
    }

    public function delete(User $user, Product $product): bool
    {
        return str_ends_with($user->email, '@acme.test') && $product->orderItems()->doesntExist();
    }
}
