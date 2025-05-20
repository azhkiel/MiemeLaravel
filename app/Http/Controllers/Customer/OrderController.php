<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('details.menu')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();
                    
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return view('customer.orders', [
            'orders' => $orders,
            'total_items' => $cartCount
        ]);
    }

    public function updateStatus(Request $request, $orderId)
    {
        $validStatuses = ['pending', 'processed', 'completed', 'cancelled'];
        
        if (!in_array($request->status, $validStatuses)) {
            return response()->json(['success' => false, 'message' => 'Invalid status'], 400);
        }

        $order = Order::where('id', $orderId)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $order->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}