<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            [
                'kodemenu'=>'MKN001',
                'namamenu'=>'Nasi Ayam Kecap',
                'harga'=>10000,
                'kategori'=>'makanan',
                'deskripsi'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque enim mollitia odit, quaerat laboriosam commodi iure quisquam cumque explicabo quibusdam esse quo magni totam. Amet eligendi totam consequuntur repellendus deleniti.', 
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'kodemenu'=>'MNM001',
                'namamenu'=>'Es Teh',
                'harga'=>5000,
                'kategori'=>'minuman',
                'deskripsi'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque enim mollitia odit, quaerat laboriosam commodi iure quisquam cumque explicabo quibusdam esse quo magni totam. Amet eligendi totam consequuntur repellendus deleniti.', 
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'kodemenu'=>'DST001',
                'namamenu'=>'Pudding',
                'harga'=>15000,
                'kategori'=>'dessert', 
                'deskripsi'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque enim mollitia odit, quaerat laboriosam commodi iure quisquam cumque explicabo quibusdam esse quo magni totam. Amet eligendi totam consequuntur repellendus deleniti.', 
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ];
        DB::table('menu')->insert($menu);
    }
}
