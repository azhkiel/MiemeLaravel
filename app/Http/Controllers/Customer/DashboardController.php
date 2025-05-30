<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $menus = Menu::all()->groupBy('kategori');
        $cartCount = Auth::user()->charts()->sum('quantity');

        return view('dashboard.customer.dashboard', [
            'menus' => $menus,
            'cartCount' => $cartCount
        ]);
    }
    public function menu()
    {
        $menus = Menu::all()->groupBy('kategori');
        $cartCount = Auth::user()->charts()->sum('quantity');

        return view('dashboard.customer.menu', [
            'menus' => $menus,
            'cartCount' => $cartCount
        ]);
    }
}