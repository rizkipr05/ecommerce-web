<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function beranda()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', User::ROLE_CUSTOMER)->count();
        $totalSellers = User::where('role', User::ROLE_SELLER)->count();
        $totalOrders = Order::count();

        return view('admin.beranda', [
            'title' => 'Admin Beranda',
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalSellers' => $totalSellers,
            'totalOrders' => $totalOrders,
        ]);
    }

    public function dataNasiBakar()
    {
        $products = Product::with(['seller', 'category'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.data-nasi-bakar', [
            'title' => 'Data Nasi Bakar',
            'products' => $products,
        ]);
    }

    public function dataPengguna()
    {
        $customers = User::where('role', User::ROLE_CUSTOMER)
            ->orderBy('name')
            ->paginate(10);

        $sellers = User::where('role', User::ROLE_SELLER)
            ->orderBy('name')
            ->paginate(10);

        $admins = User::where('role', User::ROLE_ADMIN)
            ->orderBy('name')
            ->paginate(10);

        return view('admin.data-pengguna', [
            'title' => 'Data Pengguna',
            'customers' => $customers,
            'sellers' => $sellers,
            'admins' => $admins,
        ]);
    }

    public function pesananLaporan()
    {
        $orders = Order::with('customer')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.pesanan-laporan', [
            'title' => 'Pesanan & Laporan',
            'orders' => $orders,
        ]);
    }

    public function customers()
    {
        $customers = User::where('role', User::ROLE_CUSTOMER)
            ->orderBy('name')
            ->paginate(15);

        return view('admin.customers', [
            'title' => 'Customer',
            'customers' => $customers,
        ]);
    }

    public function customerReviews()
    {
        return view('admin.customer-reviews', [
            'title' => 'Customer Review',
        ]);
    }

    public function deactivateCustomer(User $user)
    {
        if ($user->role !== User::ROLE_CUSTOMER) {
            abort(404);
        }

        $user->is_active = false;
        $user->save();

        return back();
    }

    public function activateCustomer(User $user)
    {
        if ($user->role !== User::ROLE_CUSTOMER) {
            abort(404);
        }

        $user->is_active = true;
        $user->save();

        return back();
    }

    public function deleteCustomer(User $user)
    {
        if ($user->role !== User::ROLE_CUSTOMER) {
            abort(404);
        }

        $user->delete();

        return back();
    }

    public function deactivateSeller(User $user)
    {
        if ($user->role !== User::ROLE_SELLER) {
            abort(404);
        }

        $user->is_active = false;
        $user->save();

        return back();
    }

    public function activateSeller(User $user)
    {
        if ($user->role !== User::ROLE_SELLER) {
            abort(404);
        }

        $user->is_active = true;
        $user->save();

        return back();
    }

    public function deleteSeller(User $user)
    {
        if ($user->role !== User::ROLE_SELLER) {
            abort(404);
        }

        $user->delete();

        return back();
    }
}
