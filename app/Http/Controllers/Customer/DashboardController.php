<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = ['Makanan', 'Minuman', 'Dessert'];
        $menus = Menu::all();
        
        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return view('customer.dashboard', [
            'categories' => $categories,
            'menus' => $menus,
            'total_items' => $cartCount
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'kode_menu' => 'required|exists:menu,kode_menu',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('kode_menu', $request->kode_menu)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'kode_menu' => $request->kode_menu,
                'quantity' => $request->quantity
            ]);
        }

        $totalItems = Cart::where('user_id', Auth::id())->sum('quantity');
        $menuName = Menu::where('kode_menu', $request->kode_menu)->value('nama_menu');

        return response()->json([
            'success' => true,
            'total_items' => $totalItems,
            'menu_name' => $menuName,
            'quantity' => $request->quantity
        ]);
    }

    public function getCartCount()
    {
        $totalItems = Cart::where('user_id', Auth::id())->sum('quantity');
        
        return response()->json([
            'success' => true,
            'total_items' => $totalItems
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}