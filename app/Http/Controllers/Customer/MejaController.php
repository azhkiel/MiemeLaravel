<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function makeAvailable($id)
    {
        // Cari meja dan pastikan meja ada
        $meja = Meja::findOrFail($id);

        // Pastikan meja belum tersedia, kalau sudah, beri notifikasi
        if ($meja->ketersediaan === 'available') {
            return back()->with('warning', 'Meja ' . $meja->nomor_meja . ' sudah tersedia!');
        }

        // Update status meja menjadi 'available'
        $meja->update(['ketersediaan' => 'available']);

        return back()->with('success', 'Meja ' . $meja->nomor_meja . ' sekarang sudah available!');
    }
}
