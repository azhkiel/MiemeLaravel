<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('orderDetails.menu')
            ->latest()
            ->get();

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