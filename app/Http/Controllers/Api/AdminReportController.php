<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $query = Order::query()->where('status', '!=', 'cancelled');

        if ($from) {
            $query->whereDate('created_at', '>=', Carbon::parse($from));
        }

        if ($to) {
            $query->whereDate('created_at', '<=', Carbon::parse($to));
        }

        $summary = (clone $query)
            ->selectRaw('COUNT(*) as total_orders, COALESCE(SUM(total_amount), 0) as total_revenue')
            ->first();

        $perDay = (clone $query)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as orders'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        return response()->json([
            'summary' => $summary,
            'per_day' => $perDay,
        ]);
    }
}
