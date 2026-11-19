<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class OrderStatusService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    private const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['shipped', 'cancelled'],
        'shipped' => ['delivered'],
        'delivered' => [],
        'cancelled' => [],
    ];

    public function changeStatus(Order $order, string $newStatus): Order
    {
        $currentStatus = $order->status;

        if (! in_array($newStatus, self::TRANSITIONS[$currentStatus] ?? [], true)) {

            throw ValidationException::withMessages([
                'status' => [
                    "Invalid order status transition. Cannot change order status from '{$currentStatus}' to '{$newStatus}'."
                ],
            ]);
        }

        $order->status = $newStatus;
        $order->save();

        return $order;
    }
}
