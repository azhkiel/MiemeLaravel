<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'fullname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);


        User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'role' => 'customer', 
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat.');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
        $remember = $request->filled('remember'); // cek apakah checkbox "remember" d   icentang

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            return redirect()->intended(route($user->role . '.dashboard'));
        }

        return back()->with('error', 'Username atau password salah.');
    }


    public function logout() {
        Auth::logout();
        return redirect()->route('index');
    }
}
