<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Inventory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'no_telp' => '081234567890',
        ]);

        // 2. Buat Akun Teknisi
        User::create([
            'name' => 'Teknisi Handal',
            'email' => 'teknisi@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'teknisi',
            'no_telp' => '081298765432',
        ]);

        // 3. Buat Akun Pelanggan
        User::create([
            'name' => 'Pelanggan Setia',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '081122334455',
        ]);

        // 4. Buat Stok Part (Inventory)
        $parts = [
            ['nama_part' => 'Kipas Laptop Asus', 'jenis' => 'Kipas Laptop', 'stok' => 10, 'harga_satuan' => 150000],
            ['nama_part' => 'Thermal Paste', 'jenis' => 'Thermal Paste', 'stok' => 50, 'harga_satuan' => 50000],
            ['nama_part' => 'LCD HP Samsung', 'jenis' => 'LCD HP', 'stok' => 5, 'harga_satuan' => 450000],
            ['nama_part' => 'Motherboard Laptop', 'jenis' => 'Motherboard', 'stok' => 2, 'harga_satuan' => 1200000],
        ];

        foreach ($parts as $part) {
            Inventory::create($part);
        }
    }
}