<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil pesanan beserta detailnya (termasuk menu), dan juga informasi type_pesanan dan nomor meja
        $orders = Auth::user()->orders()
            ->with(['orderDetails.menu', 'meja'])  // Memuat relasi 'orderDetails' dan 'meja'
            ->latest()
            ->get();

        // Ambil jumlah item di keranjang belanja
        $cartCount = Auth::user()->charts()->sum('quantity');

        return view('dashboard.customer.orders', [
            'orders' => $orders,
            'cartCount' => $cartCount
        ]);
    }


    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed,cancelled'
        ]);

        $order = Auth::user()->orders()->findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}