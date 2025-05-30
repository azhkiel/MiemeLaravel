<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user()
    {
        $staffs = User::where('role', 'staff')->get();
        $customers = User::where('role', 'customer')->get();
        return view('dashboard.owner.user', compact('staffs', 'customers'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'fullname' => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:staff,customer',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'phone'    => $validated['phone'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($user, 201); // status 201 = Created
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'fullname' => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:staff,customer',
        ]);

        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted.']);
    }

}
