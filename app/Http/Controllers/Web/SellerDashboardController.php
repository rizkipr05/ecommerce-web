<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $orderItems = OrderItem::with('order')
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('seller.dashboard', [
            'title' => 'Seller Dashboard',
            'products' => $products,
            'orderItems' => $orderItems,
        ]);
    }

    public function beranda(Request $request)
    {
        $sellerId = $request->user()->id;
        $totalProducts = Product::where('seller_id', $sellerId)->count();
        $totalOrders = OrderItem::where('seller_id', $sellerId)->count();
        $shippedOrders = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($query) {
                $query->where('status', 'shipped');
            })
            ->count();

        return view('seller.beranda', [
            'title' => 'Seller Beranda',
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'shippedOrders' => $shippedOrders,
        ]);
    }

    public function dataSayuran(Request $request)
    {
        $products = Product::where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.data-sayuran', [
            'title' => 'Master Data Sayuran',
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function dataOngkir()
    {
        $rates = ShippingRate::where('seller_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.data-ongkir', [
            'title' => 'Master Data Ongkir',
            'rates' => $rates,
        ]);
    }

    public function profile(Request $request)
    {
        return view('seller.profile', [
            'title' => 'Profil Seller',
            'seller' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $seller = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($seller->id),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile_image')) {
            if ($seller->profile_image_path) {
                Storage::disk('public')->delete($seller->profile_image_path);
            }
            $seller->profile_image_path = $request->file('profile_image')->store('profiles', 'public');
        }

        $seller->name = $validated['name'];
        $seller->email = $validated['email'];
        $seller->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function storeSayuran(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'seller_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'is_active' => true,
        ]);

        return back();
    }

    public function updateSayuran(Request $request, Product $product)
    {
        if ($product->seller_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->category_id = $validated['category_id'];
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->save();

        return back();
    }

    public function deleteSayuran(Request $request, Product $product)
    {
        if ($product->seller_id !== $request->user()->id) {
            abort(403);
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back();
    }

    public function storeOngkir(Request $request)
    {
        $validated = $request->validate([
            'kabupaten' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
        ]);

        ShippingRate::create([
            'seller_id' => $request->user()->id,
            'kabupaten' => $validated['kabupaten'],
            'kecamatan' => $validated['kecamatan'],
            'price' => $validated['price'],
        ]);

        return back();
    }

    public function updateOngkir(Request $request, ShippingRate $shippingRate)
    {
        if ($shippingRate->seller_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'kabupaten' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
        ]);

        $shippingRate->update($validated);

        return back();
    }

    public function deleteOngkir(Request $request, ShippingRate $shippingRate)
    {
        if ($shippingRate->seller_id !== $request->user()->id) {
            abort(403);
        }

        $shippingRate->delete();

        return back();
    }

    public function pesanan(Request $request)
    {
        $orderItems = OrderItem::with('order')
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.pesanan', [
            'title' => 'Data Pesanan',
            'orderItems' => $orderItems,
        ]);
    }

    public function konfirmasiPesanan(Request $request)
    {
        $orderItems = OrderItem::with('order')
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.konfirmasi-pesanan', [
            'title' => 'Konfirmasi Pesanan',
            'orderItems' => $orderItems,
        ]);
    }

    public function confirmPesanan(Request $request, OrderItem $orderItem)
    {
        if ($orderItem->seller_id !== $request->user()->id) {
            abort(403);
        }

        $order = $orderItem->order;
        if ($order) {
            $order->status = 'processing';
            $order->save();
        }

        return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    public function laporan(Request $request)
    {
        $orderItems = OrderItem::with('order')
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.laporan', [
            'title' => 'Laporan',
            'orderItems' => $orderItems,
        ]);
    }
}
