<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function orderPost(OrderRequest $request)
    {
        $validated = $request->validated();
        $order = $this->orderService->createOrder($validated);

        return response()->json([
            'message' => 'Order processed successfully',
            'validated_data' => $order,
        ], 200);
    }
}
