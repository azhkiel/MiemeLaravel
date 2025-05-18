<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\delete;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = menu::all();
        return view('menu',compact('menu'));
    }

    public function store(Request $request)
    {
        // Validasi dengan pesan custom
        $validated = $request->validate([
            'kodemenu' => 'required|unique:menu,kodemenu',
            'namamenu' => 'required|max:255|regex:/^[\pL\s]+$/u',
            'harga' => 'required|numeric|min:1000',
            'kategori' => 'required|in:makanan,minuman,dessert',
            'deskripsi' => 'required',
            'gambar' => 'required'
        ], [
            'kodemenu.required' => 'Kode menu wajib diisi',
            'kodemenu.unique' => 'Kode menu sudah digunakan',
            'namamenu.required' => 'Nama menu wajib diisi',
            'namamenu.max' => 'Nama menu maksimal 255 karakter',
            'namamenu.regex' => 'Nama menu hanya boleh mengandung huruf dan spasi',
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
                $path = $request->file('gambar')->store('menu-images', 'public');
                $validated['gambar'] = $path;
            }
            Menu::create($validated);
            return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $menu = menu::all();
        $menuShow = menu::findOrfail($id);
        return view('menu',compact('menu','menuShow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Custom validation messages
        $messages = [
            'kodemenu.required' => 'Kode menu wajib diisi',
            'kodemenu.unique' => 'Kode menu sudah digunakan',
            'namamenu.required' => 'Nama menu wajib diisi',
            'namamenu.max' => 'Nama menu maksimal 255 karakter',
            'namamenu.regex' => 'Nama menu hanya boleh mengandung huruf dan spasi',
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
            'kodemenu' => 'required|unique:menu,kodemenu,'.$id,
            'namamenu' => 'required|max:255|regex:/^[\pL\s]+$/u',
            'harga' => 'required|numeric|min:1000',
            'kategori' => 'required|in:makanan,minuman,dessert',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], $messages);

        try {
            $menuShow = Menu::findOrFail($id);
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menuShow->gambar) {
                Storage::disk('public')->delete($menuShow->gambar);
            }
            
            $path = $request->file('gambar')->store('menu-images', 'public');
            $validated['gambar'] = $path;
        }
        
        $menuShow->update($validated);
            return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui menu: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menuShow = Menu::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($menuShow->gambar) {
            Storage::disk('public')->delete($menuShow->gambar);
        }
        $menuShow -> delete(); 
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
