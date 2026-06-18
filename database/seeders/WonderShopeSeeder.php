<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WonderShopeSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key constraints during seeding to safely clear tables
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        OrderItem::truncate();
        Order::truncate();
        \App\Models\ProductVariant::truncate();
        Product::truncate();
        User::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // ==========================================
        // 1. DATA USER DUMMY (Ready to Use)
        // ==========================================
        $superadmin = User::create([
            'name' => 'Wira Super Admin',
            'email' => 'superadmin@wondershope.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        $admin = User::create([
            'name' => 'Rahmad Admin',
            'email' => 'admin@wondershope.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@wondershope.com',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        $budi = User::create([
            'name' => 'Budi Santoso (Gmail)',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'member',
        ]);

        // ==========================================
        // 2. DATA PRODUK DUMMY
        // ==========================================
        $produk1 = Product::create([
            'name' => 'PlayStation PULSE Elite Wireless Headset',
            'slug' => Str::slug('PlayStation PULSE Elite Wireless Headset'),
            'brand' => 'Sony',
            'description' => 'Headset gaming wireless premium dengan kualitas audio lossless.',
            'base_price' => 2500000,
            'image' => '1781550825_PlayStation PULSE Elite Wireless Headset.jpg'
        ]);

        $produk1->variants()->create([
            'nama_varian' => 'Default Edition',
            'stok' => 15,
        ]);
        $produk1->variants()->create([
            'nama_varian' => 'White Edition',
            'stok' => 10,
        ]);

        $produk2 = Product::create([
            'name' => 'GravaStar Mercury K1 75% Mechanical Keyboard',
            'slug' => Str::slug('GravaStar Mercury K1 75 Mechanical Keyboard'),
            'brand' => 'GravaStar',
            'description' => 'Keyboard mekanikal dengan desain exoskelett aluminium yang futuristik.',
            'base_price' => 3200000,
            'image' => '1781535103_Angebot_ GravaStar Mercury K1 75% Mechanische Gaming-Tastatur.jpg'
        ]);

        $produk2->variants()->create([
            'nama_varian' => 'RGB Linear Switch',
            'stok' => 8,
        ]);
        $produk2->variants()->create([
            'nama_varian' => 'Clicky Blue Switch',
            'stok' => 5,
        ]);

        $produk3 = Product::create([
            'name' => 'ASUS ROG Zephyrus G14 Gaming Laptop',
            'slug' => Str::slug('ASUS ROG Zephyrus G14 Gaming Laptop'),
            'brand' => 'ASUS',
            'description' => 'Laptop gaming tipis dan kuat dengan layar ROG Nebula Display.',
            'base_price' => 28000000,
            'image' => '1781539426_ASUS unveiled new ROG Zephyrus G14 and G16 laptops___.jpg'
        ]);

        $produk3->variants()->create([
            'nama_varian' => 'RTX 4060 / 16GB',
            'stok' => 5,
        ]);
        $produk3->variants()->create([
            'nama_varian' => 'RTX 4070 / 32GB',
            'stok' => 3,
        ]);

        // Tambah produk dummy baru dengan fallback gambar Unsplash
        $produk4 = Product::create([
            'name' => 'Logitech G Pro X Superlight 2 Wireless Mouse',
            'slug' => Str::slug('Logitech G Pro X Superlight 2 Wireless Mouse'),
            'brand' => 'Logitech',
            'description' => 'Mouse gaming wireless legendaris super ringan dengan sensor HERO 2 dan polling rate tinggi.',
            'base_price' => 2100000,
            'image' => null // Menggunakan fallback Unsplash
        ]);
        $produk4->variants()->create(['nama_varian' => 'Black', 'stok' => 20]);
        $produk4->variants()->create(['nama_varian' => 'White', 'stok' => 12]);
        $produk4->variants()->create(['nama_varian' => 'Magenta', 'stok' => 5]);

        $produk5 = Product::create([
            'name' => 'SteelSeries Arctis Nova Pro Wireless Headset',
            'slug' => Str::slug('SteelSeries Arctis Nova Pro Wireless Headset'),
            'brand' => 'SteelSeries',
            'description' => 'Headset gaming wireless terbaik dengan Active Noise Cancellation dan dual battery system.',
            'base_price' => 5800000,
            'image' => null // Menggunakan fallback Unsplash
        ]);
        $produk5->variants()->create(['nama_varian' => 'PC / PlayStation', 'stok' => 7]);
        $produk5->variants()->create(['nama_varian' => 'Xbox Edition', 'stok' => 4]);

        // ==========================================
        // 3. DATA TRANSAKSI / ORDER DUMMY
        // ==========================================
        
        // --- TRANSAKSI A: STATUS SELESAI ---
        $orderSelesai = Order::create([
            'user_id' => $user->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'metode_bayar' => 'Transfer Bank',
            'total_harga' => 5700000, 
            'status' => 'selesai',
            'created_at' => now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $orderSelesai->id,
            'product_name' => $produk1->name,
            'variant_name' => 'Default Edition',
            'quantity' => 1,
            'price' => 2500000,
        ]);

        OrderItem::create([
            'order_id' => $orderSelesai->id,
            'product_name' => $produk2->name,
            'variant_name' => 'RGB Linear Switch',
            'quantity' => 1,
            'price' => 3200000,
        ]);


        // --- TRANSAKSI B: STATUS DIPROSES ---
        $orderDiproses = Order::create([
            'user_id' => $user->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'metode_bayar' => 'COD',
            'total_harga' => 28000000,
            'status' => 'diproses',
            'created_at' => now()->subHours(5),
        ]);

        OrderItem::create([
            'order_id' => $orderDiproses->id,
            'product_name' => $produk3->name,
            'variant_name' => 'RTX 4060 / 16GB',
            'quantity' => 1,
            'price' => 28000000,
        ]);


        // --- TRANSAKSI C: STATUS DIKIRIM ---
        $orderDikirim = Order::create([
            'user_id' => $user->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'metode_bayar' => 'Transfer Bank',
            'total_harga' => 2500000,
            'status' => 'dikirim',
            'created_at' => now()->subDays(1),
        ]);

        OrderItem::create([
            'order_id' => $orderDikirim->id,
            'product_name' => $produk1->name,
            'variant_name' => 'White Edition',
            'quantity' => 1,
            'price' => 2500000,
        ]);


        // --- TRANSAKSI D: STATUS RETUR ---
        $orderRetur = Order::create([
            'user_id' => $user->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'metode_bayar' => 'Transfer Bank',
            'total_harga' => 3200000,
            'status' => 'retur',
            'created_at' => now()->subDays(4),
        ]);

        OrderItem::create([
            'order_id' => $orderRetur->id,
            'product_name' => $produk2->name,
            'variant_name' => 'Clicky Blue Switch',
            'quantity' => 1,
            'price' => 3200000,
        ]);


        // --- TRANSAKSI E: STATUS BATAL ---
        $orderBatal = Order::create([
            'user_id' => $user->id,
            'nama_penerima' => 'Budi Santoso',
            'telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'metode_bayar' => 'Transfer Bank',
            'total_harga' => 2100000,
            'status' => 'batal',
            'created_at' => now()->subDays(2),
        ]);

        OrderItem::create([
            'order_id' => $orderBatal->id,
            'product_name' => $produk4->name,
            'variant_name' => 'Black',
            'quantity' => 1,
            'price' => 2100000,
        ]);
    }
}