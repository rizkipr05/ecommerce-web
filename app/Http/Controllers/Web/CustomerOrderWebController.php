<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerOrderWebController extends Controller
{
    public function uploadForm(Order $order, Request $request)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        return view('customer.bayar', [
            'title' => 'Upload Bukti Pembayaran',
            'order' => $order,
        ]);
    }

    public function upload(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = Storage::disk('public')->putFile('payment_proofs', $validated['file']);

        $order->payment_proof_path = $path;
        $order->status = 'payment_uploaded';
        $order->save();

        return redirect('/dashboard')->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}
