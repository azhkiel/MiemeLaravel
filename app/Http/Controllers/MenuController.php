<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\delete;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menu = menu::all();
        return view('dashboard.owner.menu',compact('menu'));
    }

    public function store(Request $request)
    {
        // Validasi dengan pesan custom
        $validated = $request->validate([
            'kode_menu' => 'required|unique:menus,kode_menu',
            'nama_menu' => 'required|max:255|regex:/^[\pL\s]+$/u',
            'harga' => 'required|numeric|min:1000',
            'kategori' => 'required|in:makanan,minuman,dessert',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'kode_menu.required' => 'Kode menu wajib diisi',
            'kode_menu.unique' => 'Kode menu sudah digunakan',
            'nama_menu.required' => 'Nama menu wajib diisi',
            'nama_menu.max' => 'Nama menu maksimal 255 karakter',
            'nama_menu.regex' => 'Nama menu hanya boleh mengandung huruf dan spasi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal Rp 1.000',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            if ($request->hasFile('gambar')) {
                $ext = $request->file('gambar')->getClientOriginalExtension();
                $slugName = Str::slug($request->nama_menu);
                $filename = "{$request->kode_menu}_{$slugName}_{$request->kategori}_{$request->harga}.{$ext}";
                $path = $request->file('gambar')->storeAs('menu-images', $filename, 'public');
                $validated['gambar'] = $path;
            }
            Menu::create($validated);
            return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
        }
    }

    public function edit(string $kodeMenu)
    {
        $menu = menu::all();
        $menuShow = Menu::where('kode_menu', $kodeMenu)->firstOrFail();
        return view('dashboard.owner.menu',compact('menu','menuShow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kodeMenu)
    {
        // Custom validation messages
        $messages = [
            'kode_menu.required' => 'Kode menu wajib diisi',
            'kode_menu.unique' => 'Kode menu sudah digunakan',
            'nama_menu.required' => 'Nama menu wajib diisi',
            'nama_menu.max' => 'Nama menu maksimal 255 karakter',
            'nama_menu.regex' => 'Nama menu hanya boleh mengandung huruf dan spasi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal Rp 1.000',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'gambar.max' => 'Ukuran gambar maksimal 2MB'
        ];

        // Validation rules
        $validated = $request->validate([
            'kode_menu' => 'required|unique:menus,kode_menu,'.$kodeMenu,
            'nama_menu' => 'required|max:255|regex:/^[\pL\s]+$/u',
            'harga' => 'required|numeric|min:1000',
            'kategori' => 'required|in:makanan,minuman,dessert',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], $messages);

        try {
            $menuShow = Menu::where('kode_menu', $kodeMenu)->firstOrFail();
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menuShow->gambar) {
                Storage::disk('public')->delete($menuShow->gambar);
            }
            
            $ext = $request->file('gambar')->getClientOriginalExtension();
            $slugName = Str::slug($request->nama_menu);
            $filename = "{$request->kode_menu}_{$slugName}_{$request->kategori}_{$request->harga}.{$ext}";
            $path = $request->file('gambar')->storeAs('menu-images', $filename, 'public');
            $validated['gambar'] = $path;

        }
        
        $menuShow->update($validated);
            return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
        }
    }
    public function destroy(string $kodeMenu)
    {
        $menuShow = Menu::where('kode_menu', $kodeMenu)->firstOrFail();
        
        // Hapus gambar jika ada
        if ($menuShow->gambar) {
            Storage::disk('public')->delete($menuShow->gambar);
        }
        $menuShow -> delete(); 
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}