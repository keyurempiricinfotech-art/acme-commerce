<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryContract
{
    public function forUser(User $user, int $perPage = 15): LengthAwarePaginator;

    public function createWithItems(User $user, array $data, array $items): Order;

    public function updateStatus(Order $order, string $status): Order;
}
