<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'mejas'; // pastikan nama tabel benar

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'ketersediaan',
    ];

    // Relasi ke Order (jika 1 meja bisa punya banyak order)
    public function orders()
    {
        return $this->hasMany(Order::class, 'meja_id');
    }

    // Scope untuk meja available
    public function scopeAvailable($query)
    {
        return $query->where('ketersediaan', 'available');
    }
}
