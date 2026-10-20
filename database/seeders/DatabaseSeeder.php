<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // ADMIN
        // =========================
        User::create([
            'name' => 'Admin Sisa.in',
            'email' => 'admin@sisa.in',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // =========================
        // CUSTOMER
        // =========================
        User::create([
            'name' => 'Customer Sisa.in',
            'email' => 'customer@sisa.in',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // =========================
        // MERCHANT USER
        // =========================
        $merchantUser = User::create([
            'name' => 'Merchant Sisa.in',
            'email' => 'merchant@sisa.in',
            'password' => Hash::make('password'),
            'role' => 'merchant',
        ]);

        // =========================
        // MERCHANT
        // =========================
        $merchant = Merchant::create([
            'user_id' => $merchantUser->id,
            'business_name' => 'Kantin Sisa.in',
            'description' => 'Kantin yang menyediakan makanan surplus layak konsumsi.',
            'phone' => '08123456789',
            'address' => 'Area Kampus Universitas Jember',
        ]);

        // =========================
        // CATEGORIES
        // =========================
        $makananBerat = Category::create([
            'name' => 'Makanan Berat',
            'description' => 'Berbagai makanan utama yang mengenyangkan.',
        ]);

        $snack = Category::create([
            'name' => 'Snack',
            'description' => 'Makanan ringan dan camilan.',
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'description' => 'Berbagai jenis minuman.',
        ]);

        // =========================
        // PRODUCTS
        // =========================

        // Produk 1
        Product::create([
            'merchant_id' => $merchant->id,
            'category_id' => $makananBerat->id,
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng dengan telur dan sayuran.',
            'normal_price' => 15000,
            'surplus_price' => 10000,
            'stock' => 5,
            'pickup_start' => '17:00',
            'pickup_end' => '19:00',
            'status' => 'available',
        ]);

        // Produk 2
        Product::create([
            'merchant_id' => $merchant->id,
            'category_id' => $makananBerat->id,
            'name' => 'Nasi Ayam',
            'description' => 'Nasi dengan ayam dan lauk pendamping.',
            'normal_price' => 18000,
            'surplus_price' => 12000,
            'stock' => 4,
            'pickup_start' => '17:00',
            'pickup_end' => '19:00',
            'status' => 'available',
        ]);

        // Produk 3
        Product::create([
            'merchant_id' => $merchant->id,
            'category_id' => $snack->id,
            'name' => 'Roti Cokelat',
            'description' => 'Roti lembut dengan isian cokelat.',
            'normal_price' => 10000,
            'surplus_price' => 6000,
            'stock' => 8,
            'pickup_start' => '16:00',
            'pickup_end' => '19:00',
            'status' => 'available',
        ]);

        // Produk 4
        Product::create([
            'merchant_id' => $merchant->id,
            'category_id' => $minuman->id,
            'name' => 'Es Teh',
            'description' => 'Es teh manis segar.',
            'normal_price' => 5000,
            'surplus_price' => 3000,
            'stock' => 10,
            'pickup_start' => '16:00',
            'pickup_end' => '19:00',
            'status' => 'available',
        ]);
    }
}
