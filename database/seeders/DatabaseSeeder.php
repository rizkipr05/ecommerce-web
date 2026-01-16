<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = \App\Models\User::query()->firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => \App\Models\User::ROLE_ADMIN,
            ]
        );

        $seller = \App\Models\User::query()->firstOrCreate(
            ['email' => 'seller@gmail.com'],
            [
                'name' => 'Seller UMKM',
                'password' => \Illuminate\Support\Facades\Hash::make('seller123'),
                'role' => \App\Models\User::ROLE_SELLER,
            ]
        );

        $customer = \App\Models\User::query()->firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Customer UMKM',
                'password' => \Illuminate\Support\Facades\Hash::make('customer123'),
                'role' => \App\Models\User::ROLE_CUSTOMER,
            ]
        );

        $kategoriNasi = \App\Models\Category::query()->firstOrCreate(
            ['slug' => 'nasi-bakar'],
            [
                'name' => 'Nasi Bakar',
                'description' => 'Aneka nasi bakar UMKM.',
                'is_active' => true,
            ]
        );

        \App\Models\Product::query()->firstOrCreate(
            ['slug' => 'nasi-bakar-ayam'],
            [
                'seller_id' => $seller->id,
                'category_id' => $kategoriNasi->id,
                'name' => 'Nasi Bakar Ayam',
                'description' => 'Nasi bakar ayam suwir pedas.',
                'price' => 20000,
                'stock' => 50,
                'is_active' => true,
            ]
        );

        \App\Models\Product::query()->firstOrCreate(
            ['slug' => 'nasi-bakar-ikan'],
            [
                'seller_id' => $seller->id,
                'category_id' => $kategoriNasi->id,
                'name' => 'Nasi Bakar Ikan',
                'description' => 'Nasi bakar ikan bumbu kemangi.',
                'price' => 22000,
                'stock' => 40,
                'is_active' => true,
            ]
        );
    }
}
