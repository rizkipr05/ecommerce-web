<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerCartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        return view('customer.keranjang', [
            'title' => 'Keranjang',
            'cart' => $cart,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        if ($cart['seller_id'] && $cart['seller_id'] !== $product->seller_id) {
            return back()->with('error', 'Keranjang hanya bisa berisi produk dari satu toko.');
        }

        $cart['seller_id'] = $product->seller_id;
        $items = $cart['items'];

        if (isset($items[$product->id])) {
            $items[$product->id]['quantity'] += 1;
        } else {
            $items[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->image_path,
            ];
        }

        $cart['items'] = $items;
        $request->session()->put('cart', $cart);

        $redirectTarget = $request->input('redirect', 'checkout');
        $redirectPath = $redirectTarget === 'keranjang' ? '/keranjang' : '/checkout';

        return redirect($redirectPath)->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        if (!isset($cart['items'][$product->id])) {
            return back();
        }

        $cart['items'][$product->id]['quantity'] = $validated['quantity'];
        $request->session()->put('cart', $cart);

        return back();
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        unset($cart['items'][$product->id]);

        if (count($cart['items']) === 0) {
            $cart['seller_id'] = null;
        }

        $request->session()->put('cart', $cart);

        return back();
    }

    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        if (count($cart['items']) === 0) {
            return redirect('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $rates = ShippingRate::where('seller_id', $cart['seller_id'])
            ->orderBy('kabupaten')
            ->get();

        return view('customer.checkout', [
            'title' => 'Checkout',
            'cart' => $cart,
            'rates' => $rates,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $cart = $request->session()->get('cart', [
            'seller_id' => null,
            'items' => [],
        ]);

        if (count($cart['items']) === 0) {
            return redirect('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        $validated = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:50'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'shipping_rate_id' => ['required', 'exists:shipping_rates,id'],
        ]);

        $order = DB::transaction(function () use ($validated, $cart, $request) {
            $productIds = collect($cart['items'])->pluck('product_id')->all();
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;
            $items = [];

            foreach ($cart['items'] as $item) {
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

            $rate = ShippingRate::where('id', $validated['shipping_rate_id'])
                ->where('seller_id', $cart['seller_id'])
                ->firstOrFail();

            $total += $rate->price;

            $order = Order::create([
                'customer_id' => $request->user()->id,
                'status' => 'pending_payment',
                'total_amount' => $total,
                'shipping_cost' => $rate->price,
                'shipping_rate_id' => $rate->id,
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->items()->saveMany($items);

            return $order;
        });

        $request->session()->forget('cart');

        return redirect('/dashboard')->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
    }
}
