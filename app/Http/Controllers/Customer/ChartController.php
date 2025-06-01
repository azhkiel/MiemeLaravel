<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Chart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
    {
        $items = Auth::user()->charts()->with('menu')->get();
        $totalItems = $items->sum('quantity');
        $subtotal = $items->sum(function ($item) {
            return $item->quantity * $item->menu->harga;
        });

        return view('dashboard.customer.chart', [
            'items' => $items,
            'totalItems' => $totalItems,
            'subtotal' => $subtotal
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease,remove',
            'id' => 'required|exists:charts,id'
        ]);

        $chart = Chart::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        switch ($request->action) {
            case 'increase':
                $chart->increment('quantity');
                break;
            case 'decrease':
                if ($chart->quantity > 1) {
                    $chart->decrement('quantity');
                } else {
                    $chart->delete();
                }
                break;
            case 'remove':
                $chart->delete();
                break;
        }

        $count = Auth::user()->charts()->count();
        $totalItems = Auth::user()->charts()->sum('quantity');

        return response()->json([
            'success' => true,
            'item_count' => $count,
            'total_items' => $totalItems
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'kode_menu' => 'required|exists:menus,kode_menu',
            'quantity' => 'required|integer|min:1'
        ]);

        $chart = Chart::firstOrNew([
            'user_id' => Auth::id(),
            'kode_menu' => $request->kode_menu
        ]);

        $chart->quantity += $request->quantity;
        $chart->save();

        $menu = Menu::find($request->kode_menu);
        $totalItems = Auth::user()->charts()->sum('quantity');

        return response()->json([
            'success' => true,
            'total_items' => $totalItems,
            'menu_name' => $menu->nama_menu,
            'quantity' => $request->quantity
        ]);
    }

    public function getCartCount()
    {
        $totalItems = Auth::user()->charts()->sum('quantity');

        return response()->json([
            'success' => true,
            'total_items' => $totalItems
        ]);
    }

public function checkout(Request $request)
{
    $items = Auth::user()->charts()->with('menu')->get();

    if ($items->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang belanja kosong');
    }

    // Validasi pilihan dine_in atau takeaway
    $request->validate([
        'type_pesanan' => 'required|in:dine_in,takeaway',
        'meja_id' => 'required_if:type_pesanan,dine_in|exists:mejas,id'
    ]);

    $typePesanan = $request->input('type_pesanan');
    $mejaId = null;

    if ($typePesanan === 'dine_in') {
        $mejaId = $request->input('meja_id');
        
        // Tandai meja sebagai "reserved"
        $meja = \App\Models\Meja::find($mejaId);
        $meja->update(['ketersediaan' => 'reserved']);
    }

    // Hitung subtotal
    $subtotal = $items->sum(function ($item) {
        return $item->quantity * $item->menu->harga;
    });

    // Buat order
    $order = Auth::user()->orders()->create([
        'total_price' => $subtotal,
        'type_pesanan' => $typePesanan,
        'meja_id' => $mejaId
    ]);

    // Simpan detail pesanan
    foreach ($items as $item) {
        $order->orderDetails()->create([
            'kode_menu' => $item->kode_menu,
            'quantity' => $item->quantity,
            'price' => $item->menu->harga
        ]);
    }

    // Kosongkan keranjang belanja
    Auth::user()->charts()->delete();

    return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat');
}

    public function clear()
    {
        Auth::user()->charts()->delete();
        return redirect()->back()->with('success', 'Keranjang belanja sudah kosong!');
    }
}