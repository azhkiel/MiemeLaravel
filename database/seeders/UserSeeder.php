<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk Admin
        User::create([
            'username' => 'admin',
            'fullname' => 'Admin User',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('123456'),
        ]);

        // Seeder untuk Owner
        User::create([
            'username' => 'owner',
            'fullname' => 'Owner User',
            'phone' => '089876543210',
            'role' => 'owner',
            'password' => Hash::make('123456'),
        ]);

        // Seeder untuk Staff
        User::create([
            'username' => 'sofi',
            'fullname' => 'Staff User',
            'phone' => '085123456789',
            'role' => 'staff',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'username' => 'putri',
            'fullname' => 'Staff User',
            'phone' => '085123456789',
            'role' => 'staff',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'username' => 'resti',
            'fullname' => 'Resti Anggraini',
            'phone' => '085123456789',
            'role' => 'customer',
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'username' => 'asep',
            'fullname' => 'Ahnaf Sofian EKa Putra',
            'phone' => '085123456789',
            'role' => 'customer',
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'username' => 'el',
            'fullname' => 'Moch Azriel Maulana Racmadhani',
            'phone' => '085123456789',
            'role' => 'customer',
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'username' => 'afrida',
            'fullname' => 'Afrida Eka Putri Prasetya',
            'phone' => '085123456789',
            'role' => 'customer',
            'password' => Hash::make('123456'),
        ]);
    }
}
