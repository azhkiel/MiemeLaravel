<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->insert([
            // Makanan (Relevan dengan Mie)
            [
                'kode_menu' => 'MKN001',
                'nama_menu' => 'Mie Ramen',
                'harga' => 15000,
                'kategori' => 'makanan',
                'deskripsi' => 'Mie ramen dengan kuah gurih dan topping telur, ayam, dan sayuran.',
                'gambar' => 'menu-images/MKN001_mie-ramen_makanan_15000.jpg',
            ],
            [
                'kode_menu' => 'MKN002',
                'nama_menu' => 'Mie Goreng Special',
                'harga' => 18000,
                'kategori' => 'makanan',
                'deskripsi' => 'Mie goreng dengan ayam, udang, sayuran, dan bumbu khas yang lezat.',
                'gambar' => 'menu-images/MKN002_mie-goreng-special_makanan_18000.jpg',
            ],
            [
                'kode_menu' => 'MKN003',
                'nama_menu' => 'Mie Ayam',
                'harga' => 12000,
                'kategori' => 'makanan',
                'deskripsi' => 'Mie dengan potongan ayam, sawi, dan kuah kaldu yang gurih.',
                'gambar' => 'menu-images/MKN003_mie-ayam_makanan_12000.jpg',
            ],
            [
                'kode_menu' => 'MKN004',
                'nama_menu' => 'Mie Pedas',
                'harga' => 13000,
                'kategori' => 'makanan',
                'deskripsi' => 'Mie dengan rasa pedas yang menggigit, dilengkapi dengan topping ayam dan sayuran.',
                'gambar' => 'menu-images/MKN004_mie-pedas_makanan_13000.jpg',
            ],
            [
                'kode_menu' => 'MKN005',
                'nama_menu' => 'Mie Kuah Tom Yum',
                'harga' => 16000,
                'kategori' => 'makanan',
                'deskripsi' => 'Mie dengan kuah tom yum yang segar dan pedas, dilengkapi dengan udang dan sayuran.',
                'gambar' => 'menu-images/MKN005_mie-kuah-tom-yum_makanan_16000.jpg',
            ],

            // Minuman
            [
                'kode_menu' => 'MNM001',
                'nama_menu' => 'Es Teh Manis',
                'harga' => 5000,
                'kategori' => 'minuman',
                'deskripsi' => 'Minuman teh manis dingin yang menyegarkan.',
                'gambar' => 'menu-images/MNM001_es-teh-manis_minuman_5000.jpg',
            ],
            [
                'kode_menu' => 'MNM002',
                'nama_menu' => 'Jus Jeruk Segar',
                'harga' => 10000,
                'kategori' => 'minuman',
                'deskripsi' => 'Jus jeruk segar dengan rasa manis alami.',
                'gambar' => 'menu-images/MNM002_jus-jeruk-segar_minuman_10000.jpg',
            ],
            [
                'kode_menu' => 'MNM003',
                'nama_menu' => 'Es Campur',
                'harga' => 15000,
                'kategori' => 'minuman',
                'deskripsi' => 'Kopi hitam tanpa gula, rasa pahit yang khas.',
                'gambar' => 'menu-images/MNM003_es-campur_minuman_15000.jpg',
            ],

            // Dessert
            [
                'kode_menu' => 'DST001',
                'nama_menu' => 'Kue Strawberry',
                'harga' => 8000,
                'kategori' => 'dessert',
                'deskripsi' => 'Kue lembut dengan rasa strawberry yang segar.',
                'gambar' => 'menu-images/DST001_kue-strawberry_dessert_8000.jpg',
            ],
            [
                'kode_menu' => 'DST002',
                'nama_menu' => 'Puding Coklat',
                'harga' => 9000,
                'kategori' => 'dessert',
                'deskripsi' => 'Puding coklat manis dan lembut, cocok untuk pencuci mulut.',
                'gambar' => 'menu-images/DST002_puding-coklat_dessert_9000.jpg',
            ],
        ]);
    }
}
