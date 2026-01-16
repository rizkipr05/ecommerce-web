<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['items.product', 'customer'])
            ->orderByDesc('created_at')
            ->paginate(30);

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer']);

        return response()->json(['data' => $order]);
    }
}
