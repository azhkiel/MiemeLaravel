<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Tampilkan semua pesanan yang berstatus pending
    public function index()
    {
        // Ambil semua pesanan yang berstatus pending
        $orders = Order::latest()->get(); // Filter pesanan dengan status 'pending'

        // Kirim data pesanan ke view
        return view('dashboard.admin.order', compact('orders'));
    }

    public function menu()
    {
        $menus = Menu::all()->groupBy('kategori');
        $cartCount = Auth::user()->charts()->sum('quantity');

        return view('dashboard.admin.menu', [
            'menus' => $menus,
            'cartCount' => $cartCount
        ]);
    }
    // Tampilkan halaman untuk update status pesanan
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId); // Dapatkan pesanan berdasarkan ID
        return view('dashboard.admin.update-status', compact('order'));
    }

    // Update status pesanan
    public function update(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed,cancelled' // Validasi status
        ]);

        // Temukan pesanan berdasarkan ID
        $order = Order::findOrFail($orderId);

        // Update status pesanan
        $order->status = $request->status;
        $order->save(); // Simpan perubahan

        // Redirect kembali ke halaman riwayat pesanan dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
