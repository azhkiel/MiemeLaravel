<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'kode_menu' => 'MKN001',
                'nama_menu' => 'Mie Ramen',
                'harga' => 15000,
                'kategori' => 'makanan',
                'deskripsi' => 'Nasi goreng khas Indonesia dengan topping lengkap.',
                'gambar' => 'menu-images/MKN001_mie-ramen_makanan_15000.jpg',
            ],
            [
                'kode_menu' => 'MNM001',
                'nama_menu' => 'Es Teh',
                'harga' => 5000,
                'kategori' => 'minuman',
                'deskripsi' => 'Minuman teh segar dengan rasa manis.',
                'gambar' => 'menu-images/MNM001_es-teh_minuman_10000.jpg',
            ],
            [
                'kode_menu' => 'DST001',
                'nama_menu' => 'Kue Strawberry',
                'harga' => 8000,
                'kategori' => 'dessert',
                'deskripsi' => 'Puding coklat manis dan lembut.',
                'gambar' => 'menu-images/DST001_strawberry-cake_dessert_18000.jpg',
            ],
        ]);
    }
}
