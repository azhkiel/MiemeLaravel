<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $primaryKey = 'kode_menu';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_menu',
        'nama_menu',
        'harga',
        'kategori',
        'deskripsi',
        'gambar'
    ];

    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class, 'kode_menu', 'kode_menu');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'kode_menu', 'kode_menu');
    }
}