<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
