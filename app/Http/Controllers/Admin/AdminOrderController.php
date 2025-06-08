<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
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
        $user = Auth::user();
        return view('dashboard.admin.orders', [
            'orders' => $orders,
            'cartCount' => $cartCount,
            'users' => $user
        ]);
    }
}