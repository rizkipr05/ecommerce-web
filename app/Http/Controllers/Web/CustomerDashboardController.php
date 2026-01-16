<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('customer_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('customer.dashboard', [
            'title' => 'Customer Dashboard',
            'orders' => $orders,
        ]);
    }
}
