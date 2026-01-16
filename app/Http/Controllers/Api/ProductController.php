<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['category', 'seller'])
            ->where('is_active', true)
            ->when($request->query('category_id'), function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(20);

        return response()->json($products);
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            return response()->json(['message' => 'Product not available.'], 404);
        }

        $product->load(['category', 'seller']);

        return response()->json(['data' => $product]);
    }

    public function sellerIndex(Request $request)
    {
        $products = Product::query()
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $product = Product::create([
            'seller_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json(['data' => $product], 201);
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'integer', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (array_key_exists('category_id', $validated)) {
            $product->category_id = $validated['category_id'];
        }

        if (array_key_exists('name', $validated)) {
            $product->name = $validated['name'];
            $product->slug = Str::slug($validated['name']);
        }

        if (array_key_exists('description', $validated)) {
            $product->description = $validated['description'];
        }

        if (array_key_exists('price', $validated)) {
            $product->price = $validated['price'];
        }

        if (array_key_exists('stock', $validated)) {
            $product->stock = $validated['stock'];
        }

        if (array_key_exists('is_active', $validated)) {
            $product->is_active = $validated['is_active'];
        }

        $product->save();

        return response()->json(['data' => $product]);
    }

    public function destroy(Request $request, Product $product)
    {
        if ($product->seller_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted.']);
    }
}
