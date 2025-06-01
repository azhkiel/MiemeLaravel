<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mejas = [
            [
                'nomor_meja' => 'A1',
                'kapasitas' => 4,
                'ketersediaan' => 'available',
            ],
            [
                'nomor_meja' => 'A2',
                'kapasitas' => 2,
                'ketersediaan' => 'available',
            ],
            [
                'nomor_meja' => 'B1',
                'kapasitas' => 6,
                'ketersediaan' => 'available',
            ],
            [
                'nomor_meja' => 'B2',
                'kapasitas' => 4,
                'ketersediaan' => 'available',
            ],
            [
                'nomor_meja' => 'C1',
                'kapasitas' => 8,
                'ketersediaan' => 'available',
            ],
            [
                'nomor_meja' => 'VIP1',
                'kapasitas' => 10,
                'ketersediaan' => 'available',
            ]
            // Tambahkan meja lain sesuai kebutuhan
        ];

        foreach ($mejas as $meja) {
            Meja::create($meja);
        }
    }
}
