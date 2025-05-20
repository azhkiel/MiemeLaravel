<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('menu')
                    ->where('user_id', Auth::id())
                    ->get();
                    
        $counts = [
            'item_count' => $cartItems->count(),
            'total_items' => $cartItems->sum('quantity')
        ];
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->menu->harga;
        });

        return view('customer.cart', [
            'items' => $cartItems,
            'item_count' => $counts['item_count'],
            'total_items' => $counts['total_items'],
            'subtotal' => $subtotal
        ]);
    }

    public function updateQuantity(Request $request, $id)
    {
        $action = $request->action;
        $cartItem = Cart::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        switch ($action) {
            case 'increase':
                $cartItem->increment('quantity');
                break;
            case 'decrease':
                if ($cartItem->quantity > 1) {
                    $cartItem->decrement('quantity');
                } else {
                    $cartItem->delete();
                }
                break;
            case 'remove':
                $cartItem->delete();
                break;
        }

        $counts = [
            'item_count' => Cart::where('user_id', Auth::id())->count(),
            'total_items' => Cart::where('user_id', Auth::id())->sum('quantity')
        ];

        return response()->json([
            'success' => true,
            'item_count' => $counts['item_count'],
            'total_items' => $counts['total_items']
        ]);
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::with('menu')
                    ->where('user_id', Auth::id())
                    ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->menu->harga;
        });

        DB::transaction(function() use ($cartItems, $subtotal) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $subtotal,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'kode_menu' => $item->kode_menu,
                    'quantity' => $item->quantity,
                    'price' => $item->menu->harga
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat');
    }
}