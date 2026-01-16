<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('items.product')
            ->where('customer_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($orders);
    }

    public function show(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $order->load('items.product');

        return response()->json(['data' => $order]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:50'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = DB::transaction(function () use ($validated, $request) {
            $productIds = collect($validated['items'])->pluck('product_id')->unique()->all();
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $items = [];

            foreach ($validated['items'] as $item) {
                $product = $products->get($item['product_id']);

                if (!$product || !$product->is_active) {
                    abort(422, 'Produk tidak tersedia.');
                }

                if ($product->stock < $item['quantity']) {
                    abort(422, 'Stok tidak mencukupi.');
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $items[] = new OrderItem([
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            $order = Order::create([
                'customer_id' => $request->user()->id,
                'status' => 'pending_payment',
                'total_amount' => $total,
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->items()->saveMany($items);

            return $order->load('items.product');
        });

        return response()->json(['data' => $order], 201);
    }
}
