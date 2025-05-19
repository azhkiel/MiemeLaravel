<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $menu = menu::all();
        return view('landing',compact('menu'));
    }
}
