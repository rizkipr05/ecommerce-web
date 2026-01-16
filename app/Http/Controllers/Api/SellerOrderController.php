<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->whereHas('items', function ($query) use ($request) {
                $query->where('seller_id', $request->user()->id);
            })
            ->with(['items' => function ($query) use ($request) {
                $query->where('seller_id', $request->user()->id)->with('product');
            }, 'customer'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($orders);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $hasItem = $order->items()
            ->where('seller_id', $request->user()->id)
            ->exists();

        if (!$hasItem) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:processing,shipped,delivered,cancelled'],
        ]);

        $order->status = $validated['status'];
        $order->save();

        return response()->json(['data' => $order]);
    }
}
