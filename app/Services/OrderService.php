<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderAddress;

class OrderService
{
    public function createOrder($validated)
    {
        $orderAddress = new OrderAddress;
        $orderAddress->fill($validated['address']);

        $order = new Order;

        $order->fill([
            'id' => $validated['id'],
            'name' => $validated['name'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'address_id' => $orderAddress->id,
        ]);

        return $order;
    }
}
