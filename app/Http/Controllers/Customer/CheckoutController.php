<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Step 1: Pilih tipe pesanan (dine_in / takeaway)
    public function checkoutStep1()
    {
        return view('dashboard.customer.checkout_type');
    }

    // Step 2: Pilih meja jika dine in, atau langsung ke pembayaran jika takeaway
    public function checkoutStep2(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway'
        ]);

        if ($request->order_type === 'dine_in') {
            $mejas = Meja::where('ketersediaan', 'available')->get();
            return view('dashboard.customer.select_meja', [
                'mejas' => $mejas,
                'order_type' => 'dine_in'
            ]);
        }

        // Takeaway langsung ke pembayaran, kirim order_type
        return redirect()->route('customer.checkout.payment', ['order_type' => 'takeaway']);
    }

    // Step 3: Halaman pembayaran, baik dine in maupun takeaway
    public function payment(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,takeaway',
            'meja_id' => 'required_if:order_type,dine_in|nullable|exists:mejas,id',
        ]);

        $order_type = $request->input('order_type');
        $meja_id = $request->input('meja_id');

        $items = Auth::user()->charts()->with('menu')->get();
        $totalItems = $items->sum('quantity');
        $subtotal = $items->sum(function ($item) {
            return $item->quantity * $item->menu->harga;
        });

        $meja = null;
        if ($order_type === 'dine_in' && $meja_id) {
            $meja = Meja::find($meja_id);
            if (!$meja) {
                return redirect()->back()->with('error', 'Meja tidak ditemukan.');
            }
        }

        return view('dashboard.customer.payment', [
            'order_type' => $order_type,
            'meja_id' => $meja_id,
            'items' => $items,
            'totalItems' => $totalItems,
            'subtotal' => $subtotal,
            'meja' => $meja
        ]);
    }
}
