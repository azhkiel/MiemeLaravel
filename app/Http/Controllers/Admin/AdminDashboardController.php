<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $menus = Menu::all()->groupBy('kategori');
        $cartCount = Auth::user()->charts()->sum('quantity');
        $user = Auth::user();

        return view('dashboard.admin.dashboard', [
            'menus' => $menus,
            'cartCount' => $cartCount,
            'user' => $user
        ]);
        return view('components.sidebar',compact('user'));
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
}