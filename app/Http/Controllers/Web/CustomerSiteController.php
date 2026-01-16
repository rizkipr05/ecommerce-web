<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class CustomerSiteController extends Controller
{
    public function beranda()
    {
        return view('customer.beranda', [
            'title' => 'Beranda',
        ]);
    }

    public function toko(Request $request)
    {
        $search = $request->query('q');
        $sellers = User::query()
            ->where('role', User::ROLE_SELLER)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('customer.toko', [
            'title' => 'Toko',
            'sellers' => $sellers,
            'search' => $search,
        ]);
    }

    public function tokoDetail(Request $request, User $seller)
    {
        if ($seller->role !== User::ROLE_SELLER) {
            abort(404);
        }

        $search = $request->query('q');
        $products = Product::query()
            ->where('seller_id', $seller->id)
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(12);

        return view('customer.toko-detail', [
            'title' => 'Toko ' . $seller->name,
            'seller' => $seller,
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function hubungi()
    {
        return view('customer.hubungi', [
            'title' => 'Hubungi Kami',
        ]);
    }

    public function tentang()
    {
        return view('customer.tentang', [
            'title' => 'Tentang',
        ]);
    }

    public function keranjang()
    {
        return view('customer.keranjang', [
            'title' => 'Keranjang',
        ]);
    }

    public function profil(Request $request)
    {
        return view('customer.profil', [
            'title' => 'Profil Saya',
            'user' => $request->user(),
        ]);
    }
}
