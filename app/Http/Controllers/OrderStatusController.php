<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function __construct(public OrderStatusService $OrderStatusService)
    {
        //        
    }

    public function statusChange(Request $request, Order $order)
    {
        $this->OrderStatusService->changeStatus($order, $request->status);

        // 4. Return API response
        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'data' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->refresh()->status,
            ],
        ], 200);
    }
}
