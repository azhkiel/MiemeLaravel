<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'mejas'; // Nama tabel jika berbeda dengan nama model (Meja)

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'ketersediaan',
    ];

    /**
     * Relasi Meja ke Pesanan (Order).
     * Seorang meja dapat berhubungan dengan banyak pesanan.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'meja_id'); // pastikan 'meja_id' adalah foreign key di tabel 'orders'
    }
}
