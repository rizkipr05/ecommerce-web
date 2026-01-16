<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentProofController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = Storage::disk('public')->putFile('payment_proofs', $validated['file']);

        $order->payment_proof_path = $path;
        $order->status = 'payment_uploaded';
        $order->save();

        return response()->json(['data' => $order]);
    }
}
