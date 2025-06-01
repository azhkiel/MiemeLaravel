<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Chart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        $menu = $chart->menu;
        $totalItems = Auth::user()->charts()->sum('quantity');

        return response()->json([
            'success' => true,
            'total_items' => $totalItems,
            'menu_name' => $menu->nama_menu,
            'quantity' => $request->quantity
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

    public function clear()
    {
        Auth::user()->charts()->delete();
        return redirect()->back()->with('success', 'Keranjang belanja sudah kosong!');
    }
}
