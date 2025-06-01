<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Step 4: Simpan order
    public function checkout(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway',
            'meja_id' => 'required_if:order_type,dine_in|nullable|exists:mejas,id'
        ]);

        $items = Auth::user()->charts()->with('menu')->get();
        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = $items->sum(fn($item) => $item->quantity * $item->menu->harga);

        // Menangani meja_id jika tipe pesanan dine_in
        $meja_id = $request->order_type === 'dine_in' ? $request->meja_id : null;

        // Jika tipe pesanan dine_in, pastikan meja_id sudah terisi dan valid
        if ($request->order_type === 'dine_in' && !$meja_id) {
            return redirect()->back()->with('error', 'Meja tidak dipilih.');
        }

        // Menyimpan order ke database
        $order = Auth::user()->orders()->create([
            'total_price' => $subtotal,
            'order_type' => $request->order_type,
            'meja_id' => $meja_id, // Meja yang dipilih (hanya untuk dine_in)
            'status' => 'pending'
        ]);

        // Menyimpan detail pesanan
        foreach ($items as $item) {
            $order->orderDetails()->create([
                'kode_menu' => $item->kode_menu,
                'quantity' => $item->quantity,
                'price' => $item->menu->harga
            ]);
        }

        // Jika dine_in, mark meja sebagai reserved
        if ($request->order_type === 'dine_in' && $meja_id) {
            Meja::where('id', $meja_id)
                ->update(['ketersediaan' => 'reserved']);
        }

        // Menghapus chart setelah order dibuat
        Auth::user()->charts()->delete();

        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat');
    }
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['orderDetails.menu', 'meja']) 
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
