<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\Meja::create([
        'nomor_meja' => 'A1',
        'kapasitas' => 4,
        'ketersediaan' => 'available'
    ]);

    \App\Models\Meja::create([
        'nomor_meja' => 'A2',
        'kapasitas' => 2,
        'ketersediaan' => 'available'
    ]);

    \App\Models\Meja::create([
        'nomor_meja' => 'B1',
        'kapasitas' => 6,
        'ketersediaan' => 'available'
    ]);
}

}
