<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\OrderConfirmation;

class SendOrderConfirmation
{
    public function handle(OrderPlaced $event): void
    {
        $event->order->user->notify(new OrderConfirmation($event->order));
    }
}
